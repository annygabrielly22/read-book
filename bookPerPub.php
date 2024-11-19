<?php
  // Inicia a sessão
  session_start();

  // Inclui as funções de banco de dados
  require_once "./functions/database_functions.php";

  // Obtém o ID da editora a partir da URL
  if(isset($_GET['pubid'])){
    $pubid = $_GET['pubid'];
  } else {
    echo "Consulta inválida! Verifique novamente!";
    exit;
  }

  // Conecta ao banco de dados
  $conn = db_connect();
  
  // Obtém o nome da editora com base no ID
  $pubName = getPubName($conn, $pubid);

  // Consulta os livros da editora
  $query = "SELECT book_isbn, book_title, book_image FROM books WHERE publisherid = '$pubid'";
  $result = mysqli_query($conn, $query);
  if(!$result){
    echo "Não foi possível recuperar os dados " . mysqli_error($conn);
    exit;
  }

  // Verifica se não há livros
  if(mysqli_num_rows($result) == 0){
    echo "Sem livros disponíveis! Por favor, aguarde até que novos livros sejam adicionados!";
    exit;
  }

  // Define o título da página
  $title = "Livros por Editora";
  require "./template/header.php";
?>
  <!-- Navegação para voltar à lista de editoras -->
  <p class="lead"><a href="publisher_list.php">Editoras</a> > <?php echo $pubName; ?></p>

  <!-- Exibe os livros da editora -->
  <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <div class="row">
      <div class="col-md-3">
        <!-- Exibe a imagem do livro -->
        <img class="img-responsive img-thumbnail" src="./bootstrap/img/<?php echo $row['book_image'];?>">
      </div>
      <div class="col-md-7">
        <h4><?php echo $row['book_title']; ?></h4>
        <!-- Link para obter os detalhes do livro -->
        <a href="book.php?bookisbn=<?php echo $row['book_isbn'];?>" class="btn btn-primary">Ver Detalhes</a>
      </div>
    </div>
    <br>
  <?php
  }
  // Fecha a conexão com o banco de dados
  if(isset($conn)) { mysqli_close($conn); }

  // Inclui o rodapé do template
  require "./template/footer.php";
?>
