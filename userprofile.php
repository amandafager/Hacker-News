<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<?php $userId = $_GET['userId']; ?>
<?php $user = getUserProfile($database, $userId); ?>



<main>
    <a class="go-back" href="">Back</a>
    <section>
        <h1>Profile</h1>
        <p>User: <?= $user['username']; ?> </p>
        <p>Created: <?= $user['created_at']; ?> </p>
        <div class="pro-img-container">
            <img src="/app/users/uploads/<?= $user['img_src']; ?>" alt="profile image">
        </div>
        <p>Biography: <?= $user['biography']; ?> </p>
        <a href="userPosts.php?userId=<?= $user['id']; ?>">posts</a>

    </section>
</main>
<?php require __DIR__ . '/views/footer.php'; ?>