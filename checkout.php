<?php
	// O carrinho de compras precisa de sessões, então inicie uma
	/*
		Array de sessão(
			cart => array (
				book_isbn (obter de $_GET['book_isbn']) => quantidade de livros
			),
			items => 0,
			total_price => '0.00'
		)
	*/
	session_start();
	require_once "./functions/database_functions.php";
	// Exibe o cabeçalho aqui
	$title = "Finalizando Compra";
	require "./template/header.php";

	if(isset($_SESSION['cart']) && (array_count_values($_SESSION['cart']))){
?>
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
			<td><?php echo "R$ " . $book['book_price']; ?></td>
			<td><?php echo $qty; ?></td>
			<td><?php echo "R$ " . $qty * $book['book_price']; ?></td>
		</tr>
		<?php } ?>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><?php echo $_SESSION['total_items']; ?></th>
			<th><?php echo "R$ " . $_SESSION['total_price']; ?></th>
		</tr>
	</table>
	<form method="post" action="purchase.php" class="form-horizontal">
		<?php if(isset($_SESSION['err']) && $_SESSION['err'] == 1){ ?>
			<p class="text-danger">Todos os campos precisam ser preenchidos</p>
			<?php } ?>
		<div class="form-group">
			<label for="name" class="control-label col-md-4">Nome</label>
			<div class="col-md-4">
				<input type="text" name="name" class="col-md-4" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label for="address" class="control-label col-md-4">Endereço</label>
			<div class="col-md-4">
				<input type="text" name="address" class="col-md-4" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label for="city" class="control-label col-md-4">Cidade</label>
			<div class="col-md-4">
				<input type="text" name="city" class="col-md-4" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label for="zip_code" class="control-label col-md-4">CEP</label>
			<div class="col-md-4">
				<input type="text" name="zip_code" class="col-md-4" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label for="country" class="control-label col-md-4">País</label>
			<div class="col-md-4">
				<input type="text" name="country" class="col-md-4" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<input type="submit" name="submit" value="Comprar" class="btn btn-primary">
		</div>
	</form>
	<p class="lead">Por favor, pressione "Comprar" para confirmar sua compra, ou "Continuar comprando" para adicionar ou remover itens.</p>
<?php
	} else {
		echo "<p class=\"text-warning\">Seu carrinho está vazio! Certifique-se de adicionar livros a ele!</p>";
	}
	if(isset($conn)){ mysqli_close($conn); }
	require_once "./template/footer.php";
?>
