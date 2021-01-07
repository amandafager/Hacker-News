<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php if (isset($_GET['new'])) : ?>
    <?php $orderBy = 'created_at'; ?>
    <?php $posts = getPostsOrderBy($database, $orderBy); ?>
<?php else : ?>
    <?php $orderBy = 'votes'; ?>
    <?php $posts = getPostsOrderBy($database, $orderBy); ?>
<?php endif; ?>


<main>
    <article>
        <h1><?php echo $config['title']; ?></h1>
        <p>This is the home page.</p>
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success">
                <h3>
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
    </article>


    <?php $number = 1; ?>
    <?php foreach ($posts as $post) : ?>
        <?php if (isset($_SESSION['user'])) : ?>
            <?php if ($post['user_id'] === $_SESSION['user']['id']) : ?>

                <article class="post" id="<?= $post['id']; ?>">
                    <div class="top">
                        <div class="top-left">

                            <p><?= $number++; ?>.</p>

                            <form class="vote" action="app/posts/votes.php" method="post">
                                <input type="hidden" id="post-id" name="vote" value="<?= $post['id']; ?>"></input>
                                <button class="vote-btn" type="submit" value="Submit" data-id="<?= $post['id']; ?>">
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

                    <button class="like-btn">
                        <div class="triangle-up"></div>
                    </button>
                    <div class="post-content">
                        <a class="title" href="<?= $post['url']; ?>">
                            <h3><?= $post['title']; ?></h3>
                        </a>
                        <p><?= $post['description']; ?></p>
                    </div>
                    <ul class="bottom">
                        <li>
                            <p class="number-of-votes" data-id="<?= $post['id']; ?>"><?= numberOfVotes($database, $post['id']) ?> </p>
                        </li>
                        <li>
                            <a class="" href="comments.php?postId=<?= $post['id']; ?>"><?= numberOfComments($database, $post['id']); ?></a>
                        </li>
                        <li>
                            <a class="edit-post" href="editPost.php?postId=<?= $post['id']; ?>">edit</a>
                        </li>
                        <li>
                            <button class="delete-btn" type="submit" name="delete-post" value="<?= $post['id']; ?>">delete</button>
                        </li>
                    </ul>
                </article>

            <?php else : ?>

                <article class="post" id="<?= $post['id']; ?>">
                    <div class="top">
                        <div class="top-left">
                            <p><?= $number++; ?>.</p>
                            <form class="vote" action="app/posts/votescopy.php" method="post">
                                <input type="hidden" id="post-id" name="vote" value="<?= $post['id']; ?>"></input>
                                <button class="vote-btn" type="submit" value="Submit" data-id="<?= $post['id']; ?>">
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
                            <p class="number-of-votes" data-id="<?= $post['id']; ?>"><?= numberOfVotes($database, $post['id']) ?> </p>
                        </li>
                        <li>
                            <a class="" href="comments.php?postId=<?= $post['id']; ?>"><?= numberOfComments($database, $post['id']); ?></a>
                        </li>
                    </ul>
                </article>

            <?php endif; ?>
        <?php else : ?>
            <article class="post" id="<?= $post['id']; ?>">
                <div class="top">
                    <div class="top-left">
                        <p><?= $number++; ?>.</p>
                        <form action="login.php" method="post">
                            <input type="hidden" id="post-id" name="vote" value="<?= $post['id']; ?>"></input>
                            <button data-id="<?= $post['id']; ?>" class="vote-btn" type="submit" value="Submit">Upvote</button>
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
                        <p class="number-of-votes" data-id="<?= $post['id']; ?>"><?= numberOfVotes($database, $post['id']) ?> </p>
                    </li>
                    <li>
                        <a class="" href="comments.php?postId=<?= $post['id']; ?>"><?= numberOfComments($database, $post['id']); ?></a>
                    </li>
                </ul>
            </article>
        <?php endif; ?>
    <?php endforeach; ?>


</main>
<?php require __DIR__ . '/views/footer.php'; ?>