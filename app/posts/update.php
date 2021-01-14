<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we update posts in the database.

if (isset($_POST['edit-post'])) {
    $title = sanitizeString($_POST['edit-title']);
    $url = $url = sanitizeUrl($_POST['edit-url']);
    $description = sanitizeText($_POST['edit-description']);
    $id = $_SESSION['post']['id'];
    $userId = $_SESSION['user']['id'];

    if (!validateUrl($url)) {
        $_SESSION['error'] = 'The' . $url . 'is not valid!';
        redirect('/editPost.php');
    } else {
        $updatePostQuery = 'UPDATE posts SET title = :title, url = :url, description = :description WHERE id = :id AND user_id = :userId';
        $statement = $database->prepare($updatePostQuery);

        $statement->bindParam(':title', $title, PDO::PARAM_STR);
        $statement->bindParam(':url', $url, PDO::PARAM_STR);
        $statement->bindParam(':description', $description, PDO::PARAM_STR);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->execute();
        $_SESSION['success'] = "Your post is now up to date.";
    }
}

redirect('/index.php?userId=' . $_SESSION['user']['id'] . '&name=' . $_SESSION['user']['username']);
