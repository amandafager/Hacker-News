<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<?php require __DIR__ . '/views/messages.php'; ?>

<?php $id = $_GET['postId']; ?>
<?php $post = getPostByPostId($database, $id); ?>

<main>


    <?php SessionError(); ?>

    <?php if (isset($_SESSION['user'])) : ?>
        <section class="edit-post">
            <h1>Edit post</h1>

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

                <button class="btn btn-secondary edit-post-save-btn" type="submit" name="edit-post">Save</button>
            </form>

            <button class="delete-btn btn btn-danger edit-post-delete-btn" type="submit" name="delete-post" value="<?= $post['id']; ?>">delete</button>
        </section>

    <?php endif ?>

</main>

<?php require __DIR__ . '/views/footer.php'; ?>