<header>
    <a class="navbar-brand" href="/index.php"><?php echo $config['title']; ?></a>
    <button class="ham" type="menu"></button>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/posts.php?top">Top</a>
            </li><!-- /nav-item -->

            <li class="nav-item">
                <a class="nav-link" href="/posts.php?new">New</a>
            </li><!-- /nav-item -->

            <li class="nav-item">
                <a class="nav-link" href="/createPost.php">Submit</a>
            </li><!-- /nav-item -->
        </ul><!-- /navbar-nav -->
    </nav><!-- /navbar -->

    <?php if (!isset($_SESSION['user'])) : ?>

        <section class="log-status">
            <a class="login-link" href="/login.php">Login</a>
        </section>

    <?php else : ?>
        <section class="log-status">
            <a id="me" href="profile.php"><?= $_SESSION['user']['username']; ?> Profile</a>
            <a class="logout-link" href="/app/users/logout.php">Logout</a>
        </section>
    <?php endif; ?>
</header>