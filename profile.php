<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<?php $userId = $_GET['userId']; ?>
<?php $user = getUserProfile($database, $userId); ?>

<main>
    <?php if (isset($_SESSION['error'])) {
        echo $_SESSION['error'];
        unset($_SESSION['error']);
    } ?>
    <?php if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    } ?>


    <?php if (isset($_SESSION['user'])) : ?>
        <?php if ($user['id'] === $_SESSION['user']['id']) : ?>
            <section>
                <h1>Profile</h1>
                <p>User: <?= $_SESSION['user']['username']; ?> </p>

                <p>Created: <?= $_SESSION['user']['created_at']; ?> </p>

                <div class="pro-img-container">
                    <img src="/app/users/uploads/<?= $_SESSION['user']['img_src']; ?>" alt="profile image">
                </div>

                <form action="app/users/updateProfile.php" method="post" enctype="multipart/form-data">
                    <div class="">
                        <label class="pro-img" for="profile-img">Choose your profile image to upload:</label>
                        <input type="file" accept=".jpg, .jpeg, .png" name="profile-img" id="profile-img" required>
                    </div>
                    <button type="submit" name="sumbit" value="Submit">Update Profile Image</button>
                </form>

                <form action="app/users/updateProfile.php" method="post">
                    <div class="">
                        <label for="biography">Biography:</label>
                        <textarea id="biography" name="biography"><?= $_SESSION['user']['biography'] ?></textarea>
                    </div>
                    <button type="submit" name="sumbit" value="Submit">Update bio</button>
                </form>

                <form action="app/users/updateProfile.php" method="post">
                    <div class="">
                        <label for="update-email">Email:</label>
                        <input type="email" id="update-email" name="update-email" value="<?= $_SESSION['user']['email'] ?>"></input>
                    </div>
                    <button type="submit" name="sumbit" value="Submit">Update email</button>
                </form>

                <a href="changePassword.php">Change password</a>
                <a href="userPosts.php?userId=<?= $_SESSION['user']['id']; ?>">My posts</a>

            </section>
        <?php else :  ?>
            <a class="go-back" href="">Back</a>
            <section>
                <h1>Profile</h1>
                <p>User: <?= $user['username']; ?> </p>
                <p>Created: <?= $user['created_at']; ?> </p>
                <div class="pro-img-container">
                    <img src="/app/users/uploads/<?= $user['img_src']; ?>" alt="profile image">
                </div>
                <p>Biography: <?= $user['biography']; ?> </p>
                <a href="userPosts.php?userId=<?= $user['id']; ?>">posts</a>

            <?php endif; ?>
        <?php else :  ?>
            <?php redirect('/login.php'); ?>
        <?php endif; ?>

</main>
<?php require __DIR__ . '/views/footer.php'; ?>