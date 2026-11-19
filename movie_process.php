<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("models/User.php");
require_once("models/Movie.php");
require_once("dao/MovieDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);
$movieDao = new MovieDAO($conn, $BASE_URL);

// Resgata o tipo do formulario
$type = filter_input(INPUT_POST, "type");

// Resgata dados do usuario
$userData = $userDao->verifyToken(true);

if (!$userData) {
    exit;
}

if ($type === "create") {

    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer = filter_input(INPUT_POST, "trailer");
    $category = filter_input(INPUT_POST, "category");
    $length = filter_input(INPUT_POST, "length");

    $movie = new Movie();

    // Validação minima de dados
    if (!empty($title) && !empty($description) && !empty($category)) {

        $movie->title = $title;
        $movie->description = $description;
        $movie->trailer = $trailer;
        $movie->category = $category;
        $movie->length = $length;
        $movie->users_id = $userData->id;

        // Upload de imagem do filme
        if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {

            $image = $_FILES["image"];
            if ($image["error"] !== UPLOAD_ERR_OK || !is_uploaded_file($image["tmp_name"])) {
                $message->setMessage("Falha ao enviar a imagem. Tente novamente.", "error", "back");
                exit;
            }

            $imageInfo = getimagesize($image["tmp_name"]);
            $imageTypes = [
                IMAGETYPE_JPEG => "jpg",
                IMAGETYPE_PNG => "png"
            ];

            if ($imageInfo === false || !isset($imageTypes[$imageInfo[2]])) {
                $message->setMessage("Imagem inválida! Insira jpeg, jpg ou png", "error", "back");
                exit;
            }

            $imageExtension = $imageTypes[$imageInfo[2]];
            $movieFolder = __DIR__ . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "movies" . DIRECTORY_SEPARATOR;

            if (!is_dir($movieFolder) && !mkdir($movieFolder, 0777, true) && !is_dir($movieFolder)) {
                $message->setMessage("Não foi possível salvar a imagem enviada.", "error", "back");
                exit;
            }

            $imageName = $movie->imageGenerateName($imageExtension);
            $imagePath = $movieFolder . $imageName;

            if (!move_uploaded_file($image["tmp_name"], $imagePath)) {
                $message->setMessage("Não foi possível salvar a imagem enviada.", "error", "back");
                exit;
            }

            $movie->image = $imageName;
        }

        $movieDao->create($movie);

    } else {

        $message->setMessage("Você precisa adicionar pelo menos Título, descrição e categoria!", "error", "back");

    }

} else if ($type === "delete") {

    // Recebe os dados do formulario
    $id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

    $movie = $id ? $movieDao->findById($id) : null;

    if ($movie && (int) $movie->users_id === (int) $userData->id) {
        $movieDao->destroy($movie->id);
    } else {
        $message->setMessage("Filme não encontrado ou você não tem permissão para removê-lo.", "error", "index.php");
    }

} else {
    $message->setMessage("Informações inválidas!", "error", "index.php");
}
