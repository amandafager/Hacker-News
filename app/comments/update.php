<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we update comments in the database.

if (isset($_POST['comment-id'], $_POST['edit-comment'], $_POST['post-id'])) {

    $comment = sanitizeText($_POST['edit-comment']);
    $commentId = filter_var($_POST['comment-id'], FILTER_SANITIZE_NUMBER_INT);
    $postId = filter_var($_POST['post-id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];

    $updateCommentQuery = 'UPDATE comments SET comment = :comment WHERE id = :id AND by_user_id = :userId';
    $statement = $database->prepare($updateCommentQuery);

    $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
    $statement->bindParam(':id', $commentId, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);

    $statement->execute();
}

redirect($_SERVER['HTTP_REFERER']);
