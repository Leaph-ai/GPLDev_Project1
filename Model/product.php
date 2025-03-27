<?php

function createProduct(PDO $pdo, string $product, string $type, float $unitPrice, float $surfacePerUnit, float $unitQuantity, string $unit):void {
    $res = $pdo->prepare("INSERT INTO products (product, type, unit_price, surface_per_unit, unit_quantity, unit) VALUES (:product, :type, :unitPrice, :surfacePerUnit, :unitQuantity, :unit)");
    $res->bindParam(':product', $product);
    $res->bindParam(':type', $type);
    $res->bindParam(':unitPrice', $unitPrice);
    $res->bindParam(':surfacePerUnit', $surfacePerUnit);
    $res->bindParam(':unitQuantity', $unitQuantity);
    $res->bindParam(':unit', $unit);
    $res->execute();
}

function getProduct(PDO $pdo, int $id): array {
    $query = "SELECT * FROM `products` WHERE id = :id";
    $res = $pdo->prepare($query);
    $res->bindParam(':id', $id);
    $res->execute();
    return $res->fetch(PDO::FETCH_ASSOC);
}

function productExists(PDO $pdo, string $product, string $type): bool {
    $query = "SELECT COUNT(*) as count FROM `products` WHERE product = :product AND type = :type";
    $res = $pdo->prepare($query);
    $res->bindParam(':product', $product);
    $res->bindParam(':type', $type);
    $res->execute();
    return $res->fetch()['count'] > 0;
}

function productExistsExceptCurrent(PDO $pdo, string $product, string $type, int $id): bool {
    $query = "SELECT COUNT(*) as count FROM `products` WHERE product = :product AND type = :type AND id!= :id";
    $res = $pdo->prepare($query);
    $res->bindParam(':product', $product);
    $res->bindParam(':type', $type);
    $res->bindParam(':id', $id);
    $res->execute();
    return $res->fetch(PDO::FETCH_ASSOC)['count'] >0;
}

function updateProduct(PDO $pdo, int $id, string $product, string $type, float $unitPrice, float $surfacePerUnit, float $unitQuantity, string $unit): void {
    $query = "UPDATE `products` SET product = :product, type = :type, unit_price = :unitPrice, surface_per_unit = :surfacePerUnit, unit_quantity = :unitQuantity, unit = :unit WHERE id = :id";
    $res = $pdo->prepare($query);
    $res->bindParam(':id', $id);
    $res->bindParam(':product', $product);
    $res->bindParam(':type', $type);
    $res->bindParam(':unitPrice', $unitPrice);
    $res->bindParam(':surfacePerUnit', $surfacePerUnit);
    $res->bindParam(':unitQuantity', $unitQuantity);
    $res->bindParam(':unit', $unit);
    $res->execute();
}