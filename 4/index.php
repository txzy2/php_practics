<?php

/**
 *
 * Summary of index.php
 * @var App $app
 * @var ChildApp $child_app
 *
 * @var string $sum
 * @var string $sum_c
 *
 */

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include './app/App.php';
include './app/ChildApp.php';
include_once './app/db/db.connect.php';

$app = new App('1', 3);

$sum = $app->getMath();
echo "Sum: " . $sum['sum'] . "<br />" . "\n";
echo "Odds: " . $sum['odds'] . "<br />" . "\n";

$child_app = new ChildApp(100, 7);
$sum_c = $child_app->getMath();
echo "Sum in child class: " . $sum_c;
