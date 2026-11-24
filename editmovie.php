<?php

require_once("templates/header.php");
require_once("dao/UserDAO.php");
require_once("models/User.php");
require_once("globals.php");
require_once("dao/MovieDAO.php");

$user = new User();
$userDao = new UserDAO($conn, $BASE_URL);
$userData = $userDao->verifyToken(true);

$movieDao = new MovieDAO($conn, $BASE_URL);

$id = filter_input(INPUT_GET, "id");

if (empty($id)) {

    $message->setMessage("O filme não foi encontrado!", "error", "index.php");
} else {

    $movie = $movieDao->findById($id);

    if (!$movie) {

        $message->setMessage("O filme não foi encontrado!", "error", "index.php");
    }
}

// Checar se o filme tem imagem
if (empty($movie->image)) {
    $movie->image = "movie_cover.jpg";
}
?>

<div id="main-container" class="container-fluid">
    <section class="edit-movie-container movie-form-container">
        <h1 class="page-title">Editar filme</h1>
        <p class="page-description">Altere os dados de <strong><?= $movie->title ?></strong> no formulário abaixo:</p>
        <div class="row g-4 align-items-start">
            <div class="col-lg-8">
                <form id="edit-movie-form" action="<?= $BASE_URL ?>movie_process.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="update">
                    <input type="hidden" name="id" value="<?= $movie->id ?>">
                    <div class="form-group">
                        <label for="title">Título:</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Digite o nome do seu filme" value="<?= $movie->title ?>">
                    </div>
                    <div class="form-group">
                        <label for="image">Imagem:</label>
                        <input type="file" class="form-control-file" name="image" id="image">
                    </div>
                    <div class="form-group">
                        <label for="length">Duração:</label>
                        <input type="text" class="form-control" id="length" name="length" value="<?= $movie->length ?>" placeholder="Digite a duração do filme">
                    </div>
                    <div class="form-group">
                        <label for="category">Categoria:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Selecione</option>
                            <option value="Ação" <?= $movie->category === "Ação" ?  "selected" : "" ?>>Ação</option>
                            <option value="Comédia"<?= $movie->category === "Comédia" ?  "selected" : "" ?>>Comédia</option>
                            <option value="Ficção"<?= $movie->category === "Ficção" ?  "selected" : "" ?>>Ficção</option>
                            <option value="Terror"<?= $movie->category === "Terror" ?  "selected" : "" ?>>Terror</option>
                            <option value="Suspense"<?= $movie->category === "Suspense" ?  "selected" : "" ?>>Suspense</option>
                            <option value="Romance"<?= $movie->category === "Romance" ?  "selected" : "" ?>>Romance</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="trailer">Trailer:</label>
                        <input type="text" class="form-control" id="trailer" value="<?= $movie->trailer ?>" name="trailer" placeholder="Insira o link do trailer">
                    </div>
                    <div class="form-group">
                        <label for="description">Descrição:</label>
                        <textarea name="description" id="description" rows="5" class="form-control" placeholder="Descreva o filme"><?= $movie->description ?></textarea>
                    </div>
                    <input type="submit" class="btn card-btn" value="Salvar Alterações">
                </form>
            </div>
            <div class="col-lg-4 edit-movie-preview">
                <h2 class="edit-movie-preview-title">Capa atual</h2>
                <div class="movie-image-container edit-movie-image" style="background-image: url('<?= $BASE_URL ?>img/movies/<?= $movie->image ?>');"></div>
            </div>
        </div>
    </section>
</div>

<?php
require_once("templates/footer.php");
?>