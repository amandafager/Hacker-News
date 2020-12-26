<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>
<main>
    <?php if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    } ?>

    <section class="">

        <h2>Change Password</h2>

        <form action="app/users/changePassword.php" method="post">
            <div class="form-group">
                <label for="current-password">Current Password</label>
                <input class="form-control" type="password" name="current-password" id="current-password" placeholder="Current Password" required>

            </div>

            <div class="form-group">
                <label for="update-password">New Password</label>
                <input class="form-control" type="password" name="update-password" id="update-password" placeholder="New Password" required>

            </div>

            <button type="submit" name="submit" class="btn btn-primary">Change</button>
        </form>
    </section>

</main>
<?php require __DIR__ . '/views/footer.php'; ?>