<?php

require_once("globals.php");
require_once("db.php");
require_once("models/Message.php");
require_once("dao/UserDAO.php");

$message = new Message($BASE_URL);
$userDao = new UserDAO($conn, $BASE_URL);

// Resgata o tipo do formulario

$type = filter_input(INPUT_POST, "type");

$userDao = new UserDAO($conn, $BASE_URL);

// Verifica o tipo de formulario

if ($type === "register") {

    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
    $confirm_password = filter_input(INPUT_POST, "confirm_password");

    // Verifiacao de dados minimos
    if ($name && $lastname && $email && $password) {

        // Verifica se as senhas batem
        if ($password === $confirm_password) {

            // Verificar se o email esta cadastrado no sistema
            if ($userDao->findByEmail($email) === false) {

                $user = new User();

                // Criação do token e senha
                $userToken = $user->generateToken();
                $finalPassword = $user->generatePassword($password);

                $user->name = $name;
                $user->lastname = $lastname;
                $user->email = $email;
                $user->password = $finalPassword;
                $user->token = $userToken;

                $auth = true;

                $userDao->create($user, $auth);
            } else {
                // Enviar mensagem de erro, de usuario ja existente
                $message->setMessage("Usuario já cadastrado tente outro email", "error", "back");
            }
        } else {

            // Enviar mensagem de erro, de senhas diferentes
            $message->setMessage("As senhas não são iguais", "error", "back");
        }
    } else {
        // Enviar mensagem de erro, de dados faltantes
        $message->setMessage("Por favor, preencha todos os campos", "error", "back");
    }
} else if ($type === "login") {
    $email = filter_input(INPUT_POST, "email");
    $password = filter_input(INPUT_POST, "password");
}
