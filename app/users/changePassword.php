<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_SESSION['user']['id'];

if (isset($_POST['current-password'], $_POST['update-password'])) {
    $typedCurrentPass = $_POST['current-password'];
    $hash = password_hash($_POST['update-password'], PASSWORD_DEFAULT);

    $statement = $database->prepare('SELECT * FROM users WHERE id = :id');
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if (password_verify($typedCurrentPass, $user['password'])) {
        $user['password'] = $currentPass;
        $updateUserPassword = 'UPDATE users SET password = :newPass WHERE id = :id';
        $statement = $database->prepare($updateUserPassword);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':newPass', $hash, PDO::PARAM_STR);
        $statement->execute();
        unset($user['password']);
        $_SESSION['success'] = "Your password is now changed!";
        redirect('/profile.php?userId=' . $_SESSION['user']['id']);
    } else {
        $_SESSION['error'] = 'Try again, the typed password did not match your current password!';
        unset($user['password']);
        redirect('/changePassword.php');
    }
}

redirect('/profile.php?userId=' . $_SESSION['user']['id']);
