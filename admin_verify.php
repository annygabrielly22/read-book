<?php
    // Inicia uma sessão
    session_start();

    // Verifica se o formulário foi enviado corretamente
    if (!isset($_POST['submit'])) {
        echo "Algo deu errado! Verifique novamente!";
        exit;
    }

    // Inclui o arquivo de funções relacionadas ao banco de dados
    require_once "./functions/database_functions.php";

    // Conecta ao banco de dados
    $conn = db_connect();

    // Obtém os valores do formulário e remove espaços em branco
    $name = trim($_POST['name']);
    $pass = trim($_POST['pass']);

    // Verifica se os campos de nome ou senha estão vazios
    if ($name == "" || $pass == "") {
        echo "Nome ou senha estão vazios!";
        exit;
    }

    // Escapa caracteres especiais para evitar injeção de SQL
    $name = mysqli_real_escape_string($conn, $name);
    $pass = mysqli_real_escape_string($conn, $pass);

    // Criptografa a senha usando SHA-1
    $pass = sha1($pass);

    // Consulta o banco de dados para obter os dados do administrador
    $query = "SELECT name, pass FROM admin";
    $result = mysqli_query($conn, $query);

    // Verifica se a consulta retornou resultados
    if (!$result) {
        echo "Dados vazios: " . mysqli_error($conn);
        exit;
    }

    // Obtém os dados do administrador
    $row = mysqli_fetch_assoc($result);

    // Verifica se o nome e a senha estão corretos
    if ($name != $row['name'] && $pass != $row['pass']) {
        echo "Nome ou senha estão incorretos. Verifique novamente!";
        $_SESSION['admin'] = false;
        exit;
    }

    // Fecha a conexão com o banco de dados, se aberta
    if (isset($conn)) {
        mysqli_close($conn);
    }

    // Define a sessão do administrador como verdadeira
    $_SESSION['admin'] = true;

    // Redireciona para a página de administração de livros
    header("Location: admin_book.php");
?>
