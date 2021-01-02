<?php

declare(strict_types=1);

function redirect(string $path)
{
    header("Location: ${path}");
    exit;
}

//Functions that sanitize and validates emails
function sanitizeEmail(string $email): string
{
    return strtolower(trim(filter_var($email, FILTER_SANITIZE_EMAIL)));
}

//Dont work
function validateEmail(string $email): bool
{
    $isValid = filter_var($email, FILTER_VALIDATE_EMAIL);
    $isValid = true;
    return $isValid;
}

//Functions that sanitize and validates text fiels
function sanitizeText(string $text): string
{
    return trim(filter_var($text, FILTER_SANITIZE_SPECIAL_CHARS));
}

//Functions that sanitize and validates URLs
function sanitizeUrl(string $url): string
{
    return trim(filter_var($url, FILTER_SANITIZE_URL));
}
//Dont work
function validateUrl(string $url): bool
{
    return (filter_var($url, FILTER_VALIDATE_URL));
}

function sanitizeString(string $string): string
{
    return trim(filter_var($string, FILTER_SANITIZE_STRING));
}




function getPostsByUserId($database, int $userId): array
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


function getPostsById($database, int $id): array
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


function newPostsOrderByLikes($database): array
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


function newPostsOrderByCreatedAt($database): array
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
