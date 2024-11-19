<?php
  $title = "Contato";
  require_once "./template/header.php";
?>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-center">
            <form class="form-horizontal">
                <fieldset>
                    <legend>Contato</legend>
                    <p class="lead">Adoraria ouvir de você! Complete o formulário para me enviar um e-mail.</p>
                    <div class="form-group">
                        <label for="inputName" class="col-lg-2 control-label">Nome</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="inputName" placeholder="Nome">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
                        <div class="col-lg-10">
                            <input type="text" class="form-control" id="inputEmail" placeholder="E-mail">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="textArea" class="col-lg-2 control-label">Mensagem</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" id="textArea"></textarea>
                            <span class="help-block">Um texto de ajuda mais longo que quebra em uma nova linha e pode se estender por várias linhas.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="reset" class="btn btn-default">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
<?php
  require_once "./template/footer.php";
?>
