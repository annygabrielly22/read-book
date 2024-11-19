<?php	
	// Se ocorrer uma alteração e for necessário salvar
	if(!isset($_POST['save_change'])){
		echo "Algo deu errado!";
		exit;
	}

	$isbn = trim($_POST['isbn']);
	$titulo = trim($_POST['title']);
	$autor = trim($_POST['author']);
	$descricao = trim($_POST['descr']);
	$preco = floatval(trim($_POST['price']));
	$editora = trim($_POST['publisher']);

	if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
		$imagem = $_FILES['image']['name'];
		$diretorio_atual = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
		$diretorio_upload = $_SERVER['DOCUMENT_ROOT'] . $diretorio_atual . "bootstrap/img/";
		$diretorio_upload .= $imagem;
		move_uploaded_file($_FILES['image']['tmp_name'], $diretorio_upload);
	}

	require_once("./functions/database_functions.php");
	$conn = db_connect();

	// Se a editora não estiver no banco de dados, cria uma nova
	$buscarEditora = "SELECT * FROM publisher WHERE publisher_name = '$editora'";
	$buscarResultado = mysqli_query($conn, $buscarEditora);
	if(!$buscarResultado){
		// Insere na tabela de editoras e retorna o id
		$inserirEditora = "INSERT INTO publisher(publisher_name) VALUES ('$editora')";
		$inserirResultado = mysqli_query($conn, $inserirEditora);
		if(!$inserirResultado){
			echo "Não foi possível adicionar a editora " . mysqli_error($conn);
			exit;
		}
	}

	$query = "UPDATE books SET  
	book_title = '$titulo', 
	book_author = '$autor', 
	book_descr = '$descricao', 
	book_price = '$preco'";
	if(isset($imagem)){
		$query .= ", book_image='$imagem' WHERE book_isbn = '$isbn'";
	} else {
		$query .= " WHERE book_isbn = '$isbn'";
	}

	// Caso haja um arquivo enviado, faz a alteração
	$resultado = mysqli_query($conn, $query);
	if(!$resultado){
		echo "Não foi possível atualizar os dados " . mysqli_error($conn);
		exit;
	} else {
		header("Location: admin_edit.php?bookisbn=$isbn");
	}
?>
