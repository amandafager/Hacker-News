<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we store/insert new comments in the database.

if (isset($_POST['comment'], $_POST['post-id'])) {

    $postId = filter_var($_POST['post-id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];
    $comment = sanitizeText($_POST['comment']);
    $created = date('Y-m-d h:m:s');

    $createCommentQuery = 'INSERT INTO comments (id, on_post_id, by_user_id, comment, created_at) VALUES (:id, :postId, :userId, :comment, :created)';
    $statement = $database->prepare($createCommentQuery);

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }

    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
    $statement->bindParam(':created', $created, PDO::PARAM_STR);
    $statement->execute();
}

redirect($_SERVER['HTTP_REFERER']);
