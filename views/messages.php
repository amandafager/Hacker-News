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



<?php if (isset($_SESSION['success'])) : ?>
    <div class="error success mt-2">
        <p class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </p>
    </div>
<?php endif; ?>