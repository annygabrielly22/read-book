<?php
    // Define o título da página
    $title = "Seção de Administração";

    // Inclui o cabeçalho do template
    require_once "./template/header.php";
?>

    <!-- Formulário para autenticação de administrador -->
    <form class="form-horizontal" method="post" action="admin_verify.php">
        <!-- Campo para o nome -->
        <div class="form-group">
            <label for="name" class="control-label col-md-4">Nome</label>
            <div class="col-md-4">
                <input type="text" name="name" class="form-control">
            </div>
        </div>
        <!-- Campo para a senha -->
        <div class="form-group">
            <label for="pass" class="control-label col-md-4">Senha</label>
            <div class="col-md-4">
                <input type="password" name="pass" class="form-control">
            </div>
        </div>
        <!-- Botão para enviar o formulário -->
        <input type="submit" name="submit" class="btn btn-primary">
    </form>

<?php
    // Inclui o rodapé do template
    require_once "./template/footer.php";
?>
