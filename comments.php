<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php $postId = $_GET['postId']; ?>

<?php $post = getPostByPostId($database, $postId); ?>
<?php $comments = getCommentsByPostId($database, $post['id']); ?>

<main>

    <!--<a href="posts.php">Back</a>-->
    <a class="go-back" href="">Back</a>


    <?php if (isset($_SESSION['user'])) : ?>

        <article class="post" id="<?= $post['id']; ?>">
            <div class="top">
                <div class="top-left">
                    <form action="app/posts/votes.php" method="post">
                        <input type="hidden" id="post-id" name="vote" value="<?= $post['id']; ?>"></input>
                        <button class="vote-btn" type="submit" value="Submit">
                            <?php if (isUpvoted($database, $_SESSION['user']['id'], $post['id'])) : ?>
                                <?= "Unvote"; ?>
                            <?php else : ?>
                                <?= "Upvote"; ?>
                            <?php endif; ?>
                        </button>
                    </form>
                    <p>by <a href="profile.php?userId=<?= $post['user_id']; ?>"><?= $post['author']; ?></a></p>
                </div>
                <p><?= $post['created_at']; ?></p>
            </div>
            <div class="post-content">
                <a class="title" href="<?= $post['url']; ?>">
                    <h3><?= $post['title']; ?></h3>
                </a>
                <p><?= $post['description']; ?></p>
            </div>
            <ul class="bottom">
                <li>
                    <p><?= $post['votes']; ?> points</p>
                </li>
                <li>
                    <a class="" href="comments.php?postId=<?= $post['id']; ?>"><?= numberOfComments($database, $postId); ?></a>
                </li>
                <li>
                    <a class="edit-post" href="editPost.php?postId=<?= $post['id']; ?>">edit</a>
                </li>
                <li>
                    <form action="app/posts/delete.php" method="post">
                        <input type="hidden" id="post-id" name="post-id" value="<?= $post['id'] ?>"></input>
                        <button class="delete-btn" type="submit" name="delete-post" value="Submit">delete</button>
                    </form>
                </li>
            </ul>
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

        <article class="post" id="<?= $post['id']; ?>">
            <div class="top">
                <div class="top-left">
                    <form action="login.php" method="post">
                        <input type="hidden" id="post-id" name="vote" value="<?= $post['id']; ?>"></input>
                        <button class="vote-btn" type="submit" value="Submit">Upvote</button>
                    </form>
                    <p>by <a href="profile.php"><?= $post['author']; ?></a></p>
                </div>
                <p><?= $post['created_at']; ?></p>
            </div>
            <div class="post-content">
                <a class="title" href="<?= $post['url']; ?>">
                    <h3><?= $post['title']; ?></h3>
                </a>
                <p><?= $post['description']; ?></p>
            </div>
            <ul class="bottom">
                <li>
                    <p><?= $post['votes']; ?> points</p>
                </li>
                <li>
                    <a class="" href="comments.php?postId=<?= $post['id']; ?>"><?= numberOfComments($database, $postId); ?> </a>
                </li>
            </ul>
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
            <article class="comment" id="<?= $comment['comment_id'] ?>">
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