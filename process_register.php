<?php
// Inicia a sessão para mensagens de erro ou sucesso
session_start();

// Conectar ao banco de dados (substitua pelos seus próprios dados de conexão)
$host = 'localhost';
$dbname = 'livraria';
$username_db = 'root';
$password_db = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username_db, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Coletar os dados do formulário
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar se as senhas coincidem
    if ($password != $confirm_password) {
        $_SESSION['error_message'] = "As senhas não coincidem!";
        header("Location: register.php");
        exit;
    }

    // Validar o formato do e-mail (opcional)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "E-mail inválido!";
        header("Location: register.php");
        exit;
    }

    // Verificar se o usuário já existe (opcional)
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $_SESSION['error_message'] = "Já existe uma conta com esse e-mail!";
        header("Location: register.php");
        exit;
    }

    // Inserir os dados no banco de dados (hashing da senha por segurança)
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hashed_password]);

    // Redirecionar para a página de login com mensagem de sucesso
    $_SESSION['success_message'] = "Conta criada com sucesso! Faça login.";
    header("Location: login.php");
    exit;
}
?>
