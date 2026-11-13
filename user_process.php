<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");
require_once("models/User.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);

$type = filter_input(INPUT_POST, "type");

// Atualizar usuario

if ($type === "update") {

    // Resgata dados do usuario
    $userData = $userDao->verifyToken(true);

    if (!$userData) {
        exit;
    }

    // Receber dados do post
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $bio = filter_input(INPUT_POST, "bio");

    // Criar novo objeto de usuario
    $user = new User();

    // Preenher dados do usuario
    $userData->name = $name;
    $userData->lastname = $lastname;
    $userData->email = $email;
    $userData->bio = $bio;

    // Upload da imagem
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {

        $image = $_FILES["image"];
        if ($image["error"] !== UPLOAD_ERR_OK || !is_uploaded_file($image["tmp_name"])) {
            $message->setMessage("Falha ao enviar a imagem. Tente novamente.", "error", "back");
            exit;
        }

        $imageInfo = getimagesize($image["tmp_name"]);
        $imageExtensions = [
            IMAGETYPE_JPEG => "jpg",
            IMAGETYPE_PNG => "png"
        ];

        if ($imageInfo === false || !isset($imageExtensions[$imageInfo[2]])) {
            $message->setMessage("Tipo inválido de imagem, insira png ou jpg!", "error", "back");
            exit;
        }

        $imageName = $user->imageGenerateName($imageExtensions[$imageInfo[2]]);
        $imagePath = __DIR__ . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR . $imageName;

        if (!move_uploaded_file($image["tmp_name"], $imagePath)) {
            $message->setMessage("Não foi possível salvar a imagem enviada.", "error", "back");
            exit;
        }

        $userData->image = $imageName;
    }

    $userDao->update($userData);

    // Atualizar senha do usuario
} else if ($type === "changepassword") {
} else {
    $message->setMessage("Informações inválidas", "error", "index.php");
}
