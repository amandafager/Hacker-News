<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/messages.php'; ?>

<?php if (isset($_GET['commentId'], $_GET['postId'], $_GET['postTitle'])) : ?>
    <?php $commentId = $_GET['commentId']; ?>
    <?php $postId =  $_GET['postId']; ?>
    <?php $postTitle = $_GET['postTitle']; ?>
<?php endif; ?>


<?php $comment = getCommentByCommentId($database, $commentId); ?>
<?php $replies = getReplysByCommentId($database, $commentId); ?>


<main>

    <?php SessionSuccess(); ?>


    <section class="comments">

        <h1>On:
            <a href="comments.php?postId=<?= $postId; ?>"><?= $postTitle; ?></a>
        </h1>

        <article class="comment" id="<?= $comment['id'] ?>">
            <div class="comment-top text-secondary">

                <p>Comment by
                    <a href="profile.php?userId=<?= $comment['by_user_id']; ?>"> <?= $comment['username']; ?> </a>
                </p>

                <time><?= formatDate($comment['created_at']); ?> </time>

            </div>

            <p class="comment-text" data-id="<?= $comment['id']; ?>"><?= $comment['comment']; ?> </p>

            <?php if (isset($_SESSION['user'])) : ?>
                <?php if ($comment['by_user_id'] === $_SESSION['user']['id']) : ?>
                    <form class="edit-comment-form" action="app/comments/update.php" method="post" data-id="<?= $comment['id']; ?>">
                        <div class="input-group mb-3">
                            <textarea type="text" name="edit-comment" class="form-control" rows="3" required><?= $comment['comment']; ?> </textarea>
                            <button class="save-edit-btn btn btn-outline-secondary" type="submit" name="edit" id="button-addon2" value="Submit">Save</button>
                        </div>

                        <input type="hidden" id="comment-id" name="comment-id" value="<?= $comment['id'] ?>"></input>
                        <input type="hidden" id="post-id" name="post-id" value="<?= $postId; ?>"></input>
                    </form>

                    <ul class="comment-bottom">
                        <li>
                            <button class="edit-comment-btn" data-id="<?= $comment['id']; ?>">Edit</button>
                        </li>

                        <li>
                            <button class="delete-comment-btn delete-btn-on-post" type="submit" value="<?= $commentId; ?>">Delete</button>
                        </li>
                    </ul>

                <?php endif; ?>
            <?php endif; ?>

        </article>

    </section>


    <section class="add-comment-wrapper">
        <form class="add-comment-form" action="app/replies/store.php" method="post">

            <div class="form-group">
                <label for="comment"></label>
                <textarea class="form-control" type="text" name="reply" id="comment" placeholder="Add reply" required rows="3"></textarea>
            </div>

            <button class="add-comment-btn btn btn-secondary" type="submit" name="add-reply">Add reply</button>
            <input type="hidden" id="post-id" name="comment-id" value="<?= $comment['id']; ?>"></input>
            <input type="hidden" id="post-id" name="post-id" value="<?= $postId; ?>"></input>

        </form>
    </section>


    <section class="Replies">

        <h2>Replies</h2>

        <?php foreach ($replies as $reply) : ?>
            <article class="comment" id="<?= $reply['id'] ?>">

                <div class="comment-top text-secondary">
                    <p>@ <?= $comment['username']; ?></p>
                    <p>by
                        <a href="profile.php?userId=<?= $reply['by_user_id']; ?>"><?= $reply['username']; ?></a>
                    </p>
                    <time><?= formatDate($reply['created_at']); ?></time>
                </div>

                <p class="comment-text" data-id="<?= $reply['id'] ?>"><?= $reply['comment']; ?> </p>

                <form class="edit-comment-form" action="app/replies/update.php" method="post" data-id="<?= $reply['id']; ?>">
                    <div class="input-group mb-3">
                        <textarea type="text" name="edit-reply" class="form-control" rows="3" required><?= $reply['comment']; ?> </textarea>
                        <button class="save-edit-btn btn btn-outline-secondary" type="submit" name="edit" id="button-addon2" value="Submit">Save</button>
                    </div>

                    <input type="hidden" id="reply-id" name="reply-id" value="<?= $reply['id']; ?>"></input>
                    <input type="hidden" id="comment-id" name="comment-id" value="<?= $comment['id']; ?>"></input>
                    <input type="hidden" id="post-id" name="post-id" value="<?= $postId; ?>"></input>
                </form>

                <?php if (isset($_SESSION['user'])) : ?>
                    <?php if ($reply['by_user_id'] === $_SESSION['user']['id']) : ?>
                        <ul class="comment-bottom">
                            <li>
                                <button class="edit-comment-btn" data-id="<?= $reply['id']; ?>">Edit</button>
                            </li>

                            <li>
                                <button class="delete-reply-btn delete-btn-on-post" type="submit" value="<?= $reply['id']; ?>">Delete</button>
                            </li>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>

            </article>

        <?php endforeach; ?>

    </section>

</main>

<?php require __DIR__ . '/views/footer.php'; ?>