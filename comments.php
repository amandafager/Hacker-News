<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php $postId = $_GET['postId']; ?>
<?php $post = getPostByPostId($database, $postId); ?>
<?php $comments = getCommentsByPostId($database, $post['id']); ?>

<main>

    <?php SessionSuccess(); ?>


    <article class="post" id="<?= $post['id']; ?>">
        <div class="top text-secondary">
            <div class="top-left">

                <?php if (isset($_SESSION['user'])) : ?>
                    <form class="vote" action="app/posts/votes.php" method="post">
                        <input type="hidden" id="post-id" name="vote" value="<?= $post['id']; ?>"></input>
                        <?php if (isUpvoted($database, $_SESSION['user']['id'], $post['id'])) : ?>
                            <button style="background-color: var(--main-orange);" class=" vote-btn" type="submit" value="Submit" data-id="<?= $post['id']; ?>"></button>
                        <?php else : ?>
                            <button style="background-color: grey;" class="vote-btn" type="submit" value="Submit" data-id="<?= $post['id']; ?>"></button>
                        <?php endif; ?>
                    </form>
                <?php else : ?>
                    <form class="vote-offline" action="app/posts/votes.php" method="post">
                        <button name="vote-offline" class="vote-btn-offline" style="background-color: grey;"></button>
                    </form>
                <?php endif; ?>

                <p>by <a href="profile.php?userId=<?= $post['user_id']; ?>"><?= $post['author']; ?></a></p>
            </div>
            <time><?= formatDate($post['created_at']); ?></time>
        </div>

        <div class="post-content">
            <a class="title" href="<?= $post['url']; ?>">
                <h2><?= $post['title']; ?></h2>
            </a>
            <?php if (!empty($post['description'])) : ?>
                <details>
                    <summary><span class="open-details">View description</span><span class="close-details">Hide description</span></summary>
                    <p><?= $post['description']; ?></p>
                </details>
            <?php endif; ?>
        </div>

        <ul class="bottom">
            <li>
                <p class="number-of-votes text-secondary" data-id="<?= $post['id']; ?>"><?= numberOfVotes($database, $post['id']) ?> </p>
            </li>
            <li>
                <a class="" href="comments.php?postId=<?= $post['id']; ?>"><?= numberOfComments($database, $post['id']); ?></a>
            </li>

            <?php if (isset($_SESSION['user'])) : ?>
                <?php if ($post['user_id'] === $_SESSION['user']['id']) : ?>
                    <li>
                        <a class="edit-post" href="editPost.php?postId=<?= $post['id']; ?>">Edit</a>
                    </li>

                    <li>
                        <button class="delete-btn delete-btn-on-post" type="submit" name="delete-post" value="<?= $post['id']; ?>">Delete</button>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

        </ul>
    </article>


    <section class="add-comment-wrapper">
        <form class="add-comment-form" action="app/comments/store.php" method="post">

            <div class="form-group">
                <label for="comment"></label>
                <textarea class="form-control" type="text" name="comment" id="comment" placeholder="Add comment" required rows="3"></textarea>
            </div>

            <button class="add-comment-btn btn btn-secondary" type="submit" name="add-comment">Add comment</button>
            <input type="hidden" id="post-id" name="post-id" value="<?= $post['id']; ?>"></input>

        </form>
    </section>


    <section class="comments">
        <h1>Comments</h1>

        <?php foreach ($comments as $comment) : ?>

            <article class="comment" id="<?= $comment['comment_id'] ?>">
                <div class="comment-top text-secondary">
                    <p>by
                        <a href="profile.php?userId=<?= $comment['by_user_id']; ?>"><?= $comment['author']; ?></a>
                    </p>
                    <time><?= formatDate($comment['comment_created_at']); ?> </time>
                </div>

                <p class="comment-text" data-id="<?= $comment['comment_id']; ?>"><?= $comment['comment']; ?> </p>

                <form class="edit-comment-form" action="app/comments/update.php" method="post" data-id="<?= $comment['comment_id']; ?>">

                    <div class="input-group mb-3">
                        <textarea type="text" name="edit-comment" class="form-control" rows="3" required><?= $comment['comment']; ?> </textarea>
                        <button class="save-edit-btn btn btn-outline-secondary" type="submit" name="edit" id="button-addon2" value="Submit">Save</button>
                    </div>

                    <input type="hidden" id="comment-id" name="comment-id" value="<?= $comment['comment_id'] ?>"></input>
                    <input type="hidden" id="post-id" name="post-id" value="<?= $post['id']; ?>"></input>
                </form>

                <ul class="comment-bottom">
                    <li>
                        <a href="reply.php?commentId=<?= $comment['comment_id'] . "&postId=" . $post['id'] . "&postTitle=" . $post['title'] ?>">Reply</a>
                    </li>

                    <?php if (isset($_SESSION['user'])) : ?>
                        <?php if ($comment['by_user_id'] === $_SESSION['user']['id']) : ?>
                            <li>
                                <button class="edit-comment-btn" data-id="<?= $comment['comment_id']; ?>">Edit</button>
                            </li>

                            <li>
                                <button class="delete-comment-btn delete-btn-on-post" type="submit" value="<?= $comment['comment_id']; ?>">Delete</button>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>

                </ul>
            </article>


            <section class="comments replies">

                <?php $replies = getReplysByCommentId($database, $comment['comment_id']); ?>
                <?php foreach ($replies as $reply) : ?>
                    <article class="comment reply" id="<?= $reply['id'] ?>">
                        <div class="comment-top text-secondary">
                            <p>@ <?= $comment['author']; ?></p>
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
                            <input type="hidden" id="comment-id" name="comment-id" value="<?= $comment['comment_id']; ?>"></input>
                            <input type="hidden" id="post-id" name="post-id" value="<?= $post['id']; ?>"></input>
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

        <?php endforeach; ?>

    </section>

</main>
<?php require __DIR__ . '/views/footer.php'; ?>