<?php
// Inicia a sessão para mensagens de erro ou sucesso
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: #ffffff;
        }
        .register-card h3 {
            color: #0d6efd;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .logo {
            display: block;
            margin: 0 auto;
            width: 216px; /* Ajuste o tamanho da logo conforme necessário */
        }
    </style>
</head>
<body>
    <div class="register-card col-md-4">
        <!-- Logo -->
        <img src="./img/logo.png" alt="Logo" class="logo">
        
        <h3 class="text-center">Crie sua conta</h3>
        
        <!-- Formulário de Registro -->
        <form action="process_register.php" method="POST">
            <div class="form-group mt-3">
                <label for="username" class="form-label">Usuário</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Digite seu usuário" required>
            </div>
            <div class="form-group mt-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Digite seu e-mail" required>
            </div>
            <div class="form-group mt-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Digite sua senha" required>
            </div>
            <div class="form-group mt-3">
                <label for="confirm_password" class="form-label">Confirme sua senha</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirme sua senha" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block mt-4 w-100">Registrar</button>
        </form>
        
        <!-- Link para a tela de login -->
        <div class="text-center mt-3">
            <a href="login.php" class="form-link text-primary">Já tem uma conta? Faça login</a>
        </div>
    </div>
</body>
</html>
