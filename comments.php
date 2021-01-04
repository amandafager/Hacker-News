<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php $id = $_GET['postId']; ?>

<?php $post = getPostsById($database, $id); ?>
<?php $comments = getCommentByPostId($database, $post['id']); ?>

<main>
    <a href="posts.php">Back</a>
    <?php if (isset($_SESSION['user'])) : ?>
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
    <?php else : ?>
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
            </div>
        </article>

        <section class="add-comment">
            <form action="login.php" method="post">
                <div class="">
                    <label for="comment"></label>
                    <textarea class="form-control" type="text" name="comment" id="comment" placeholder="Add comment" required value=""></textarea>
                    <input type="hidden" id="post-id" name="post-id" value="<?= $post['id']; ?>"></input>
                </div>
                <button type="sumbit" name="add-comment" class="btn btn-primary">Add comment</button>
            </form>
        </section>
    <?php endif; ?>


    <section class="comments">
        <?php foreach ($comments as $comment) : ?>
            <article class="comment">
                <p>by
                    <a href="#"><?= $comment['author']; ?></a>
                </p>
                <p><?= $comment['comment_created_at']; ?> </p>
                <p class="comment-text" data-id="<?= $comment['comment_id']; ?>"><?= $comment['comment']; ?> </p>


                <?php if (isset($_SESSION['user'])) : ?>

                    <?php if ($comment['by_user_id'] === $_SESSION['user']['id']) : ?>

                        <form class="edit-comment" action="app/comments/update.php" method="post" data-id="<?= $comment['comment_id']; ?>">
                            <label for="edit-comment"></label>
                            <textarea class="form-control" type="text" name="edit-comment" id="edit-comment" placeholder="" required value=""> <?= $comment['comment']; ?> </textarea>
                            <input type="hidden" id="comment-id" name="comment-id" value="<?= $comment['comment_id'] ?>"></input>
                            <input type="hidden" id="post-id" name="post-id" value="<?= $post['id']; ?>"></input>
                            <button type="submit" name="edit" value="Submit">Save</button>
                        </form>

                        <form action="app/comments/delete.php" method="post">
                            <input type="hidden" id="comment-id" name="comment-id" value="<?= $comment['comment_id'] ?>"></input>
                            <button type="submit" name="delete-comment" value="Submit">Delete</button>
                        </form>

                        <button class="edit-comment-btn" data-id="<?= $comment['comment_id']; ?>">Edit</button>
                    <?php endif; ?>
                <?php endif; ?>
            </article>

        <?php endforeach; ?>
    </section>

</main>
<?php require __DIR__ . '/views/footer.php'; ?>