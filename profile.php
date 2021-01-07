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


    <?php if (isset($_SESSION['user'])) : ?>
        <section>
            <h1>Profile</h1>
            <p>User: <?= $_SESSION['user']['username']; ?> </p>

            <p>Created: <?= $_SESSION['user']['created_at']; ?> </p>

            <div class="pro-img-container">
                <img src="/app/users/uploads/<?= $_SESSION['user']['img_src']; ?>" alt="profile image">
            </div>

            <form class="form-img" action="app/users/updateProfile.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="profile-img" class="form-label"></label>
                    <input class="form-control form-control-sm" accept=".jpg, .jpeg, .png" name="profile-img" id="profile-img" type="file" required />
                </div>
                <button class="btn btn-outline-secondary btn-sm" type="submit" name="sumbit" value="Submit">Update Profile Image</button>
            </form>

            <form class="form-biography" action="app/users/updateProfile.php" method="post">
                <div class="form-group">
                    <label for="biography">Biography</label>
                    <textarea class="form-control" name="biography" id="biography"><?= $_SESSION['user']['biography'] ?></textarea>
                </div>
                <button class="biography-btn btn btn-outline-secondary btn-sm" type="submit" name="sumbit" value="Submit">Update bio</button>
            </form>

            <form class="form-email" action="app/users/updateProfile.php" method="post">
                <div class="form-group">
                    <label for="update-email">Email</label>
                    <input class="form-control" type="email" id="update-email" name="update-email" value="<?= $_SESSION['user']['email'] ?>"></input>
                </div>
                <button class="btn btn-outline-secondary btn-sm" type="submit" name="sumbit" value="Submit">Update email</button>

            </form>

            <a href="changePassword.php">Change password</a>
            <a href="userPosts.php?userId=<?= $_SESSION['user']['id']; ?>">My posts</a>
            <a href="/createPost.php">Submit</a>

        </section>

    <?php endif; ?>
</main>