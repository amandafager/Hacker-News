<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we logout users.


unset($_SESSION['user']);

redirect('/');

/*if (!$_SESSION['success']) {
    $_SESSION['success'] = "You are now logged out";
}*/
