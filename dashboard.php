<?php

require_once("templates/header.php");
require_once("models/User.php");
require_once("globals.php");
require_once("dao/UserDAO.php");
require_once("dao/MovieDAO.php");

$user = new User();

$userDao = new UserDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);

$userData = $userDao->verifyToken(true);

$userMovies = $movieDao->getMoviesByUserId($userData->id);
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
                <?php foreach($userMovies as $movie): ?>
                <tr>
                    <td scope="row"><?= $movie->id ?></td>
                    <td><a href="<?= $BASE_URL ?>movie.php?id=<?= $movie->id ?>" class="table-movie-title"><?= htmlspecialchars($movie->title, ENT_QUOTES, "UTF-8") ?></a></td>
                    <td><i class="fas fa-star"></i> 9</td>
                    <td class="actions-column">
                        <a href="<?= $BASE_URL ?>editmovie.php?id=<?= $movie->id ?>" class="edit-btn">
                            <i class="far fa-edit">Editar</i>
                        </a>
                        <form action="<?= $BASE_URL ?>movie_process.php" method="POST">
                            <input type="hidden" name="type" value="delete">
                            <input type="hidden" name="id" value="<?= $movie->id ?>">
                            <button type="submit" class="delete-btn">
                                <i class="fas fa-times">Deletar</i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php
require_once("templates/footer.php");
?>