<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<?php $userId = $_GET['id']/*$_SESSION['user']['id']*/; ?>

<main>
    <article>
        <h1>Profile</h1>
        <p>This is the profile page.</p>
    </article>
</main>
<?php require __DIR__ . '/views/footer.php'; ?>