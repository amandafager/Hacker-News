<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_SESSION['user']['id'];

if (isset($_FILES['profile-img'])) {
    $file = filter_var($_FILES['profile-img'], FILTER_SANITIZE_STRING);
    $fileName = $_FILES['profile-img']['name'];
    $fileTmpName = $_FILES['profile-img']['tmp_name'];
    $fileSize = $_FILES['profile-img']['size'];
    $fileError = $_FILES['profile-img']['error'];
    $fileType = $_FILES['profile-img']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowedFile = ['image/jpg', 'image/jpeg', 'image/png'];

    if (in_array($fileType, $allowedFile)) {
        if ($fileError === 0) {
            if ($fileSize < 2097152) {
                $fileNameNew = "profile" . $id . "." . $fileActualExt;
                //$destination = __DIR__ . '/uploads/' . date('ymd') . '-' . $fileNameNew;
                $fileDestination = __DIR__ . '/uploads/' . $fileNameNew;

                $currentImg = $_SESSION['user']['img_src'];

                if (file_exists(__DIR__ . '/uploads/' . $currentImg)) {
                    if ($currentImg !== 'profile.jpeg')
                        unlink(__DIR__ . '/uploads/' . $currentImg);
                }

                move_uploaded_file($fileTmpName, $fileDestination);

                $imgSrc = $fileNameNew;
                $updateImgSrc = 'UPDATE users SET img_src = :imgSrc WHERE id = :id';
                $statement = $database->prepare($updateImgSrc);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->bindParam(':imgSrc', $imgSrc, PDO::PARAM_STR);
                $statement->execute();


                $statement = $database->prepare('SELECT * FROM users WHERE id = :id');
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->execute();
                $user = $statement->fetch(PDO::FETCH_ASSOC);
                unset($user['password']);
                $_SESSION['user'] = $user;
                redirect('/profile.php');


                redirect('/profile.php');
            } else {
                $_SESSION['error'] = 'Your file is too big!';
                redirect('/profile.php');
            }
        } else {
            $_SESSION['error'] = 'There was an error on your uploaded file.';
            redirect('/profile.php');
        }
    } else {
        $_SESSION['error'] = 'The uploaded file type is not allowed.';
        redirect('/profile.php');
    }
}

if (isset($_POST['update-email'])) {

    $newEmail = filter_var($_POST['update-email'], FILTER_SANITIZE_EMAIL);


    if ($newEmail) {

        $userCheckEmailQuery = 'SELECT * FROM users WHERE email = :email LIMIT 1';

        $statement = $database->prepare($userCheckEmailQuery);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':email',  $newEmail, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        unset($user['password']);

        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'The email address is not a valid email address!';
            redirect('/profile.php');
        }
        if ($user['email'] === $newEmail) {
            $_SESSION['error'] = 'Email already exists';
            redirect('/profile.php');
        }

        if (filter_var($newEmail, FILTER_VALIDATE_EMAIL) && $user['email'] !== $newEmail) {

            $updateUserEmail = 'UPDATE users SET email = :email WHERE id = :id';
            $statement = $database->prepare($updateUserEmail);
            $statement->bindParam(':email', $newEmail, PDO::PARAM_STR);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        }
    }
}


if (isset($_POST['biography'])) {

    $biography = filter_var($_POST['biography'], FILTER_SANITIZE_STRING);

    if ($biography) {
        $updateUserBio = 'UPDATE users SET biography = :biography WHERE id = :id';
        $statement = $database->prepare($updateUserBio);
        $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
}

$statement = $database->prepare('SELECT * FROM users WHERE id = :id');
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);
unset($user['password']);
$_SESSION['user'] = $user;
redirect('/profile.php');

/*if (isset($_POST['update-email'], $_POST['biography'])) {

    $newEmail = filter_var($_POST['update-email'], FILTER_SANITIZE_EMAIL);
    $biography = filter_var($_POST['biography'], FILTER_SANITIZE_STRING);

    if ($newEmail) {

        $userCheckEmailQuery = 'SELECT * FROM users WHERE email = :email LIMIT 1';

        $statement = $database->prepare($userCheckEmailQuery);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':email',  $newEmail, PDO::PARAM_STR);
        $statement->execute();
        // Fetch the user as an associative array.
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        unset($user['password']);

        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'The email address is not a valid email address!';
            redirect('/profile.php');
        }
        if ($user['email'] === $newEmail) {
            $_SESSION['error'] = 'Email already exists';
            redirect('/profile.php');
        }

        if (filter_var($newEmail, FILTER_VALIDATE_EMAIL) && $user['email'] !== $newEmail) {

            $updateUserEmail = 'UPDATE users SET email = :email WHERE id = :id';
            $statement = $database->prepare($updateUserEmail);
            $statement->bindParam(':email', $newEmail, PDO::PARAM_STR);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        }
    }

    if ($biography) {
        $updateUserBio = 'UPDATE users SET biography = :biography WHERE id = :id';
        $statement = $database->prepare($updateUserBio);
        $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }
}*/
