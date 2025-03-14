<?php
require "Model/product.php";

if (isset($_POST['button'])) {
    $category = isset($_POST['product']) ? cleanString($_POST['product']) : null;
    $type = isset($_POST['type']) ? cleanString($_POST['type']) : null;
    $unit_price = isset($_POST['unit_price']) && is_numeric($_POST['unit_price']) ? cleanString($_POST['unit_price']) : null;
    $surface_per_unit = isset($_POST['surface_per_unit']) && is_numeric($_POST['surface_per_unit']) ? cleanString($_POST['surface_per_unit']) : null;
    $unit_quantity = isset($_POST['unit_quantity']) && is_numeric($_POST['unit_quantity']) ? cleanString($_POST['unit_quantity']) : null;
    $unit = isset($_POST['unit'])  ? cleanString($_POST['unit']) : null;
    createProduct($pdo, $category, $type, $unit_price, $surface_per_unit, $unit_quantity, $unit);
}

require "View/product.php";
