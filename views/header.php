<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title><?php echo $config['title']; ?></title>

    <link rel="stylesheet" href="assets/styles/normalize.css">
    <link rel="stylesheet" href="/assets/styles/nav.css">
    <link rel="stylesheet" href="assets/styles/global.css">
    <link rel="stylesheet" href="/assets/styles/app.css">
    <link rel="stylesheet" href="/assets/styles/login.css">
    <link rel="stylesheet" href="/assets/styles/confirmBox.css">
    <link rel="stylesheet" href="assets/styles/post.css">
</head>

<body class="loading">
    <?php require __DIR__ . '/navigation.php'; ?>

    <div class="container py-5">