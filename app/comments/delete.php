<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete comments in the database.

if (isset($_POST['id'])) {

    $commentId = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];

    $deletePostQuery = 'DELETE FROM comments WHERE id = :commentId AND by_user_id = :userId';
    $statement = $database->prepare($deletePostQuery);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();


    $deleteReplysQuery = 'DELETE FROM replies WHERE on_comment_id = :commentId';
    $statement = $database->prepare($deleteReplysQuery);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    $statement->execute();

    $_SESSION['success'] = "Your comment is removed.";
}

redirect($_SERVER['HTTP_REFERER']);
