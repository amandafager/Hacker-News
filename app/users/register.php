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

    $userCheckQuery = 'SELECT * FROM users WHERE email = :email LIMIT 1';

    $statement = $database->prepare($userCheckQuery);

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->execute();

    // Fetch the user as an associative array.
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user['email']) { // if user exists
        $_SESSION['error'] = 'Email already exists';
        redirect('/login.php');
    } else if ($user['username']) {
        $_SESSION['error'] = 'Username already exists';
        redirect('/login.php');
    }

    if (!$user) {

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


        unset($_SESSION['user']);
        redirect('/login.php');




        //

        /*$_SESSION['user'] = $user;
        $_SESSION['success'] = "You are now logged in";*/
    }
}
redirect('/');


/*unset($user['password']);
$_SESSION['user'] = $user;*/

//`created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,*/