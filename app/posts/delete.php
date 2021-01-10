<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete new posts in the database.

if (isset($_POST['id'])) {

    $postId = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];

    $deletePostQuery = 'DELETE FROM posts WHERE id = :postId AND user_id = :userId';
    $statement = $database->prepare($deletePostQuery);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();


    $deleteCommentsQuery = 'DELETE FROM comments WHERE on_post_id = :postId';
    $statement = $database->prepare($deleteCommentsQuery);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();


    $deleteVotesQuery = 'DELETE FROM votes WHERE post_id = :postId';
    $statement = $database->prepare($deleteVotesQuery);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $_SESSION['success'] = "Your post is removed.";
}

redirect('/index.php?userId=' . $_SESSION['user']['id'] . '&name=' . $_SESSION['user']['username']);
