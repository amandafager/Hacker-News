<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we login users.

//$errors = [];

if (isset($_POST['current-email'], $_POST['current-password'])) {
    $email = filter_var($_POST['current-email'], FILTER_SANITIZE_EMAIL);
    $password = htmlentities($_POST['current-password']);


    $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    /*if (!$user) {
    }*/

    if ($email === $user['email'] && password_verify($password, $user['password'])) {

        unset($user['password']);
        $_SESSION['user'] = $user;
        $_SESSION['success'] = "You are now logged in";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $_SESSION['error'] = 'The email address is not a valid email address!';
        redirect('/login.php');
    } else if ($email !== $user['email'] && $password !== $user['password']) {

        $_SESSION['error'] = 'Whoops... The provided credentials does not match our records!';
        redirect('/login.php');
    } else if ($email === $user['email'] && !password_verify($password, $user['password'])) {

        $_SESSION['error'] = 'Whoops! Looks like you missed something. Please enter correct password.';
        redirect('/login.php');
    }
}
redirect('/');
