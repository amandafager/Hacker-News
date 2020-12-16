<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we register a new user.



//password_verify($passphrase, $hash);
/*
$email    = "";
$errors = [];*/

// Check if both email and password exists in the POST request.
if (isset($_POST['name'], $_POST['email'], $_POST['password_1'], $_POST['password_2'])) {

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $passphrase1 = $_POST['password_1'];
    $passphrase2 = $_POST['password_2'];

    /*if (empty($email)) {
        //$errors[] = ["Email is required"];
    }
    if (empty($passphrase1)) {
        //$errors[] = ["Password is required"];
    }*/
    if ($passphrase1 != $passphrase2) {
        //$error = "The two passwords do not match";
        redirect('/login.php');
    }

    $userCheckQuery = 'SELECT * FROM users WHERE email = :email LIMIT 1';

    $statement = $database->prepare($userCheckQuery);
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    // Fetch the user as an associative array.
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) { // if user exists
        //$errors[] = ["email already exists"];
        redirect('/login.php');
    }

    if (!$user)/*(count($errors) == 0)*/ {

        $hash = password_hash($passphrase1, PASSWORD_DEFAULT);

        $query = 'INSERT INTO users (id, username, email, password) VALUES (:id, :name, :email, :password)';

        $statement = $database->prepare($query);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }

        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':name', $name, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $hash, PDO::PARAM_STR);
        $statement->execute();



        if (password_verify($_POST['password'], $user['password'])) {

            unset($user['password']);

            $_SESSION['user'] = $user;
        }


        //unset($_SESSION['user']);

        /*$_SESSION['user'] = $user;
        $_SESSION['success'] = "You are now logged in";*/
    }
}
redirect('/login.php');
//redirect('/');
