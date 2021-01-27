<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

header('Content-Type: application/json');

if (isset($_POST['vote'])) {
    $userId = $_SESSION['user']['id'];
    $commentId = filter_var($_POST['vote'], FILTER_SANITIZE_NUMBER_INT);

    if (isCommentUpvoted($database, (int) $_SESSION['user']['id'], (int) $commentId)) { //Checks if user has voted, if vote exist - remove the vote
        $query = 'UPDATE comments SET votes = votes - 1 WHERE id = :commentId';
        $statement = $database->prepare($query);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }
        $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
        $statement->execute();

        $query = 'DELETE FROM comment_votes WHERE user_id = :userId AND comment_id = :commentId';
        $statement = $database->prepare($query);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }

        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
        $statement->execute();

        $numberOfVotes = numberOfCommentVotes($database, $commentId);
        $status = true;

        $response = [
            'numberOfVotes' => $numberOfVotes,
            'status' => $status
        ];
        echo json_encode($response);
    } else { // If vote do not exist from user - add vote
        $query = 'UPDATE comments SET votes = votes + 1 WHERE id = :commentId';
        $statement = $database->prepare($query);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }

        $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
        $statement->execute();

        $query = 'INSERT INTO comment_votes (id, user_id, comment_id) VALUES (:id, :userId, :commentId)';
        $statement = $database->prepare($query);

        if (!$statement) {
            die(var_dump($database->errorInfo()));
        }

        $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
        $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
        $statement->execute();
        $numberOfVotes = numberOfCommentVotes($database, $commentId);
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
