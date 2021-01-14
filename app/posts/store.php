<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we store/insert new posts in the database.

if (isset($_POST['submit-post'])) {
    $title = sanitizeString($_POST['title']);
    $url = sanitizeUrl($_POST['url']);
    $description = sanitizeText($_POST['description']);
    $userId = $_SESSION['user']['id'];
    $author = $_SESSION['user']['username'];
    $created = strftime('%Y-%m-%d %H:%M:%S');

    if (!validateUrl($url)) {
        $_SESSION['error'] = 'The' . $url . 'is not valid!';
        redirect('/createPost.php');
    } else {
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
        $_SESSION['success'] = "Your post is submited.";
    }
}

redirect('/index.php?userId=' . $_SESSION['user']['id'] . '&name=' . $_SESSION['user']['username']);
