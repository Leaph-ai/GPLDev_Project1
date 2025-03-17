<?php
require "Model/products.php";

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    header('Content-Type: application/json');
    if (isset($_GET["action"]) && $_GET["action"] == "index") {
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $products = getProducts($pdo, $page);
        echo json_encode($products);
        exit();
    }
}

require "View/products.php";