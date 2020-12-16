<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>

<main>
    <article>
        <h1>Login</h1>

        <form action="app/users/login.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="" required>
                <small class="form-text text-muted">Please provide your email address.</small>
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" id="password" required>
                <small class="form-text text-muted">Please provide the your password (passphrase).</small>
            </div><!-- /form-group -->

            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <a href="#">Forgot your password?</a>
    </article>

    <article>

        <h1>Create Account</h1>
        <form action="app/users/register.php" method="post">
            <div class="form-group">
                <label for="name">Username</label>
                <input class="form-control" type="name" name="name" id="name" placeholder="Username" required>
                <small class="form-text text-muted">Please provide your email address.</small>
            </div><!-- /form-group -->
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="Email" required>
                <small class="form-text text-muted">Please provide your email address.</small>
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password_1" id="password" value="" placeholder=" Password" required>
                <small class="form-text text-muted">Please provide a password (passphrase).</small>
            </div><!-- /form-group -->

            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password_2" id="password" placeholder="Confirm Password" required>
                <small class="form-text text-muted">Please provide a password (passphrase).</small>
            </div><!-- /form-group -->

            <button type="submit" class="btn btn-primary">create account</button>
        </form>
    </article>
</main>
<?php require __DIR__ . '/views/footer.php'; ?>