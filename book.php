<?php
  // Inicia a sessão
  session_start();

  // Obtém o ISBN do livro a partir da URL
  $book_isbn = $_GET['bookisbn'];

  // Conecta ao banco de dados
  require_once "./functions/database_functions.php";
  $conn = db_connect();

  // Consulta o livro com o ISBN fornecido
  $query = "SELECT * FROM books WHERE book_isbn = '$book_isbn'";
  $result = mysqli_query($conn, $query);
  if(!$result){
    echo "Não foi possível recuperar os dados " . mysqli_error($conn);
    exit;
  }

  // Obtém os dados do livro
  $row = mysqli_fetch_assoc($result);
  if(!$row){
    echo "Livro não encontrado";
    exit;
  }

  // Define o título da página com o nome do livro
  $title = $row['book_title'];
  require "./template/header.php";
?>
      <!-- Exemplo de navegação de colunas -->
      <p class="lead" style="margin: 25px 0"><a href="books.php">Livros</a> > <?php echo $row['book_title']; ?></p>
      <div class="row">
        <div class="col-md-3 text-center">
          <!-- Exibe a imagem do livro -->
          <img class="img-responsive img-thumbnail" src="./bootstrap/img/<?php echo $row['book_image']; ?>">
        </div>
        <div class="col-md-6">
          <h4>Descrição do Livro</h4>
          <!-- Exibe a descrição do livro -->
          <p><?php echo $row['book_descr']; ?></p>
          <h4>Detalhes do Livro</h4>
          <table class="table">
          	<?php 
              // Exibe os detalhes do livro, exceto a descrição, imagem e editora
              foreach($row as $key => $value){
                if($key == "book_descr" || $key == "book_image" || $key == "publisherid" || $key == "book_title"){
                  continue;
                }
                // Muda o nome das chaves para nomes mais amigáveis
                switch($key){
                  case "book_isbn":
                    $key = "ISBN";
                    break;
                  case "book_title":
                    $key = "Título";
                    break;
                  case "book_author":
                    $key = "Autor";
                    break;
                  case "book_price":
                    $key = "Preço";
                    break;
                }
            ?>
            <tr>
              <!-- Exibe o nome da chave e o valor correspondente -->
              <td><?php echo $key; ?></td>
              <td><?php echo $value; ?></td>
            </tr>
            <?php 
              } 
              // Fecha a conexão com o banco de dados
              if(isset($conn)) {mysqli_close($conn); }
            ?>
          </table>
          <!-- Formulário para adicionar o livro ao carrinho -->
          <form method="post" action="cart.php">
            <input type="hidden" name="bookisbn" value="<?php echo $book_isbn;?>">
            <input type="submit" value="Comprar / Adicionar ao carrinho" name="cart" class="btn btn-primary">
          </form>
       	</div>
      </div>
<?php
  // Inclui o rodapé do template
  require "./template/footer.php";
?>
