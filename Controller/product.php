<?php
require "Model/product.php";

if (isset($_POST["submit-btn"])) {
    $product = $_POST["product-option"] ?? cleanString($_POST["product-option"]);
    $type = $_POST["type"] ?? cleanString($_POST["type"]);
    $unitPrice = $_POST["unit-price"] ?? cleanString($_POST["unit-price"]);
    $surfacePerUnit = $_POST["surface-per-unit"] ?? cleanString($_POST["surface-per-unit"]);
    $unitQuantity = $_POST["unit-quantity"] ?? cleanString($_POST["unit-quantity"]);
    $unit = $_POST["unit"] ?? cleanString($_POST["unit"]);

    createProduct($pdo, $product, $type, $unitPrice, $surfacePerUnit, $unitQuantity, $unit);
}

require "View/product.php";