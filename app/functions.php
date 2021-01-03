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


function getPostsById(PDO $database, int $id): array
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


function newPostsOrderByLikes(PDO $database): array
{
    $statement = $database->prepare('SELECT * FROM posts ORDER BY votes DESC');

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->execute();

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['post'] = $posts;

    return $_SESSION['post'];
}


function newPostsOrderByCreatedAt(PDO $database): array
{
    $statement = $database->prepare('SELECT * FROM posts ORDER BY created_at DESC');

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->execute();

    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['post'] = $posts;

    return $_SESSION['post'];
}


//Check if a user has voted on a post or not
function checkVoteStatus(PDO $database, int $userId, int $postId): bool
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



function sessionInput()
{
    if (isset($_SESSION['input'])) {
        echo $_SESSION['input'];
        unset($_SESSION['input']);
    }
}
