<?php
    // Inicia uma sessão
    session_start();

    // Inclui o arquivo com funções administrativas
    require_once "./functions/admin.php";

    // Define o título da página
    $title = "Listar livros";

    // Inclui o cabeçalho do template
    require_once "./template/header.php";

    // Inclui o arquivo de funções relacionadas ao banco de dados
    require_once "./functions/database_functions.php";

    // Conecta ao banco de dados
    $conn = db_connect();

    // Obtém todos os livros do banco de dados
    $result = getAll($conn);
?>

<!-- Link para adicionar um novo livro -->
<p class="lead"><a href="admin_add.php">Adicionar novo livro</a></p>

<!-- Botão para sair -->
<a href="admin_signout.php" class="btn btn-primary">Sair!</a>

<!-- Tabela para exibir a lista de livros -->
<table class="table" style="margin-top: 20px">
    <tr>
        <th>ISBN</th>
        <th>Título</th>
        <th>Autor</th>
        <th>Imagem</th>
        <th>Descrição</th>
        <th>Preço</th>
        <th>Editora</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
    <!-- Laço para exibir os livros retornados do banco -->
    <?php while($row = mysqli_fetch_assoc($result)){ ?>
    <tr>
        <td><?php echo $row['book_isbn']; ?></td>
        <td><?php echo $row['book_title']; ?></td>
        <td><?php echo $row['book_author']; ?></td>
        <td><?php echo $row['book_image']; ?></td>
        <td><?php echo $row['book_descr']; ?></td>
        <td><?php echo $row['book_price']; ?></td>
        <td><?php echo getPubName($conn, $row['publisherid']); ?></td>
        <!-- Link para editar o livro -->
        <td><a href="admin_edit.php?bookisbn=<?php echo $row['book_isbn']; ?>">Editar</a></td>
        <!-- Link para deletar o livro -->
        <td><a href="admin_delete.php?bookisbn=<?php echo $row['book_isbn']; ?>">Deletar</a></td>
    </tr>
    <?php } ?>
</table>

<?php
    // Fecha a conexão com o banco de dados, se estiver aberta
    if(isset($conn)) { mysqli_close($conn); }

    // Inclui o rodapé do template
    require_once "./template/footer.php";
?>
