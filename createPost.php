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
        <section class="create-post">
            <h1>Create new post</h1>
            <form action="/app/posts/store.php" method="post">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control save" type="title" name="title" id="title" placeholder="Enter title" required>
                </div>

                <div class="form-group">
                    <label for="url">URL</label>
                    <input class="form-control" type="url" name="url" id="url" placeholder="Enter URL" required>
                </div>

                <div class="form-group">
                    <label for="description">Description <small class="text-muted"><i> - Optional </i></small></label>
                    <textarea class=" form-control" type="text" name="description" id="description" placeholder="Enter description"></textarea>
                </div>

                <button type="submit" name="submit-post" class="btn btn-secondary submit-post-btn">submit</button>
            </form>
        </section>
    <?php else : ?>
        <p>You have to login to create a post.</p>
    <?php endif ?>

</main>
<?php require __DIR__ . '/views/footer.php'; ?>