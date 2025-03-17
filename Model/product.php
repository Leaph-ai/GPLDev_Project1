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