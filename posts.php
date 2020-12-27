<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/app/posts.php'; ?>

<?php $id = $_GET['id']; ?>
<?php $posts = getPostsByUserId($database, $id); ?>

<main>
    <?php foreach ($posts as $post) : ?>
        <article>
            <h2><?= $post['title']; ?></h2>
            <a href="<?= $post['url']; ?>"><?= $post['url']; ?></a>
            <p><?= $post['description']; ?></p>
            <p><?= $post['author']; ?></p>
            <p><?= $post['created_at']; ?></p>
            <a href="editPost.php">Edit</a>
        </article>
    <?php endforeach; ?>

</main>

<?php require __DIR__ . '/views/footer.php'; ?>