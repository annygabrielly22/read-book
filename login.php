<?php
// Iniciar sessão
session_start();

// Verificar se o usuário já está logado
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    header("Location: index.php"); // Redirecionar para a página principal se já estiver logado
    exit;
}

// Processamento do formulário de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Simulação do processo de login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validar login (Aqui você pode incluir a lógica para validar as credenciais no banco de dados)
    if ($username == "admin" && $password == "12345") { // Exemplo simplificado
        $_SESSION['user_logged_in'] = true;
        header("Location: index.php"); // Redireciona para a página inicial
        exit;
    } else {
        $error_message = "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Livraria Tech</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            max-width: 150px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-primary {
            width: 100%;
        }

        .error-message {
            color: red;
            font-size: 14px;
            text-align: center;
        }

        .login-links {
            text-align: center;
            margin-top: 15px;
        }

        .login-links a {
            color: #007bff;
            text-decoration: none;
        }

        .login-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <!-- Logo -->
        <img src="img/logo.png" alt="Logo da Livraria" class="logo">

        <!-- Formulário de Login -->
        <h2 class="text-center">Login</h2>

        <?php if (isset($error_message)) { ?>
            <div class="error-message">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php } ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Usuário</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>

        <!-- Links para Esqueci a Senha e Criar Conta -->
        <div class="login-links">
            <p><a href="forgot_password.php">Esqueceu a senha?</a></p>
            <p><a href="register.php">Criar conta</a></p>
        </div>
    </div>

</body>
</html>

<?php
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "livraria";      

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Supondo que você tenha um formulário de login, você pode fazer uma consulta para verificar o admin
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Certifique-se de usar a mesma função de criptografia

    // Consulta para verificar se o usuário é admin
    $sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password' AND role='admin'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Login como admin bem-sucedido!";
        // Redirecionar para a página de administração ou painel do usuário
    } else {
        echo "Usuário ou senha inválidos.";
    }
}
?>
