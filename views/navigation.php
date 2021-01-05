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
            <a id="me" href="profile.php?userId=<?= $_SESSION['user']['id']; ?>"><?= $_SESSION['user']['username']; ?> Profile</a>
            <a class="logout-link" href="#">Logout</a>
        </section>


        <div class="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <button class="closebtn" type="close"></button>
                    <h4 class="modal-question"></h4>
                    <div class="modal-btn-container">
                        <button class="modal-btn modal-btn-no" type="submit">No</button>
                        <form class="modal-form" action="" method="post">
                            <input class="input" type="hidden" id="id" name="id" value=""></input>
                            <button class="modal-btn modal-btn-yes" type="submit" value="Submit">Yes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</header>