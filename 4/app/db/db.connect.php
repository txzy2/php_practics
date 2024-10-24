<?php

$db_handle = pg_connect("host={$_ENV['DB_HOST']} dbname={$_ENV['DB_NAME']} user={$_ENV['DB_USER']} password={$_ENV['DB_PASSWORD']}");

if ($db_handle) {
    echo '<script>alert("Connection attempt succeeded.")</script>';
} else {
    echo 'Connection attempt failed.';
}
