<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php if (isset($_GET['new'])) : ?>
    <?php $posts = newPostsOrderByCreatedAt($database); ?>
<?php else : ?>
    <?php $posts = newPostsOrderByLikes($database); ?>
<?php endif; ?>

<main>
    <?php foreach ($posts as $post) : ?>
        <?php if (isset($_SESSION['user'])) : ?>
            <?php if ($post['user_id'] === $_SESSION['user']['id']) : ?>
                <article class="user-posts">
                    <div class="title">
                        <a href="<?= $post['url']; ?>">
                            <h3><?= $post['title']; ?></h3>
                        </a>
                    </div>
                    <p><?= htmlspecialchars($post['description']); ?></p>
                    <div class="post-info">
                        <p>Likes</p>
                        <p>by <a href="#"><?= $post['author']; ?></a></p>
                        <p><?= $post['created_at']; ?></p>
                        <span>|</span>
                        <a class="edit-post" href="editPost.php?postId=<?= $post['id']; ?>">Edit</a>
                        <span>|</span>
                        <form action="app/posts/delete.php" method="post">
                            <input type="hidden" id="post-id" name="post-id" value="<?= $post['id'] ?>"></input>
                            <button type="submit" name="delete-post" value="Submit">Delete</button>
                        </form>
                        <span>|</span>
                        <a class="" href="">Comments</a>
                    </div>
                </article>
            <?php else : ?>
                <article class="user-posts">
                    <div class="title">
                        <a href="<?= $post['url']; ?>">
                            <h3><?= $post['title']; ?></h3>
                        </a>
                    </div>
                    <p><?= htmlspecialchars($post['description']); ?></p>
                    <div class="post-info">
                        <form action="app/posts/votes.php" method="post">
                            <input type="hidden" id="post-id" name="vote" value="<?= $post['id'] ?>"></input>
                            <button class="like-btn" type="submit" value="Submit">Upvote</button>
                        </form>
                        <p><?= $post['votes']; ?> Votes</p>
                        <p>by <a href="#"><?= $post['author']; ?></a></p>
                        <p><?= $post['created_at']; ?></p>
                        <span>|</span>
                        <a class="" href="">Comments</a>
                    </div>
                </article>
            <?php endif; ?>
        <?php else : ?>
            <article class="user-posts">
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
                    <a class="" href="">Comments</a>
                </div>
            </article>
        <?php endif; ?>
    <?php endforeach; ?>

</main>

<?php require __DIR__ . '/views/footer.php'; ?>