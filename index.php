<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>



<main>


    <?php if (isset($_GET['new'])) : ?>
        <?php $orderBy = 'created_at'; ?>
        <?php $posts = getPostsOrderBy($database, $orderBy); ?>
        <h1>New posts</h1>
    <?php endif; ?>

    <?php if (isset($_GET['top'])) : ?>
        <?php $orderBy = 'votes'; ?>
        <?php $posts = getPostsOrderBy($database, $orderBy); ?>
        <h1>Top posts</h1>
    <?php endif; ?>

    <?php if (isset($_GET['userId'], $_GET['name'])) : ?>
        <?php $userId = $_GET['userId']; ?>
        <?php $userName = $_GET['name']; ?>
        <?php $posts = getPostsByUserId($database, $userId); ?>
        <section>
            <a href="profile.php?userId=<?= $userId ?>">Back</a>
        </section>
        <h1>Posts by <?= $userName; ?> </h1>
    <?php endif; ?>


    <section>
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
    </section>


    <?php $number = 1; ?>
    <?php foreach ($posts as $post) : ?>

        <article class="post" id="<?= $post['id']; ?>">
            <div class="top">
                <div class="top-left">
                    <p><?= $number++; ?>.</p>
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
                <p><?= $post['created_at']; ?></p>
            </div>
            <div class="post-content">
                <a class="title" href="<?= $post['url']; ?>">
                    <h3><?= $post['title']; ?></h3>
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
                    <p class="number-of-votes" data-id="<?= $post['id']; ?>"><?= numberOfVotes($database, $post['id']) ?> </p>
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

    <?php endforeach; ?>


</main>
<?php require __DIR__ . '/views/footer.php'; ?>