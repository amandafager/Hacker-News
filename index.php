<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
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
</main>
<?php require __DIR__ . '/views/footer.php'; ?>