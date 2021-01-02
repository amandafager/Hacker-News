<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php $userId = $_GET['userId']; ?>
<?php $posts = getPostsByUserId($database, $userId); ?>

<main>
    <a href=" profile.php">Back</a>

    <?php foreach ($posts as $post) : ?>
        <article class="post">
            <div class="title">
                <a href="<?= $post['url']; ?>">
                    <h3><?= $post['title']; ?></h3>
                </a>
            </div>
            <p><?= htmlspecialchars($post['description']); ?></p>
            <div class="post-info">
                <p><?= $post['votes']; ?> Votes</p>
                <p>by <a href="#"><?= $post['author']; ?></a></p>
                <p><?= $post['created_at']; ?></p>
                <span>|</span>
                <a class="edit-post" href="editPost.php?postId=<?= $post['id']; ?>">Edit</a>
                <span>|</span>
                <form action="app/posts/delete.php" method="post">
                    <input type="hidden" id="post-id" name="post-id" value="<?= $post['id']; ?>"></input>
                    <button type="submit" name="delete-post" value="Submit">Delete</button>
                </form>
            </div>
        </article>
    <?php endforeach; ?>

</main>

<?php require __DIR__ . '/views/footer.php'; ?>