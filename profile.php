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

    <?php if (isset($_SESSION['user'], $_SESSION['image'])) : ?>
        <section>
            <h1>Profile</h1>
            <p>User: <?php echo $_SESSION['user']['username']; ?> </p>
            <p>Created: <?php echo $_SESSION['user']['created_at']; ?></p>
            <div class="pro-img-container">


                <img src="app/users/uploads/<?php echo $_SESSION['user']['img_src'] ?>">


                <!--<img src="app/uploads/profile.jpeg">-->
            </div>
            <form action="app/users/updateProfile.php" method="post" enctype="multipart/form-data">
                <div class="">
                    <label class="pro-img" for="profile-img">Choose your profile image to upload:</label>
                    <input type="file" accept=".jpg, .jpeg, .png" name="profile-img" id="profile-img" required>
                    <!-- MAX_FILE_SIZE must precede the file input field -->
                    <!--<input type="hidden" name="MAX_FILE_SIZE" value="30000" />-->
                </div>
                <button type="submit" name="sumbit" value="Submit">Update image</button>
            </form>
            <form action="app/users/updateProfile.php" method="post" enctype="multipart/form-data">
                <div class="">
                    <label for="about-text">Biography:</label>
                    <textarea id="about-text"></textarea>
                </div>
                <button type="submit" name="sumbit" value="Submit">Update about</button>
            </form>

            <a href="#">Change password</a>

        </section>
    <?php endif; ?>

</main>
<?php require __DIR__ . '/views/footer.php'; ?>