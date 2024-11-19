<?php
	// O carrinho de compras precisa de sessões, então inicie uma
	/*
		Array de sessão(
			carrinho => array (
				book_isbn (obtido de $_POST['book_isbn']) => quantidade de livros
			),
			itens => 0,
			preço_total => '0.00'
		)
	*/
	session_start();
	require_once "./functions/database_functions.php";
	require_once "./functions/cart_functions.php";

	// book_isbn obtido do método POST do formulário, altere este lugar mais tarde.
	if(isset($_POST['bookisbn'])){
		$book_isbn = $_POST['bookisbn'];
	}

	if(isset($book_isbn)){
		// Novo item selecionado
		if(!isset($_SESSION['cart'])){
			// $_SESSION['cart'] é um array associativo onde bookisbn => quantidade
			$_SESSION['cart'] = array();

			$_SESSION['total_items'] = 0;
			$_SESSION['total_price'] = '0.00';
		}

		if(!isset($_SESSION['cart'][$book_isbn])){
			$_SESSION['cart'][$book_isbn] = 1;
		} elseif(isset($_POST['cart'])){
			$_SESSION['cart'][$book_isbn]++;
			unset($_POST);
		}
	}

	// Se o botão de salvar alterações for clicado, muda a quantidade de cada bookisbn
	if(isset($_POST['save_change'])){
		foreach($_SESSION['cart'] as $isbn =>$qty){
			if($_POST[$isbn] == '0'){
				unset($_SESSION['cart']["$isbn"]);
			} else {
				$_SESSION['cart']["$isbn"] = $_POST["$isbn"];
			}
		}
	}

	// Exibe o cabeçalho aqui
	$title = "Seu carrinho de compras";
	require "./template/header.php";

	if(isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))){
		$_SESSION['total_price'] = total_price($_SESSION['cart']);
		$_SESSION['total_items'] = total_items($_SESSION['cart']);
?>
   	<form action="cart.php" method="post">
	   	<table class="table">
	   		<tr>
	   			<th>Item</th>
	   			<th>Preço</th>
	  			<th>Quantidade</th>
	   			<th>Total</th>
	   		</tr>
	   		<?php
		    	foreach($_SESSION['cart'] as $isbn => $qty){
					$conn = db_connect();
					$book = mysqli_fetch_assoc(getBookByIsbn($conn, $isbn));
			?>
			<tr>
				<td><?php echo $book['book_title'] . " de " . $book['book_author']; ?></td>
				<td><?php echo "$" . $book['book_price']; ?></td>
				<td><input type="text" value="<?php echo $qty; ?>" size="2" name="<?php echo $isbn; ?>"></td>
				<td><?php echo "$" . $qty * $book['book_price']; ?></td>
			</tr>
			<?php } ?>
		    <tr>
		    	<th>&nbsp;</th>
		    	<th>&nbsp;</th>
		    	<th><?php echo $_SESSION['total_items']; ?></th>
		    	<th><?php echo "$" . $_SESSION['total_price']; ?></th>
		    </tr>
	   	</table>
	   	<input type="submit" class="btn btn-primary" name="save_change" value="Salvar Alterações">
	</form>
	<br/><br/>
	<a href="checkout.php" class="btn btn-primary">Ir para o Checkout</a> 
	<a href="books.php" class="btn btn-primary">Continuar Comprando</a>
<?php
	} else {
		echo "<p class=\"text-warning\">Seu carrinho está vazio! Por favor, adicione alguns livros!</p>";
	}
	if(isset($conn)){ mysqli_close($conn); }
	require_once "./template/footer.php";
?>
