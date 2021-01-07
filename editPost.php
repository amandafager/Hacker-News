<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<?php $id = $_GET['postId']; ?>

<main>
    <?php if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    } ?>
    <?php if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    } ?>

    <a href="index.php?userId=<?= $_SESSION['user']['id']; ?>">Back</a>

    <?php if (isset($_SESSION['post'])) : ?>
        <?php $post = getPostByPostId($database, $id); ?>

        <section>
            <h2>Edit post</h2>

            <form action="/app/posts/update.php" method="post">
                <div class="form-group">
                    <label for="edit-title">Title</label>
                    <input class="form-control save" type="title" name="edit-title" id="edit-title" placeholder="Title" value="<?= $post['title']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="edit-url">URL</label>
                    <input class="form-control" type="url" name="edit-url" id="edit-url" placeholder="URL" required value="<?= $post['url']; ?>">
                </div>

                <div class="form-group">
                    <label for="edit-description">Description</label>
                    <textarea class="form-control" type="text" name="edit-description" id="edit-description" placeholder="Description" value=""><?= $post['description']; ?></textarea>
                </div>

                <button type="submit" name="edit-post" class="btn btn-primary">Save</button>
                <!--<button type="submit" name="delete-post" class="btn btn-primary">Delete</button>-->
            </form>
            <button class="delete-btn" type="submit" name="delete-post" value="<?= $post['id']; ?>">delete</button>
        </section>
    <?php endif ?>
</main>

<?php require __DIR__ . '/views/footer.php'; ?>