<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete new posts in the database.

if (isset($_POST['comment-id'])) {

    $commentId = filter_var($_POST['comment-id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];

    $deletePostQuery = 'DELETE FROM comments WHERE id = :commentId AND by_user_id = :userId';
    $statement = $database->prepare($deletePostQuery);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();
}

redirect($_SERVER['HTTP_REFERER']);
