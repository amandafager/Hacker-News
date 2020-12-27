<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we register a new user.

// Check if both email and password exists in the POST request.
if (isset($_POST['new-username'], $_POST['new-email'], $_POST['new-password-1'], $_POST['new-password-2'])) {

    $name = filter_var($_POST['new-username'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['new-email'], FILTER_SANITIZE_EMAIL);
    $passphrase1 = $_POST['new-password-1'];
    $passphrase2 = $_POST['new-password-2'];
    $created =  date('Y-m-d h:m:s');

    if (empty($email)) {
        $_SESSION['error'] = 'Email is required';
        redirect('/login.php');
    }
    if (empty($passphrase1)) {
        $_SESSION['error'] = 'Password is required';
        redirect('/login.php');
    }
    if ($passphrase1 != $passphrase2) {
        $_SESSION['error'] = 'The two passwords do not match';
        redirect('/login.php');
    }

    $userCheckQuery = 'SELECT * FROM users WHERE email = :email OR username = :name LIMIT 1';

    $statement = $database->prepare($userCheckQuery);

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->execute();


    // Fetch the user as an associative array.
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    unset($user['password']);

    if ($user) { // if user exists
        if ($user['email'] === $email) {
            $_SESSION['error'] = 'Email already exists';
            redirect('/login.php');
        }
        if ($user['username'] === $name) {
            $_SESSION['error'] = 'Username already exists';
            redirect('/login.php');
        }
    }


    if (!$user) {

        $hash = password_hash($passphrase1, PASSWORD_DEFAULT);
        $imgSrc = "profile.jpeg";
        $biography = "";
        $query = 'INSERT INTO users (id, username, email, password, created_at, img_src, biography) VALUES (:id, :name, :email, :password, :created, :imgSrc, :biography)';
        $statement = $database->prepare($query);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }

        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $hash, PDO::PARAM_STR);
        $statement->bindParam(':created', $created, PDO::PARAM_STR);
        $statement->bindParam(':imgSrc', $imgSrc, PDO::PARAM_STR);
        $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
        $statement->execute();

        $statement = $database->prepare('SELECT * FROM users WHERE email = :email');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        unset($user['password']);
        $_SESSION['user'] = $user;
        $_SESSION['message'] = 'You have succcssfully created an account and are now logged in. Update your profile!';
    }
}
redirect('/profile.php');
