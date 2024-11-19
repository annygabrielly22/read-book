<?php
session_start();

// Credenciais fictícias para o exemplo
$valid_username = "admin";
$valid_password = "123456";

// Verifica se os dados foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Valida as credenciais
    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['user_logged_in'] = true;
        header("Location: index.php"); // Redireciona para a página inicial
        exit;
    } else {
        header("Location: login.php?error=1"); // Redireciona de volta com erro
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>
