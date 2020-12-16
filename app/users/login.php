<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we login users.


if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);


    $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);


    if (!$user) {
        redirect('/login.php');
    }

    if (password_verify($_POST['password'], $user['password'])) {

        unset($user['password']);

        $_SESSION['user'] = $user;
    }
}

redirect('/');
