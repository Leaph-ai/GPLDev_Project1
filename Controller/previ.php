<?php
require "Model/previ.php";

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (isset($_GET['action']) && $_GET['action'] == 'products') {
        header('Content-Type: application/json');
        echo json_encode(getProducts($pdo));
        exit;
    }
}

require "View/previ.php";