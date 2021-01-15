<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<main>

    <?php require __DIR__ . '/views/messages.php'; ?>

    <section class="change-password">
        <h1>Change Password</h1>

        <form action="app/users/changePassword.php" method="post">

            <div class="form-group">
                <label for="current-password">Current Password</label>
                <input class="form-control" type="password" name="current-password" id="current-password" placeholder="Current Password" required>
            </div>

            <div class="form-group">
                <label for="update-password">New Password</label>
                <input class="form-control" type="password" name="update-password" id="update-password" placeholder="New Password" required>
            </div>

            <button type="submit" name="submit" class="btn btn-secondary change-pass-btn">Change</button>

        </form>
    </section>

</main>

<?php require __DIR__ . '/views/footer.php'; ?>