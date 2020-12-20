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

    $allowed = ['jpg', 'jpeg', 'png'];

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 2097152) {
                $fileNameNew = "profile" . $id . "." . $fileActualExt;
                //$destination = __DIR__ . '/uploads/' . date('ymd') . '-' . $fileNameNew;
                $fileDestination = __DIR__ . '/uploads/' . $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                $status = 0;
                $queryUpdateProfileImg = 'UPDATE profileimg SET status = :status WHERE id = :id';
                $statement = $database->prepare($queryUpdateProfileImg);

                if (!$statement) {
                    die(var_dump($database->errorInfo()));
                }
                $statement->bindParam(':status', $status, PDO::PARAM_INT);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->execute();

                $src = $fileNameNew;
                $updateImgSrc = 'UPDATE users SET img_src = :src WHERE id = :id';
                $statement = $database->prepare($updateImgSrc);
                $statement->bindParam(':id', $id, PDO::PARAM_INT);
                $statement->bindParam(':src', $src, PDO::PARAM_STR);
                $statement->execute();

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
