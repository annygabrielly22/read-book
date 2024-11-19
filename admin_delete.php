<?php
    // Obtém o ISBN do livro enviado como parâmetro na URL
    $book_isbn = $_GET['bookisbn'];

    // Inclui o arquivo com funções relacionadas ao banco de dados
    require_once "./functions/database_functions.php";

    // Estabelece uma conexão com o banco de dados
    $conn = db_connect();

    // Define a consulta SQL para deletar o livro com o ISBN fornecido
    $query = "DELETE FROM books WHERE book_isbn = '$book_isbn'";

    // Executa a consulta
    $result = mysqli_query($conn, $query);

    // Verifica se a consulta foi bem-sucedida
    if (!$result) {
        // Exibe uma mensagem de erro caso não seja possível deletar o dado
        echo "Erro ao deletar os dados: " . mysqli_error($conn);
        exit;
    }

    // Redireciona para a página de administração de livros após a exclusão
    header("Location: admin_book.php");
?>
