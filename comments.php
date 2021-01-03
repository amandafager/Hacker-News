<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php $id = $_GET['postId']; ?>

<?php $post = getPostsById($database, $id); ?>

<main>
    <a href="<?= $_SERVER['HTTP_REFERER'] ?>">Back</a>

    <article class="post">
        <form action="app/posts/votes.php" method="post">
            <input type="hidden" id="post-id" name="vote" value="<?= $post['id']; ?>"></input>
            <button class="vote-btn" type="submit" value="Submit">
                <?php if (checkVoteStatus($database, $_SESSION['user']['id'], $post['id'])) : ?>
                    <?= "Unvote"; ?>
                <?php else : ?>
                    <?= "Upvote"; ?>
                <?php endif; ?>
            </button>
        </form>
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
            <a class="" href="comments.php?postId=<?= $post['id']; ?>">Comments</a>
        </div>
    </article>

    <section>
        <form action="app/comments/store.php" method="post">
            <div class="">
                <label for="comment"></label>
                <textarea class="form-control" type="text" name="comment" id="comment" placeholder="Add comment" required value=""></textarea>
                <input type="hidden" id="post-id" name="post-id" value="<?= $post['id']; ?>"></input>
            </div>
            <button type="submit" name="add-comment" class="btn btn-primary">Add comment</button>
        </form>
    </section>

    <section class="comments">
        <article>

        </article>
    </section>

</main>
<?php require __DIR__ . '/views/footer.php'; ?>