<?php

declare(strict_types=1);

function redirect(string $path)
{
    header("Location: ${path}");
    exit;
}

//Functions for sanitize and validates emails
function sanitizeEmail(string $email): string
{
    return strtolower(trim(filter_var($email, FILTER_SANITIZE_EMAIL)));
}

function validateEmail(string $email): bool
{
    $isValid = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($isValid) {
        return true;
    } else {
        return false;
    }
}

//Function for sanitize text fiels
function sanitizeText(string $text): string
{
    return trim(filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS));
}

//Functions for sanitize and validates URLs
function sanitizeUrl(string $url): string
{
    return trim(filter_var($url, FILTER_SANITIZE_URL));
}

function validateUrl(string $url): bool
{
    $isValid = filter_var($url, FILTER_VALIDATE_URL);

    if ($isValid) {
        return true;
    } else {
        return false;
    }
}

//Function for sanitize text input type string, as name and title
function sanitizeString(string $string): string
{
    return trim(filter_var($string, FILTER_SANITIZE_STRING));
}




function getPostsByUserId(PDO $database, int $userId): array
{
    $statement = $database->prepare('SELECT * FROM posts WHERE user_id = :userId ORDER BY created_at DESC');

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}


function getUserProfile(PDO $database, int $userId): array
{
    $statement = $database->prepare('SELECT * FROM users WHERE id = :userId');

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
    unset($user['password']);

    return $user;
}


function getPostByPostId(PDO $database, int $id): array
{
    $statement = $database->prepare('SELECT * FROM posts WHERE id = :id');

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $post = $statement->fetch(PDO::FETCH_ASSOC);

    $_SESSION['post'] = $post;

    return $_SESSION['post'];
}


function getPostsOrderBy(PDO $database, string $orderBy): array
{
    $statement = $database->prepare("SELECT * FROM posts ORDER BY $orderBy DESC");

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->execute();

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}


//Check if a user has voted on a post or not
function isUpvoted(PDO $database, int $userId, int $postId): bool
{
    $query = 'SELECT * FROM votes WHERE user_id = :userId and post_id = :postId';
    $statement = $database->prepare($query);

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $vote = $statement->fetch(PDO::FETCH_ASSOC);

    if ($vote) { //If vote exist return true else false
        return true;
    } else {
        return false;
    }
}

function isCommentUpvoted(PDO $database, int $user_id, int $comment_id): bool
{
    $query = 'SELECT * FROM comment_votes WHERE user_id = :user_id AND comment_id = :comment_id';
    $statement = $database->prepare($query);

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $statement->bindParam(':comment_id', $comment_id, PDO::PARAM_INT);
    $statement->execute();

    $vote = $statement->fetch(PDO::FETCH_ASSOC);
    if ($vote) {
        return true;
    } else {
        return false;
    }
}


function getAllCommentsByPostId(PDO $database, int $postId): array
{
    $statement = $database->prepare('SELECT comments.id AS comment_id, on_post_id, by_user_id, comment, comments.created_at AS comment_created_at, users.id AS user_id_users, users.username AS author, replies.id AS reply_id, replies.on_post_id AS on_post_id_replies, replies.on_comment_id AS reply_on_comment_id, replies.by_user_id AS reply_by_user_id, replies.comment AS reply, replies.created_at AS reply_created FROM comments INNER JOIN users ON users.id = comments.by_user_id INNER JOIN replies ON comments.id = replies.on_comment_id WHERE on_post_id = :postId ORDER BY comment_created_at DESC');

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }

    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $comments;
}


function getCommentsByPostId(PDO $database, int $postId): array
{
    $statement = $database->prepare('SELECT comments.id AS comment_id, on_post_id, by_user_id, comment, comments.created_at AS comment_created_at, users.id AS user_id_users, users.username AS author FROM comments INNER JOIN users ON users.id = comments.by_user_id WHERE on_post_id = :postId ORDER BY comment_created_at DESC');

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }

    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $comments = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $comments;
}


function getCommentByCommentId(PDO $database, int $commentId): array
{

    $statement = $database->prepare('SELECT comments.id AS id, on_post_id, by_user_id, comment, comments.created_at AS created_at, users.username as username FROM comments INNER JOIN users ON users.id = comments.by_user_id WHERE comments.id = :commentId');

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }

    $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    $statement->execute();

    $comment = $statement->fetch(PDO::FETCH_ASSOC);

    return $comment;
}


function getReplysByCommentId(PDO $database, int $commentId): array
{
    $statement = $database->prepare('SELECT replies.id AS id, on_post_id, on_comment_id, by_user_id, comment, replies.created_at AS created_at, users.username as username FROM replies INNER JOIN users ON users.id = replies.by_user_id WHERE replies.on_comment_id = :commentId ORDER BY replies.created_at DESC');

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }

    $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);
    $statement->execute();

    $replies = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $replies;
}


function numberOfVotes(PDO $database, int $postId): string
{
    $statement = $database->prepare('SELECT * FROM posts WHERE id = :postId');
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);

    $statement->execute();

    $post = $statement->fetch(PDO::FETCH_ASSOC);

    $votes = $post['votes'];
    if ($votes == 1) {
        return "$votes point";
    } else {
        return "$votes points";
    }
}

function numberOfCommentVotes(PDO $database, int $commentId): string
{
    $statement = $database->prepare('SELECT * FROM comments WHERE id = :commentId');
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':commentId', $commentId, PDO::PARAM_INT);

    $statement->execute();

    $comment = $statement->fetch(PDO::FETCH_ASSOC);

    $votes = $comment['votes'];
    if ($votes == 1) {
        return "$votes point";
    } else {
        return "$votes points";
    }
}

function numberOfComments(PDO $database, int $postId): string
{
    $comments = getCommentsByPostId($database, $postId);

    $numberOfComments = count($comments);

    if ($numberOfComments === 0) {
        $text = "discuss";
        return $text;
    } else if ($numberOfComments === 1) {
        $text = "$numberOfComments comment";
        return $text;
    } else {
        $text = "$numberOfComments comments";
        return $text;
    }
}


function formatDate(string $date): string
{

    $saved_time = $date;
    $formated_saved_time = new DateTime($saved_time);
    $current_time = new DateTime();
    $interval = $current_time->diff($formated_saved_time);

    if (!empty($interval->format('%a'))) {
        $time_difference = $interval->format('%ad ago');
        return $time_difference;
    } elseif ($formated_saved_time->format('d') != $current_time->format('d')) {
        $time_difference = "yesterday";
        return $time_difference;
    } elseif (!empty($interval->format('%h'))) {
        $time_difference = $interval->format('%hh, %im ago');
        return $time_difference;
    } elseif (!empty($interval->format('%i'))) {
        $time_difference = $interval->format('%im ago');
        return $time_difference;
    } elseif (!empty($interval->format('%s'))) {
        $time_difference = $interval->format('%ss ago');
        return $time_difference;
    } else {
        $time_difference = "Now";
        return $time_difference;
    }
}

function deleteContent(PDO $database, int $userId, string $query): void
{
    $statement = $database->prepare($query);
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();
}
