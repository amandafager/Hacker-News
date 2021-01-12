<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we delete comments in the database.

if (isset($_POST['id'])) {

    $replyId = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];

    $deleteReplyQuery = 'DELETE FROM replies WHERE id = :replyId AND by_user_id = :userId';
    $statement = $database->prepare($deleteReplyQuery);

    if (!$statement) {
        die(var_dump($pdo->errorInfo()));
    }

    $statement->bindParam(':replyId', $replyId, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();

    $_SESSION['success'] = "Your comment is removed.";
}

redirect($_SERVER['HTTP_REFERER']);
