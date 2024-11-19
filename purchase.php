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
		header("Location: checkout.php");
	} else {
		unset($_SESSION['err']);
	}

	$_SESSION['ship'] = array();
	foreach($_POST as $key => $value){
		if($key != "submit"){
			$_SESSION['ship'][$key] = $value;
		}
	}
	require_once "./functions/database_functions.php";
	// Exibir cabeçalho aqui
	$title = "Compra";
	require "./template/header.php";
	// Conectar ao banco de dados
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
			<td><?php echo "R$" . $book['book_price']; ?></td>
			<td><?php echo $qty; ?></td>
			<td><?php echo "R$" . $qty * $book['book_price']; ?></td>
		</tr>
		<?php } ?>
		<tr>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><?php echo $_SESSION['total_items']; ?></th>
			<th><?php echo "R$" . $_SESSION['total_price']; ?></th>
		</tr>
		<tr>
			<td>Frete</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>20,00</td>
		</tr>
		<tr>
			<th>Total com Frete</th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
			<th><?php echo "R$" . ($_SESSION['total_price'] + 20); ?></th>
		</tr>
	</table>
	<form method="post" action="process.php" class="form-horizontal">
		<?php if(isset($_SESSION['err']) && $_SESSION['err'] == 1){ ?>
		<p class="text-danger">Todos os campos devem ser preenchidos</p>
		<?php } ?>
        <div class="form-group">
            <label for="card_type" class="col-lg-2 control-label">Tipo</label>
            <div class="col-lg-10">
              	<select class="form-control" name="card_type">
                  	<option value="VISA">VISA</option>
                  	<option value="MasterCard">MasterCard</option>
                  	<option value="American Express">American Express</option>
              	</select>
            </div>
        </div>
        <div class="form-group">
            <label for="card_number" class="col-lg-2 control-label">Número</label>
            <div class="col-lg-10">
              	<input type="text" class="form-control" name="card_number">
            </div>
        </div>
        <div class="form-group">
            <label for="card_PID" class="col-lg-2 control-label">PID</label>
            <div class="col-lg-10">
              	<input type="text" class="form-control" name="card_PID">
            </div>
        </div>
        <div class="form-group">
            <label for="card_expire" class="col-lg-2 control-label">Data de Validade</label>
            <div class="col-lg-10">
              	<input type="date" name="card_expire" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label for="card_owner" class="col-lg-2 control-label">Nome</label>
            <div class="col-lg-10">
              	<input type="text" class="form-control" name="card_owner">
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
              	<button type="reset" class="btn btn-default">Cancelar</button>
              	<button type="submit" class="btn btn-primary">Comprar</button>
            </div>
        </div>
    </form>
	<p class="lead">Por favor, pressione Comprar para confirmar sua compra ou Continuar Comprando para adicionar ou remover itens.</p>
<?php
	} else {
		echo "<p class=\"text-warning\">Seu carrinho está vazio! Por favor, adicione alguns livros a ele!</p>";
	}
	if(isset($conn)){ mysqli_close($conn); }
	require_once "./template/footer.php";
?>
