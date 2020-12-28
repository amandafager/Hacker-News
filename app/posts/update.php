<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete posts in the database.

if (isset($_POST['edit-post'])) {

    $title = filter_var($_POST['edit-title'], FILTER_SANITIZE_STRING);
    $url = filter_var($_POST['edit-url'], FILTER_SANITIZE_URL);
    $description = filter_var($_POST['edit-description'], FILTER_SANITIZE_STRING);
    $id = $_SESSION['post']['id'];
    $userId = $_SESSION['user']['id'];

    $updatePostQuery = 'UPDATE posts SET title = :title, url = :url, description = :description WHERE id = :id AND user_id = :userId';
    $statement = $database->prepare($updatePostQuery);

    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':url', $url, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);

    $statement->execute();
}

redirect('/posts.php?userId=' . $_SESSION['user']['id']);
