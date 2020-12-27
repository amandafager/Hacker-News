<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<main>
    <?php if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    } ?>
    <?php if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    } ?>


    <?php if (isset($_SESSION['user'])) : ?>
        <section>
            <h2>Create new post</h2>
            <form action="/app/posts/store.php" method="post">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control save" type="title" name="title" id="title" placeholder="Title" value="" required>
                </div>

                <div class="form-group">
                    <label for="url">URL</label>
                    <input class="form-control" type="url" name="url" id="url" placeholder="URL" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" type="text" name="description" id="description" placeholder="Description" required></textarea>
                </div>

                <button type="submit" name="submit-post" class="btn btn-primary">submit</button>
            </form>
        </section>
    <?php else : ?>
        <p>You have to login to create a post.</p>
    <?php endif ?>

</main>
<?php require __DIR__ . '/views/footer.php'; ?>