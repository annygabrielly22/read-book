<?php
    // Inicia uma sessão
    session_start();

    // Inclui o arquivo com funções administrativas
    require_once "./functions/admin.php";

    // Define o título da página
    $title = "Editar livro";

    // Inclui o cabeçalho do template
    require_once "./template/header.php";

    // Inclui o arquivo de funções relacionadas ao banco de dados
    require_once "./functions/database_functions.php";

    // Estabelece uma conexão com o banco de dados
    $conn = db_connect();

    // Verifica se o ISBN do livro foi enviado via URL
    if (isset($_GET['bookisbn'])) {
        $book_isbn = $_GET['bookisbn'];
    } else {
        echo "Consulta vazia!";
        exit;
    }

    // Verifica se o ISBN está vazio
    if (!isset($book_isbn)) {
        echo "ISBN vazio! Verifique novamente!";
        exit;
    }

    // Recupera os dados do livro no banco de dados
    $query = "SELECT * FROM books WHERE book_isbn = '$book_isbn'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Não foi possível recuperar os dados: " . mysqli_error($conn);
        exit;
    }

    // Armazena os dados do livro em um array associativo
    $row = mysqli_fetch_assoc($result);
?>

<!-- Formulário para editar os dados do livro -->
<form method="post" action="edit_book.php" enctype="multipart/form-data">
    <table class="table">
        <tr>
            <th>ISBN</th>
            <!-- Campo apenas para leitura -->
            <td><input type="text" name="isbn" value="<?php echo $row['book_isbn']; ?>" readOnly="true"></td>
        </tr>
        <tr>
            <th>Título</th>
            <td><input type="text" name="title" value="<?php echo $row['book_title']; ?>" required></td>
        </tr>
        <tr>
            <th>Autor</th>
            <td><input type="text" name="author" value="<?php echo $row['book_author']; ?>" required></td>
        </tr>
        <tr>
            <th>Imagem</th>
            <td><input type="file" name="image"></td>
        </tr>
        <tr>
            <th>Descrição</th>
            <td><textarea name="descr" cols="40" rows="5"><?php echo $row['book_descr']; ?></textarea></td>
        </tr>
        <tr>
            <th>Preço</th>
            <td><input type="text" name="price" value="<?php echo $row['book_price']; ?>" required></td>
        </tr>
        <tr>
            <th>Editora</th>
            <td>
                <input type="text" name="publisher" value="<?php echo getPubName($conn, $row['publisherid']); ?>" required>
            </td>
        </tr>
    </table>
    <!-- Botões para salvar alterações ou cancelar -->
    <input type="submit" name="save_change" value="Salvar" class="btn btn-primary">
    <input type="reset" value="Cancelar" class="btn btn-default">
</form>
<br/>
<!-- Link para retornar à lista de livros -->
<a href="admin_book.php" class="btn btn-success">Confirmar</a>

<?php
    // Fecha a conexão com o banco de dados, se estiver aberta
    if (isset($conn)) {
        mysqli_close($conn);
    }

    // Inclui o rodapé do template
    require "./template/footer.php";
?>
