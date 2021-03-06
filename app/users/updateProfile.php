<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


$id = $_SESSION['user']['id'];

if (isset($_FILES['profile-img'])) {
    $file = $_FILES['profile-img'];
    $fileName = $_FILES['profile-img']['name'];
    $fileTmpName = $_FILES['profile-img']['tmp_name'];
    $fileSize = $_FILES['profile-img']['size'];
    $fileError = $_FILES['profile-img']['error'];
    $fileType = $_FILES['profile-img']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowedFileType = ['image/jpg', 'image/jpeg', 'image/png'];

    if (in_array($fileType, $allowedFileType)) {
        if ($fileError === 0) {
            if ($fileSize <= 2097152) {
                $fileNameNew = "profile" . $id . "." . $fileActualExt;
                $fileDestination = __DIR__ . '/uploads/' . $fileNameNew;

                $currentImg = $_SESSION['user']['img_src'];

                if (file_exists(__DIR__ . '/uploads/' . $currentImg)) {
                    if ($currentImg !== 'profile.svg') {
                        unlink(__DIR__ . '/uploads/' . $currentImg);
                    }
                }

                move_uploaded_file($fileTmpName, $fileDestination);

                $imgSrc = $fileNameNew;
                $updateImgSrcQuery = 'UPDATE users SET img_src = :imgSrc WHERE id = :id';
                $statement = $database->prepare($updateImgSrcQuery);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->bindParam(':imgSrc', $imgSrc, PDO::PARAM_STR);
                $statement->execute();


                $statement = $database->prepare('SELECT * FROM users WHERE id = :id');
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->execute();


                $user = $statement->fetch(PDO::FETCH_ASSOC);
                unset($user['password']);
                $_SESSION['user'] = $user;
                redirect('/profile.php?userId=' . $_SESSION['user']['id']);
            } else {
                $_SESSION['error'] = 'Your file is too big! The image size has to be lower then 2MB.';
                redirect('/profile.php?userId=' . $_SESSION['user']['id']);
            }
        } else {
            $_SESSION['error'] = 'There was an error on your uploaded file.';
            redirect('/profile.php?userId=' . $_SESSION['user']['id']);
        }
    } else {
        $_SESSION['error'] = 'The uploaded file type is not allowed.';
        redirect('/profile.php?userId=' . $_SESSION['user']['id']);
    }
}

if (isset($_POST['update-profile'])) {
    $biography = sanitizeText($_POST['biography']);

    if ($biography || empty($biography)) {
        $updateUserBio = 'UPDATE users SET biography = :biography WHERE id = :id';
        $statement = $database->prepare($updateUserBio);
        $statement->bindParam(':biography', $biography, PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
    }

    $newEmail = sanitizeEmail($_POST['update-email']);

    if ($newEmail) {
        $userCheckEmailQuery = 'SELECT email FROM users WHERE email = :email LIMIT 1';

        $statement = $database->prepare($userCheckEmailQuery);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':email', $newEmail, PDO::PARAM_STR);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        unset($user['password']);

        if (!validateEmail($newEmail)) {
            $_SESSION['error'] = 'The email address is not a valid email address!';
            redirect('/profile.php?userId=' . $_SESSION['user']['id']);
        }
        if ($user['email'] === $newEmail && !$newEmail === $_SESSION['user']['email']) {
            $_SESSION['error'] = 'Email already exists';
            redirect('/profile.php?userId=' . $_SESSION['user']['id']);
        }

        if (validateEmail($newEmail) && $user['email'] !== $newEmail) {
            $updateUserEmail = 'UPDATE users SET email = :email WHERE id = :id';
            $statement = $database->prepare($updateUserEmail);
            $statement->bindParam(':email', $newEmail, PDO::PARAM_STR);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
        }
    }
}


$statement = $database->prepare('SELECT * FROM users WHERE id = :id');
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

unset($user['password']);
$_SESSION['user'] = $user;

redirect('/profile.php?userId=' . $_SESSION['user']['id']);
