<?php
  session_start();
  $count = 0;
  // Conectar ao banco de dados
  require_once "./functions/database_functions.php";
  $conn = db_connect();

  $query = "SELECT book_isbn, book_image FROM books";
  $result = mysqli_query($conn, $query);
  if(!$result){
    echo "Não foi possível recuperar os dados " . mysqli_error($conn);
    exit;
  }

  $title = "Catálogo Completo de Livros";
  require_once "./template/header.php";
?>
  <p class="lead text-center text-muted">Catálogo Completo de Livros</p>
    <?php for($i = 0; $i < mysqli_num_rows($result); $i++){ ?>
      <div class="row">
        <?php while($query_row = mysqli_fetch_assoc($result)){ ?>
          <div class="col-md-3">
            <a href="book.php?bookisbn=<?php echo $query_row['book_isbn']; ?>">
              <img class="img-responsive img-thumbnail" src="./bootstrap/img/<?php echo $query_row['book_image']; ?>">
            </a>
          </div>
        <?php
          $count++;
          if($count >= 4){
              $count = 0;
              break;
            }
          } ?> 
      </div>
<?php
      }
  if(isset($conn)) { mysqli_close($conn); }
  require_once "./template/footer.php";
?>
