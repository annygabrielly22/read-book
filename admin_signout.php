<?php
    // Inicia uma sessão
    session_start();

    // Encerra a sessão atual
    session_destroy();

    // Redireciona o usuário para a página inicial
    header("Location: index.php");
?>
