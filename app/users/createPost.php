<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

$id = $_SESSION['user']['id'];

if (isset($_POST['title'], $_POST['url'], $POST['description'])) {

    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
    $description = $POST['description'];
    $userId = $_SESSION['user']['id'];
    $author = $_SESSION['user']['username'];
    $created = date('yy-mm-dd');

    $createPostQuery = 'INSERT INTO posts (id, user_id, author, title, url, description, created_at,) VALUES (:id, :userId, :author, :title, :url, :description, :created) LIMIT 1';
    $statement = $database->prepare($createPostQuery);

    if (!$statement) {
        die(var_dump($database->errorInfo()));
    }

    //$statement->bindParam(':id', $postId, PDO::PARAM_INT);
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':author', $author, PDO::PARAM_STR);
    $statement->bindParam(':title', $title, PDO::PARAM_STR);
    $statement->bindParam(':url', $url, PDO::PARAM_STR);
    $statement->bindParam(':description', $description, PDO::PARAM_STR);
    $statement->bindParam(':created', $created, PDO::PARAM_STR);
    $statement->execute();
}

redirect('/');
