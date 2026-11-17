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
    <h2 class="section-title">Dashboard</h2>
    <p class="section-description">Adicione ou atualize as informações dos filmes que você adicionou!</p>
    <div class="col-md-12" id="add-movie-container">
        <a href="<?= $BASE_URL ?>newmovie.php" class="btn card-btn">
            <i class="fas fa-plus">Adicionar filme</i>
        </a>
    </div>
    <div class="col-md-12" id="movies-dashboard">
        <table class="table">
            <thead>
                <th scope="col">#</th>
                <th scope="col">Título</th>
                <th scope="col">Nota</th>
                <th scope="col" class="action-column">Ações</th>
            </thead>
            <tbody>
                <tr>
                    <td     scope="row">1</td>
                    <td><a href="#" class="table-movie-title">Título</a></td>
                    <td><i class="fas fa-star"></i> 9</td>
                    <td class="actions-column">
                        <a href="" class="edit-btn">
                            <i class="far fa-edit">Editar</i>
                        </a>
                        <form action="">
                            <button type="submit" class="delete-btn">
                                <i class="fas fa-times">Deletar</i>
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<?php
require_once("templates/footer.php");
?>