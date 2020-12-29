<?php

declare(strict_types=1);

function redirect(string $path)
{
    header("Location: ${path}");
    exit;
}

function sanitizeEmail(string $email): string
{
    return strtolower(trim(filter_var($email, FILTER_SANITIZE_EMAIL)));
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
