<?php

function getProducts($pdo)
{
    $query = $pdo->prepare("SELECT * FROM products");
    $query->execute();
    return $query->fetchAll();
}