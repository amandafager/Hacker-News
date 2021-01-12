<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we update comments in the database.

if (isset($_POST['edit-reply'])) {

    $reply = sanitizeText($_POST['edit-reply']);
    $replyId = filter_var($_POST['reply-id'], FILTER_SANITIZE_NUMBER_INT);
    $commentId = filter_var($_POST['comment-id'], FILTER_SANITIZE_NUMBER_INT);
    $postId = filter_var($_POST['post-id'], FILTER_SANITIZE_NUMBER_INT);
    $userId = $_SESSION['user']['id'];

    $updateReplyQuery = 'UPDATE replies SET comment = :reply WHERE id = :id AND on_post_id = :postId AND on_comment_id = :commentId AND by_user_id = :userId';
    $statement = $database->prepare($updateReplyQuery);

    $statement->bindParam(':reply', $reply, PDO::PARAM_STR);
    $statement->bindParam(':id', $replyId, PDO::PARAM_INT);
    $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);

    $statement->execute();
}

redirect($_SERVER['HTTP_REFERER']);
//redirect("/reply.php?commentId=" . $commentId  . "&postId=" . $postId . "&postTitle=" . $post['title']);
//redirect('/comments.php?postId=' . $postId . "#" . $commentId);
