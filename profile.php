<?php require __DIR__ . '/app/autoload.php'; ?>
<?php require __DIR__ . '/views/header.php'; ?>


<?php $userId = $_GET['userId']; ?>
<?php $user = getUserProfile($database, $userId); ?>


<main>

    <?php if (isset($_SESSION['success'])) : ?>
        <div class="error success">
            <p class="alert alert-success">
                <strong>Success!</strong>
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </p>
        </div>
    <?php endif; ?>


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

    <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] === $userId) : ?>

        <section class="user-profile">
            <h1><?= $_SESSION['user']['username']; ?></h1>
            <div class="pro-img-container">
                <img src="/app/users/uploads/<?= $_SESSION['user']['img_src']; ?>" alt="profile image">
            </div>
            <p>Created: <?= formatDate($_SESSION['user']['created_at']); ?> </p>

            <section class="update">
                <form class="form-img" action="app/users/updateProfile.php" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="profile-img" class="form-label"></label>
                        <input class="form-control form-control-sm" accept=".jpg, .jpeg, .png" name="profile-img" id="profile-img" type="file" required />
                    </div>
                    <button class="btn btn-outline-secondary btn-sm" type="submit" name="sumbit" value="Submit">Update image</button>
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
                    <p> <strong> Created: </strong><?= formatDate($user['created_at']); ?> </p>
                </li>
                <li class="list-group-item">
                    <p> <strong>Biography: </strong><?= $user['biography']; ?></p>
                </li>
                <li class="list-group-item"><a href="index.php?userId=<?= $user['id']; ?>&name=<?= $user['username']; ?>">Posts</a>
                </li>
            </ul>
        </section>
    <?php endif; ?>
</main>




<?php require __DIR__ . '/views/footer.php'; ?>