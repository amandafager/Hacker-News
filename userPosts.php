<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php $userId = $_GET['userId']; ?>
<?php $posts = getPostsByUserId($database, $userId); ?>

<main>
    <a href="profile.php">Back</a>
    <?php $number = 1; ?>
    <?php foreach ($posts as $post) : ?>
        <article class="post">
            <div>
                <p><?= $number++; ?></p>
            </div>


            <div class="title">

                <a href="<?= $post['url']; ?>">
                    <h3><?= $post['title']; ?></h3>
                </a>
            </div>
            <p><?= $post['description']; ?></p>
            <div class="post-info">
                <p><?= $post['votes']; ?> Votes</p>
                <p>by <a href="profil.php"><?= $post['author']; ?></a></p>
                <p><?= $post['created_at']; ?></p>

                <a class="edit-post" href="editPost.php?postId=<?= $post['id']; ?>">Edit</a>

                <form action="app/posts/delete.php" method="post">
                    <input type="hidden" id="post-id" name="post-id" value="<?= $post['id']; ?>"></input>
                    <button type="submit" name="delete-post" value="Submit">Delete</button>
                </form>
                <a class="" href="comments.php?postId=<?= $post['id']; ?>">Comments</a>
            </div>
        </article>
    <?php endforeach; ?>

</main>

<?php require __DIR__ . '/views/footer.php'; ?>