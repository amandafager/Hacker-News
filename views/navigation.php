<div class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <button class="closebtn" type="close"></button>
            <h4 class="modal-question"></h4>
            <div class="modal-btn-container">
                <button class="modal-btn modal-btn-no btn btn-outline-secondary" type="submit">No</button>
                <form class="modal-form" action="" method="post">
                    <input class="input" type="hidden" id="id" name="id" value=""></input>
                    <button class="modal-btn modal-btn-yes btn btn-outline-secondary" type="submit" value="Submit">Yes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<header>
    <a class="navbar-brand" href="/index.php"><?php echo $config['title']; ?></a>
    <button class="ham" type="menu"></button>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/index.php?top">Top</a>
            </li><!-- /nav-item -->

            <li class="nav-item">
                <a class="nav-link" href="/index.php?new">New</a>
            </li><!-- /nav-item -->

            <li class="nav-item">
                <a class="nav-link" href="/createPost.php">Submit</a>
            </li><!-- /nav-item -->
            <?php if (!isset($_SESSION['user'])) : ?>

                <li class="nav-item">
                    <a class="nav-link" href="/login.php">Login</a>
                </li><!-- /nav-item -->

            <?php else : ?>

                <li class="nav-item">
                    <a class="nav-link" id="me" href="profile.php?userId=<?= $_SESSION['user']['id']; ?>"> Profile</a>
                </li><!-- /nav-item -->

                <li class="nav-item">
                    <a class="logout-link nav-link" href="#">Logout</a>
                </li><!-- /nav-item -->

            <?php endif; ?>

        </ul><!-- /navbar-nav -->
    </nav><!-- /navbar -->
</header>