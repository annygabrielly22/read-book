<?php
	session_start();

	$_SESSION['err'] = 1;
	foreach($_POST as $key => $value){
		if(trim($value) == ''){
			$_SESSION['err'] = 0;
		}
		break;
	}

	if($_SESSION['err'] == 0){
		header("Location: purchase.php");
	} else {
		unset($_SESSION['err']);
	}

	require_once "./functions/database_functions.php";
	// Exibir cabeçalho
	$title = "Processo de Compra";
	require "./template/header.php";
	// Conectar ao banco de dados
	$conn = db_connect();
	extract($_SESSION['ship']);

	// Validar dados postados
	$card_number = $_POST['card_number'];
	$card_PID = $_POST['card_PID'];
	$card_expire = strtotime($_POST['card_expire']);
	$card_owner = $_POST['card_owner'];

	// Encontrar o cliente
	$customerid = getCustomerId($name, $address, $city, $zip_code, $country);
	if($customerid == null) {
		// Inserir cliente no banco de dados e retornar o customerid
		$customerid = setCustomerId($name, $address, $city, $zip_code, $country);
	}
	$date = date("Y-m-d H:i:s");
	insertIntoOrder($conn, $customerid, $_SESSION['total_price'], $date, $name, $address, $city, $zip_code, $country);

	// Obter orderid da ordem para inserir os itens da ordem
	$orderid = getOrderId($conn, $customerid);

	foreach($_SESSION['cart'] as $isbn => $qty){
		$bookprice = getbookprice($isbn);
		$query = "INSERT INTO order_items VALUES 
		('$orderid', '$isbn', '$bookprice', '$qty')";
		$result = mysqli_query($conn, $query);
		if(!$result){
			echo "Falha ao inserir valor!" . mysqli_error($conn2);
			exit;
		}
	}

	session_unset();
?>
	<p class="lead text-success">Sua compra foi processada com sucesso. Por favor, verifique seu e-mail para obter a confirmação do pedido e os detalhes de envio. 
	Sua sacola foi esvaziada.</p>

<?php
	if(isset($conn)){
		mysqli_close($conn);
	}
	require_once "./template/footer.php";
?>
