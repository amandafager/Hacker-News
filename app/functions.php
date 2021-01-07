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



function numberOfVotes(PDO $database, int $postId): string
{
    /*$statement = $database->prepare('SELECT count(id) FROM votes WHERE post_id = :postId');
    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }

    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $count = $statement->fetch(PDO::FETCH_ASSOC);;

    $votes = count($count);
    return  $votes;*/

    $statement = $database->prepare('SELECT * FROM posts WHERE id = :postId');

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }

    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);
    $statement->execute();

    $post = $statement->fetch(PDO::FETCH_ASSOC);;

    $votes = $post['votes'];

    if ($votes <= 1) {
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
