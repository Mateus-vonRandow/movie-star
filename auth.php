<?php
require_once("templates/header.php");
require_once("db.php");
require_once("globals.php");
require_once("dao/UserDAO.php");
?>

<div id="main-container" class="container-fluid">
    <div class="col-md-12">
        <div class="row" id="auth-row">
            <div class="col-md-4" id="login-container=">
                <h2>Entrar</h2>
                <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
                    <input type="hidden" value="login" name="type">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" placeholder="Digite seu email" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" placeholder="Digite sua senha" name="password" id="password">
                    </div>
                    <input type="submit" class="btn card-btn" value="Entrar">
                </form>
            </div>
            <div class="col-md-4" id="register-container=">
                <h2>Criar conta</h2>
                <form action="<?= $BASE_URL ?>auth_process.php" method="POST">
                    <input type="hidden" value="register" name="type">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" placeholder="Digite seu email" name="email" id="email">
                    </div>
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" placeholder="Digite seu nome" name="name" id="name">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome:</label>
                        <input type="text" class="form-control" placeholder="Digite seu sobrenome" name="lastname" id="lastname">
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" class="form-control" placeholder="Digite sua senha" name="password" id="password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirmar Senha:</label>
                        <input type="password" class="form-control" placeholder="Confirme sua senha" name="confirm_password" id="confirm_password">
                    </div>
                    <input type="submit" value="Registrar" class="btn card-btn">
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once("templates/footer.php");
?>