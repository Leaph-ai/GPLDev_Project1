<?php

function createProduct($pdo, $category, $type, $unit_price, $surface_per_unit, $unit_quantity, $unit):void
{
    $query = "INSERT INTO products (product, type, unit_price, surface_per_unit, unit_quantity, unit) VALUES (:product, :type, :unit_price, :surface_per_unit, :unit_quantity, :unit)";
    $res = $pdo->prepare($query);
    $res->bindParam(':product', $category);
    $res->bindParam(':type', $type);
    $res->bindParam(':unit_price', $unit_price);
    $res->bindParam(':surface_per_unit', $surface_per_unit);
    $res->bindParam(':unit_quantity', $unit_quantity);
    $res->bindParam(':unit', $unit);
    $res->execute();
}