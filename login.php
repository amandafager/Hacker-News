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


    <article class="log">
        <h2>Login</h2>

        <form action="app/users/login.php" method="post">
            <div class="form-group">
                <label for="current-email">Email</label>
                <input class="form-control" type="current-email" name="current-email" id="current-email" placeholder="Email" value="" required>
                <!--<small class="form-text text-muted">Please provide your email address.</small>-->
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="current-password">Password</label>
                <input class="form-control" type="password" name="current-password" id="current-password" placeholder="Password" required>
                <!--<small class="form-text text-muted">Please provide the your password (passphrase).</small>-->
            </div><!-- /form-group -->

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <a href="#">Forgot your password?</a>
    </article>

    <article class="log">

        <h2>Create Account</h2>

        <form action="app/users/register.php" method="post">
            <div class="form-group">
                <label for="new-username">Username</label>
                <input class="form-control" type="new-username" name="new-username" id="new-username" placeholder="Username" required>
                <!--<small class="form-text text-muted">Please provide your email address.</small>-->
            </div><!-- /form-group -->
            <div class="form-group">
                <label for="new-email">Email</label>
                <input class="form-control" type="new-email" name="new-email" id="new-email" placeholder="Email" required>
                <!--<small class="form-text text-muted">Please provide your email address.</small>-->
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="new-password-1">Password</label>
                <input class="form-control" type="password" name="new-password-1" id="new-password-1" value="" placeholder="Password" required>
                <!--<small class="form-text text-muted">Please provide a password (passphrase).</small>-->
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="new-password-2">Password</label>
                <input class="form-control" type="password" name="new-password-2" id="new-password-2" placeholder="Confirm Password" required>
                <!--<small class="form-text text-muted">Please provide a password (passphrase).</small>-->
            </div><!-- /form-group -->

            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
    </article>
</main>
<?php require __DIR__ . '/views/footer.php'; ?>