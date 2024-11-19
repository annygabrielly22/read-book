<?php
    // Inicia a sessão
    session_start();

    // Inclui funções administrativas
    require_once "./functions/admin.php";

    // Define o título da página
    $title = "Adicionar novo livro";

    // Inclui o cabeçalho do template
    require "./template/header.php";

    // Inclui funções relacionadas ao banco de dados
    require "./functions/database_functions.php";

    // Conecta ao banco de dados
    $conn = db_connect();

    // Verifica se o formulário foi enviado
    if(isset($_POST['add'])){
        // Obtém e sanitiza o campo ISBN
        $isbn = trim($_POST['isbn']);
        $isbn = mysqli_real_escape_string($conn, $isbn);

        // Obtém e sanitiza o título do livro
        $title = trim($_POST['title']);
        $title = mysqli_real_escape_string($conn, $title);

        // Obtém e sanitiza o autor
        $author = trim($_POST['author']);
        $author = mysqli_real_escape_string($conn, $author);

        // Obtém e sanitiza a descrição
        $descr = trim($_POST['descr']);
        $descr = mysqli_real_escape_string($conn, $descr);

        // Obtém e sanitiza o preço
        $price = floatval(trim($_POST['price']));
        $price = mysqli_real_escape_string($conn, $price);

        // Obtém e sanitiza a editora
        $publisher = trim($_POST['publisher']);
        $publisher = mysqli_real_escape_string($conn, $publisher);

        // Verifica e processa o envio da imagem, se presente
        if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){
            $image = $_FILES['image']['name'];
            // Determina o diretório de upload
            $directory_self = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
            $uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . $directory_self . "bootstrap/img/";
            $uploadDirectory .= $image;

            // Move o arquivo enviado para o diretório de upload
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadDirectory);
        }

        // Busca a editora no banco de dados
        $findPub = "SELECT * FROM publisher WHERE publisher_name = '$publisher'";
        $findResult = mysqli_query($conn, $findPub);

        if(!$findResult){
            // Se a editora não existe, insere uma nova no banco
            $insertPub = "INSERT INTO publisher(publisher_name) VALUES ('$publisher')";
            $insertResult = mysqli_query($conn, $insertPub);

            if(!$insertResult){
                echo "Erro ao adicionar nova editora: " . mysqli_error($conn);
                exit;
            }

            // Obtém o ID da nova editora
            $publisherid = mysqli_insert_id($conn);
        } else {
            // Obtém o ID da editora existente
            $row = mysqli_fetch_assoc($findResult);
            $publisherid = $row['publisherid'];
        }

        // Insere os dados do livro na tabela
        $query = "INSERT INTO books VALUES ('" . $isbn . "', '" . $title . "', '" . $author . "', '" . $image . "', '" . $descr . "', '" . $price . "', '" . $publisherid . "')";
        $result = mysqli_query($conn, $query);

        if(!$result){
            echo "Erro ao adicionar novo livro: " . mysqli_error($conn);
            exit;
        } else {
            // Redireciona para a página de administração de livros
            header("Location: admin_book.php");
        }
    }
?>

<!-- Formulário para adicionar um novo livro -->
<form method="post" action="admin_add.php" enctype="multipart/form-data">
    <table class="table">
        <tr>
            <th>ISBN</th>
            <td><input type="text" name="isbn"></td>
        </tr>
        <tr>
            <th>Título</th>
            <td><input type="text" name="title" required></td>
        </tr>
        <tr>
            <th>Autor</th>
            <td><input type="text" name="author" required></td>
        </tr>
        <tr>
            <th>Imagem</th>
            <td><input type="file" name="image"></td>
        </tr>
        <tr>
            <th>Descrição</th>
            <td><textarea name="descr" cols="40" rows="5"></textarea></td>
        </tr>
        <tr>
            <th>Preço</th>
            <td><input type="text" name="price" required></td>
        </tr>
        <tr>
            <th>Editora</th>
            <td><input type="text" name="publisher" required></td>
        </tr>
    </table>
    <!-- Botões do formulário -->
    <input type="submit" name="add" value="Adicionar novo livro" class="btn btn-primary">
    <input type="reset" value="Cancelar" class="btn btn-default">
</form>
<br/>

<?php
    // Fecha a conexão com o banco de dados, se aberta
    if(isset($conn)) { mysqli_close($conn); }

    // Inclui o rodapé do template
    require_once "./template/footer.php";
?>
