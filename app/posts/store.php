<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we store/insert new posts in the database.


if (isset($_POST['submit-post'])) {

    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
    $description = trim(filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS));
    $userId = $_SESSION['user']['id'];
    $author = $_SESSION['user']['username'];
    $created = date('Y-m-d h:m:s');

    $createPostQuery = 'INSERT INTO posts (id, user_id, author, title, url, description, created_at) VALUES (:id, :userId, :author, :title, :url, :description, :created)';
    $statement = $database->prepare($createPostQuery);

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':author', $author, PDO::PARAM_STR);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':url', $url, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':created', $created, PDO::PARAM_STR);
    $statement->execute();
}

redirect('/posts.php?userId=' . $_SESSION['user']['id']);
