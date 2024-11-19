<?php
// Iniciar sessão, verificando se já foi iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se o usuário está logado
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Configurar título da página
$title = "Página Inicial";

// Incluir cabeçalho e funções necessárias
require_once "./template/header.php";
require_once "./functions/database_functions.php";

// Conectar ao banco de dados e buscar os livros
$conn = db_connect();
$row = select4LatestBook($conn);

// Verificar se a função retornou dados
if ($row === false) {
    echo "Erro ao buscar livros no banco de dados.";
    $row = []; // Garantir que $row seja um array vazio se houver erro
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <style>
        /* Estilos personalizados */
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            margin-top: 60px;
        }

        .navbar {
            background-color: #343a40;
            padding: 3px;
        }

        .navbar .navbar-brand {
            color: #ffffff;
            font-size: 20px;
        }

        .navbar .nav-link {
            color: #ffffff;
        }

        .navbar .nav-link:hover {
            color: #f8f9fa;
            text-decoration: underline;
        }

        .container {
            margin-top: 20px;
        }

        .table {
            background-color: #ffffff;
            border-radius: 8px;
        }

        .table th {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            font-size: 18px;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table img {
            border-radius: 8px;
        }

        .table .btn-info {
            background-color: #28a745;
            border: none;
            color: white;
        }

        .table .btn-info:hover {
            background-color: #218838;
        }

        .table .btn-info:focus {
            outline: none;
        }

        .lead {
            font-size: 24px;
            font-weight: 600;
            color: #007bff;
            margin-bottom: 40px;
        }

        .footer {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
            font-size: 14px;
        }

        .footer a {
            color: #ffffff;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <!-- Barra de navegação -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <!-- Botão de logout -->
            <a href="logout.php" class="btn btn-danger btn-sm" style="position: absolute; left: 3px; top: 3px;">
                <span class="glyphicon glyphicon-log-out"></span> Logout
            </a>

            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Livraria Tech</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="publisher_list.php"><span class="glyphicon glyphicon-paperclip"></span> Editores</a></li>
                    <li><a href="books.php"><span class="glyphicon glyphicon-book"></span> Livros</a></li>
                    <li><a href="contact.php"><span class="glyphicon glyphicon-phone-alt"></span> Contato</a></li>
                    <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Meu Carrinho</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Título da seção -->
        <p class="lead text-center text-muted">Últimos Livros Disponíveis</p>

        <!-- Tabela de livros -->
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Livros</th>
                        <th scope="col" class="text-center">Detalhes</th> <!-- Centralizando o botão -->
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (!empty($row)) {
                        foreach ($row as $book) { ?>
                        <tr>
                            <!-- Capa do livro -->
                            <td>
                                <img src="./bootstrap/img/<?php echo isset($book['book_image']) ? $book['book_image'] : 'default.png'; ?>" 
                                     alt="Capa do livro" 
                                     class="img-thumbnail" 
                                     style="width: 120px; height: auto;">
                            </td>

                            <!-- Link para detalhes -->
                            <td class="text-center"> <!-- Centralizando o botão "Detalhes" -->
                                <a href="book.php?bookisbn=<?php echo isset($book['book_isbn']) ? $book['book_isbn'] : '#'; ?>" 
                                   class="btn btn-info">
                                    <span class="glyphicon glyphicon-eye-open"></span> Detalhes
                                </a>
                            </td>
                        </tr>
                        <tr><td colspan="2"><br><br></td></tr> <!-- Linha vazia separando os livros -->
                        <?php }
                    } else {
                        echo "<tr><td colspan='2' class='text-center'>Nenhum livro disponível.</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Livraria Tech - Todos os direitos reservados. <a href="privacy.php">Política de Privacidade</a> | <a href="terms.php">Termos de Serviço</a></p>
    </footer>

    <!-- Footer Scripts -->
    <?php
    // Fechar conexão e incluir footer
    if (isset($conn)) {
        mysqli_close($conn);
    }
    require_once "./template/footer.php";
    ?>
</body>
</html>
