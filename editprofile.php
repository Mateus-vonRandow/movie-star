<?php
require_once("globals.php");
require_once("db.php");
require_once("dao/UserDAO.php");
require_once("models/User.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);

if (!$userData) {
    exit;
}

$fullName = $user->getFullName($userData);
$profileImage = empty($userData->image) ? "user.png" : $userData->image;

require_once("templates/header.php");
?>

<div id="main-container" class="container-fluid profile-page">
    <div class="col-md-12 profile-content">
        <form action="<?= $BASE_URL ?>user_process.php" method="post" enctype="multipart/form-data" id="profile-form" class="profile-card">
            <input type="hidden" name="type" value="update">
            <div class="row g-4">
                <div class="col-lg-7">
                    <h1 class="profile-title"><?= $fullName ?></h1>
                    <p class="page-description">Altere seus dados no formulário abaixo:</p>
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Digite o seu nome" value="<?= $userData->name ?>">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Sobrenome:</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite o seu sobrenome" value="<?= $userData->lastname ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" readonly class="form-control disabled" id="email" name="email" placeholder="Digite o seu email" value="<?= $userData->email ?>">
                    </div>
                    <input type="submit" class="btn form-btn" value="Alterar">
                </div>

                <div class="col-lg-5 profile-photo-column">
                    <div id="profile-image-container">
                        <img
                            src="<?= $BASE_URL ?>img/users/<?= htmlspecialchars($profileImage, ENT_QUOTES, 'UTF-8') ?>"
                            alt="Foto de perfil de <?= htmlspecialchars($fullName, ENT_QUOTES, 'UTF-8') ?>"
                            class="profile-avatar">
                    </div>
                    <div class="form-group">
                        <label for="image">Foto:</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label for="bio">Sobre você:</label>
                        <textarea class="form-control" name="bio" id="bio" rows="5" placeholder="Conte quem você é, o que faz, e onde trabalha..."><?= $userData->bio ?></textarea>
                    </div>
                </div>
            </div>
        </form>
        <div class="row" id="change-password-container">
            <div class="col-12">
                <section class="profile-card password-card">
                    <h2>Alterar a senha:</h2>
                    <p class="page-description">Digite a nova senha e confirme para alterar sua senha</p>
                    <form action="<?= $BASE_URL ?>user_process.php" method="POST">
                        <input type="hidden" name="type" value="changepassword">
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Digite a sua nova senha">
                        </div>
                        <div class="form-group">
                            <label for="confirmpassword">Confirmar senha:</label>
                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirme a sua nova senha">
                        </div>
                        <input type="submit" class="btn form-btn" value="Alterar senha">
                    </form>
                </section>
            </div>
        </div>
    </div>
</div>

<?php
require_once("templates/footer.php");
?>