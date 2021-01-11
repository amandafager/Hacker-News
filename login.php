<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<main>

    <?php if (isset($_SESSION['error'])) : ?>
        <div class="error success">
            <p class="alert alert-danger alert-dismissible">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </p>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['message'])) : ?>
        <div class="error success">
            <p class="alert alert-info">
                <?php
                echo $_SESSION['message'];
                unset($_SESSION['message']);
                ?>
            </p>
        </div>
    <?php endif; ?>

    <div class="log-wrapper">
        <article class="log" aria-label="Login form">
            <h1>Login</h1>

            <form action="app/users/login.php" method="post">
                <div class="form-group">
                    <label for="current-email">Email</label>
                    <input class="form-control save" type="current-email" name="current-email" id="current-email" placeholder="you@example.com" required>
                </div>

                <div class="form-group">
                    <label for="current-password">Password</label>
                    <input class="form-control" type="password" name="current-password" id="current-password" placeholder="Password" required>
                </div>

                <button type="submit" name="submit" class="btn btn-secondary log-btn">Login</button>
            </form>

            <a href="#">Forgot your Password?</a>
        </article>



        <article class="log" aria-label="Create Account form">

            <h2>Create Account</h2>

            <form action="app/users/register.php" method="post">
                <div class="form-group">
                    <label for="new-username ">Username</label>
                    <input class="form-control save" type="new-username" name="new-username" id="new-username" placeholder="Username" value="" required>
                </div>

                <div class="form-group">
                    <label for="new-email">Email</label>
                    <input class="form-control save" type="new-email" name="new-email" id="new-email" placeholder="you@example.com" required>
                </div>

                <div class="form-group">
                    <label for="new-password-1">Password</label>
                    <input class="form-control" type="password" name="new-password-1" id="new-password-1" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <label for="new-password-2">Confirm password</label>
                    <input class="form-control" type="password" name="new-password-2" id="new-password-2" placeholder="Confirm password" required>
                </div>

                <button type="submit" name="submit" class="btn btn-secondary log-btn">Create Account</button>
            </form>
        </article>
    </div>

</main>
<?php require __DIR__ . '/views/footer.php'; ?>