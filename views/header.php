<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <title><?php echo $config['title']; ?></title>

    <link rel="stylesheet" href="/assets/styles/nav.css">
    <link rel="stylesheet" href="assets/styles/global.css">
    <link rel="stylesheet" href="/assets/styles/profile.css">
    <link rel="stylesheet" href="/assets/styles/login.css">
    <link rel="stylesheet" href="/assets/styles/confirmBox.css">
    <link rel="stylesheet" href="assets/styles/post.css">
    <link rel="stylesheet" href="assets/styles/comments.css">
</head>

<body class="loading">

    <aside class="modal" aria-label="Modal question box">
        <div class="modal-dialog">
            <div class="modal-content">
                <button class="closebtn" aria-label="Close box">
                    <svg class="close-modal" width="100%" height="100%" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.353646 0.353544C0.548909 0.158282 0.865491 0.158282 1.06075 0.353544L9.54603 8.83883C9.7413 9.03409 9.7413 9.35067 9.54603 9.54593C9.35077 9.74119 9.03419 9.74119 8.83893 9.54593L0.353647 1.06065C0.158385 0.865389 0.158384 0.548807 0.353646 0.353544Z" fill="black" />
                        <path d="M0.3536 9.54593C0.158338 9.35066 0.158338 9.03408 0.3536 8.83882L8.83888 0.353539C9.03414 0.158277 9.35073 0.158277 9.54599 0.353539C9.74125 0.548801 9.74125 0.865383 9.54599 1.06065L1.06071 9.54593C0.865445 9.74119 0.548862 9.74119 0.3536 9.54593Z" fill="black" />
                    </svg>
                </button>
                <article class="content">
                    <h2 class="modal-question"></h2>
                    <div class="modal-btn-container">
                        <button class="modal-btn modal-btn-no btn btn-outline-secondary" type="button" aria-label="No">No</button>
                        <form class="modal-form" action="" method="post">
                            <input class="input" type="hidden" id="id" name="id" value=""></input>
                            <button class="modal-btn modal-btn-yes btn btn-outline-secondary" type="submit" value="Submit" aria-label="Yes">Yes</button>
                        </form>
                    </div>
                </article>
            </div>
        </div>
    </aside>

    <?php require __DIR__ . '/navigation.php'; ?>

    <div class="container py-5">