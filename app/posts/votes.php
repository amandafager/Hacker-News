<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';


if (isset($_POST['vote'])) {

    $userId = $_SESSION['user']['id'];
    $postId = filter_var($_POST['vote'], FILTER_SANITIZE_NUMBER_INT);

    $query = 'SELECT * FROM votes WHERE user_id = :userId and post_id = :postId';
    $statement = $database->prepare($query);

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $vote = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$vote) {

        $query = 'UPDATE posts SET votes = votes + 1 WHERE id = :postId';
        $statement = $database->prepare($query);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }

        $statement->bindParam(':postId', $postId, PDO::PARAM_INT);

        $statement->execute();

        $query = 'INSERT INTO votes (id, user_id, post_id) VALUES (:id, :userId, :postId)';
        $statement = $database->prepare($query);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }

        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
        $statement->execute();
    } else {

        $_SESSION['vote'] = "Upvote";

        $query = 'UPDATE posts SET votes = votes - 1 WHERE id = :postId';
        $statement = $database->prepare($query);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
        $statement->execute();

        $query = 'DELETE FROM votes WHERE user_id = :userId AND post_id = :postId';
        $statement = $database->prepare($query);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }

        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
        $statement->execute();
    }
}

redirect('/newPosts.php');
