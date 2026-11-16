<?php

require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("models/User.php");
require_once("globals.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);
?>

<div id="main-container" class="container-fluid">
    <div class="offser-md-4 col-md-4 new-movie-container">
        
    </div>
</div>

<?php
require_once("templates/footer.php");
?>