<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
require "Includes/database.php";
require "Includes/functions.php";
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (isset($_GET['component'])) {
        $componentName = cleanString($_GET['component']);
        if (file_exists("Controller/$componentName.php")) {
            require "Controller/$componentName.php";
        }
    }
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ar-Façades</title>
    <link rel="stylesheet" href="assets/CSS/style.css">
</head>
<body>
<div class="container">
    <?php
    if (isset($_SESSION['auth'])) {
        require "_partials/navbar.php";
        if (isset($_GET['component'])) {
            $componentName = cleanString($_GET['component']);
            if (file_exists("Controller/$componentName.php")) {
                require "Controller/$componentName.php";
            }
        }
    } else {
        require 'Controller/login.php';
    }
    ?>
</div>
</body>