<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

if (isset($_POST['id'])) {
    $userId = (int)filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    // Delete users upvotes
    $query = 'DELETE FROM votes WHERE user_id = :userId';
    deleteContent($database, $userId, $query);
    $query = 'DELETE FROM comment_votes WHERE user_id = :userId';
    deleteContent($database, $userId, $query);
    // Add functionality for reducing votes in posts and comment table when removing votes.

    // Delete users comments
    // Fetches the comments that are about to be deleted
    $query = 'SELECT id FROM comments WHERE by_user_id = :userId';
    $statement = $database->prepare($query);
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();
    $deletedComments = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Delete replies to comments about to get deleted
    $query = 'DELETE FROM replies WHERE on_comment_id = :commentId';
    foreach ($deletedComments as $deletedComment) {
        $statement = $database->prepare($query);
        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':commentId', $deletedComment['id'], PDO::PARAM_STR);
        $statement->execute();
    }

    // Actually deletes the comments
    $query = 'DELETE FROM comments WHERE by_user_id = :userId';
    deleteContent($database, $userId, $query);

    // Delete users replies
    $query = 'DELETE FROM replies WHERE by_user_id = :userId';
    deleteContent($database, $userId, $query);

    // Delete posts
    // Fetch the posts that are to be deleted
    $query = 'SELECT id FROM posts WHERE user_id = :userId';
    $statement = $database->prepare($query);
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();
    $deletedPosts = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Delete votes
    $query = 'DELETE FROM votes WHERE post_id = :postId';
    foreach ($deletedPosts as $deletedPost) {
        $statement = $database->prepare($query);
        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':postId', $deletedPost['id'], PDO::PARAM_STR);
        $statement->execute();
    }

    // Delete replies
    $query = 'DELETE FROM replies WHERE on_post_id = :postId';
    foreach ($deletedPosts as $deletedPost) {
        $statement = $database->prepare($query);
        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':postId', $deletedPost['id'], PDO::PARAM_STR);
        $statement->execute();
    }

    // Delete comments
    $query = 'DELETE FROM comments WHERE on_post_id = :postId';
    foreach ($deletedPosts as $deletedPost) {
        $statement = $database->prepare($query);
        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':postId', $deletedPost['id'], PDO::PARAM_STR);
        $statement->execute();
    }

    // Actually delete the posts
    $query = 'DELETE FROM posts WHERE user_id = :userId';
    deleteContent($database, $userId, $query);

    // Delete account info
    $query = 'DELETE FROM users WHERE id = :userId';
    deleteContent($database, $userId, $query);

    unset($_SESSION['user']);
}

redirect('/');
