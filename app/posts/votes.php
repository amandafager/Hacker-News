<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

header('Content-Type: application/json');


if (isset($_POST['vote'])) {
    $userId = $_SESSION['user']['id'];
    $postId = filter_var($_POST['vote'], FILTER_SANITIZE_NUMBER_INT);

    if (isUpvoted($database, (int) $_SESSION['user']['id'], (int) $postId)) { //Checks if user has voted, if vote exist - remove the vote
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

        $numberOfVotes = numberOfVotes($database, $postId);
        $status = true;

        $response = [
            'numberOfVotes' => $numberOfVotes,
            'status' => $status
        ];
        echo json_encode($response);
    } else { // If vote do not exist from user - add vote
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
        $numberOfVotes = numberOfVotes($database, $postId);
        $status = false;

        $response = [
            'numberOfVotes' => $numberOfVotes,
            'status' =>  $status
        ];
        echo json_encode($response);
    }
} else {
    $_SESSION['message'] = "You have to be logged in to upvote.";
    redirect('../../login.php');
}
