<header>
    <a class="navbar-brand" href="/index.php"><?php echo $config['title']; ?></a>
    <button class="ham" type="menu">
        <svg class="open-menu" width="20" height="20" viewBox="0 0 13 9" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 0C0.367392 0 0.240215 0.0526785 0.146447 0.146447C0.0526784 0.240215 0 0.367392 0 0.5C0 0.632608 0.0526784 0.759785 0.146447 0.853553C0.240215 0.947321 0.367392 1 0.5 1H12.5C12.6326 1 12.7598 0.947321 12.8536 0.853553C12.9473 0.759785 13 0.632608 13 0.5C13 0.367392 12.9473 0.240215 12.8536 0.146447C12.7598 0.0526785 12.6326 0 12.5 0H0.5ZM0 4.5C0 4.36739 0.0526784 4.24021 0.146447 4.14645C0.240215 4.05268 0.367392 4 0.5 4H12.5C12.6326 4 12.7598 4.05268 12.8536 4.14645C12.9473 4.24021 13 4.36739 13 4.5C13 4.63261 12.9473 4.75979 12.8536 4.85355C12.7598 4.94732 12.6326 5 12.5 5H0.5C0.367392 5 0.240215 4.94732 0.146447 4.85355C0.0526784 4.75979 0 4.63261 0 4.5ZM0 8.5C0 8.36739 0.0526784 8.24021 0.146447 8.14645C0.240215 8.05268 0.367392 8 0.5 8H12.5C12.6326 8 12.7598 8.05268 12.8536 8.14645C12.9473 8.24021 13 8.36739 13 8.5C13 8.63261 12.9473 8.75979 12.8536 8.85355C12.7598 8.94732 12.6326 9 12.5 9H0.5C0.367392 9 0.240215 8.94732 0.146447 8.85355C0.0526784 8.75979 0 8.63261 0 8.5Z" fill="black" />
        </svg>
        <svg class="close-menu" width="20" height="20" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0.353646 0.353544C0.548909 0.158282 0.865491 0.158282 1.06075 0.353544L9.54603 8.83883C9.7413 9.03409 9.7413 9.35067 9.54603 9.54593C9.35077 9.74119 9.03419 9.74119 8.83893 9.54593L0.353647 1.06065C0.158385 0.865389 0.158384 0.548807 0.353646 0.353544Z" fill="black" />
            <path d="M0.3536 9.54593C0.158338 9.35066 0.158338 9.03408 0.3536 8.83882L8.83888 0.353539C9.03414 0.158277 9.35073 0.158277 9.54599 0.353539C9.74125 0.548801 9.74125 0.865383 9.54599 1.06065L1.06071 9.54593C0.865445 9.74119 0.548862 9.74119 0.3536 9.54593Z" fill="black" />
        </svg>

    </button>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/index.php?new">New</a>
            </li><!-- /nav-item -->

            <li class="nav-item">
                <a class="nav-link" href="/index.php?top">Top</a>
            </li><!-- /nav-item -->

            <li class="nav-item">
                <a class="nav-link" href="/createPost.php">Submit</a>
            </li><!-- /nav-item -->
            <?php if (!isset($_SESSION['user'])) : ?>

                <li class="nav-item">
                    <a class="nav-link" href="/login.php">Login / Create Account</a>
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