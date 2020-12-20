<?php

declare(strict_types=1);

require __DIR__ . '/../autoload.php';

// In this file we logout users.
$confirm = true;

if ($confirm) {
    unset($_SESSION['user']);
} else {
}

redirect('/');
