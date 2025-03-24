<?php
/**
 * @var PDO $pdo
 */

require "Model/product.php";

if (isset($_GET["action"]) && $_GET["action"] === "edit") {
    $productInfos = getProduct($pdo, $_GET["id"]);
}

if (isset($_POST["submit-btn"])) {
    $id = $_GET["id"] ;
    $product = $_POST["product-option"] ?? cleanString($_POST["product-option"]);
    $type = $_POST["type"] ?? cleanString($_POST["type"]);
    $unitPrice = $_POST["unit-price"] ?? cleanString($_POST["unit-price"]);
    $surfacePerUnit = $_POST["surface-per-unit"] ?? cleanString($_POST["surface-per-unit"]);
    $unitQuantity = $_POST["unit-quantity"] ?? cleanString($_POST["unit-quantity"]);
    $unit = $_POST["unit"] ?? cleanString($_POST["unit"]);

    if ($_GET["action"] === "create") {
        if (!productExists($pdo, $product, $type)) {
            createProduct($pdo, $product, $type, $unitPrice, $surfacePerUnit, $unitQuantity, $unit);
            header("Location: index.php?component=products");
        }
        else {
            $errors[] = "Produit déjà existant";
        }
    }
    else if ($_GET["action"] === "edit") {
        if (productExistsExceptCurrent($pdo, $product, $type, $id)) {
            $errors[] = "Nom de produit indisponible";
        }
        else {
            updateProduct($pdo, $id, $product, $type, $unitPrice, $surfacePerUnit, $unitQuantity, $unit);
            header("Location: index.php?component=products");
            exit();
        }
    }
}


require "View/product.php";