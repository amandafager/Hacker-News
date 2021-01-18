<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we register a new user.

// Check if both email and password exists in the POST request.
if (isset($_POST['new-username'], $_POST['new-email'], $_POST['new-password-1'], $_POST['new-password-2'])) {
    $name = sanitizeString($_POST['new-username']);
    $email = sanitizeEmail($_POST['new-email']);
    $passphrase1 = $_POST['new-password-1'];
    $passphrase2 = $_POST['new-password-2'];


    if (empty($name)) {
        $_SESSION['error'] = 'Username is required!';
        redirect('/login.php');
    }
    if (empty($email)) {
        $_SESSION['error'] = 'Email is required!';
        redirect('/login.php');
    }
    if (!validateEmail($email)) {
        $_SESSION['error'] = $email . ' is not a valid email address!';
        redirect('/login.php');
    }
    if (empty($passphrase1)) {
        $_SESSION['error'] = 'Password is required!';
        redirect('/login.php');
    }
    if ($passphrase1 != $passphrase2) {
        $_SESSION['error'] = 'The two passwords do not match!';
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
            $_SESSION['error'] = 'Email already exists!';
            $_SESSION['input'] = $email;
            redirect('/login.php');
        }
        if ($user['username'] === $name) {
            $_SESSION['error'] = 'Username already exists!';
            redirect('/login.php');
        }
    }

    if (!$user) {
        $hash = password_hash($passphrase1, PASSWORD_DEFAULT);
        $created = strftime('%Y-%m-%d %H:%M:%S');
        $imgSrc = "profile.svg";
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
        $_SESSION['message'] = "Welcome " . $_SESSION['user']['username'] . "! You have succcssfully created an account and are now logged in. Update your profile!";
    }
}
redirect('/profile.php?userId=' . $_SESSION['user']['id']);
