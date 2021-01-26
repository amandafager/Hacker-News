<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<?php $userId = $_GET['userId']; ?>
<?php $user = getUserProfile($database, $userId); ?>

<main>

    <?php require __DIR__ . '/views/messages.php'; ?>

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] === $userId) : ?>
        <section class="user-profile">

            <h1 class="mb-4"><?= $_SESSION['user']['username']; ?></h1>

            <div class="pro-img-container">
                <img src="/app/users/uploads/<?= $_SESSION['user']['img_src']; ?>" alt="profile image">
            </div>

            <time>Created: <?= formatDate($_SESSION['user']['created_at']); ?> </time>

            <section class="update mt-4 mb-2">
                <form class="form-img mb-4" action="app/users/updateProfile.php" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="profile-img">Upload profile image</label>
                        <input class="form-control form-control-sm" accept=".jpg, .jpeg, .png" name="profile-img" id="profile-img" type="file" required />
                    </div>

                    <button class="btn btn-secondary btn-sm mt-1" type="submit" name="sumbit" value="Submit">Update image</button>
                </form>

                <form class="form-biography" action="app/users/updateProfile.php" method="post">
                    <div class="form-group">
                        <label for="biography">Biography</label>
                        <textarea class="form-control" name="biography" id="biography"><?= $_SESSION['user']['biography'] ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="update-email">Email</label>
                        <input class="form-control" type="email" id="update-email" name="update-email" value="<?= $_SESSION['user']['email'] ?>"></input>
                    </div>

                    <button class="btn btn-secondary update-profile-btn" type="submit" name="update-profile" value="Submit">Update profile</button>
                </form>
            </section>

            <ul class="profile-list">
                <li>
                    <a href="changePassword.php">Change password</a>
                </li>
                <li>
                    <a href="index.php?userId=<?= $_SESSION['user']['id']; ?>&name=<?= $_SESSION['user']['username']; ?>">My posts</a>
                </li>
                <li>
                    <a href="/createPost.php">Submit</a>
                </li>
                <li>
                    <button class="delete-btn delete-account-btn" type="submit" name="delete-acc" value="<?= $_SESSION['user']['id']; ?>">Delete account</button>
                </li>
            </ul>
        </section>
    <?php else :  ?>
        <section class="user-profile  user-profile-offline p-4 bg-white">

            <h1><?= $user['username']; ?></h1>

            <div class="pro-img-container">
                <img src="/app/users/uploads/<?= $user['img_src']; ?>" alt="profile image">
            </div>

            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <time> <strong> Created: </strong><?= formatDate($user['created_at']); ?> </time>
                </li>

                <li class="list-group-item">
                    <p> <strong>Biography: </strong><?= $user['biography']; ?></p>
                </li>

                <li class="list-group-item">
                    <a href="index.php?posts&userId=<?= $user['id']; ?>&name=<?= $user['username']; ?>">Posts</a>
                    <a href="index.php?comments&userId=<?= $user['id']; ?>&name=<?= $user['username'] ?>">Commented posts</a>
                </li>
            </ul>

        </section>

    <?php endif; ?>

</main>

<?php require __DIR__ . '/views/footer.php'; ?>
