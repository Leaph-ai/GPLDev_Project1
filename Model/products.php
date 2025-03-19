<?php

function getProducts($pdo, $page) {
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $res = $pdo->prepare("SELECT * FROM products LIMIT :limit OFFSET :offset");
    $res->bindParam(':limit', $limit, PDO::PARAM_INT);
    $res->bindParam(':offset', $offset, PDO::PARAM_INT);
    $res->execute();
    return $res->fetchAll();
}

function deleteProduct(PDO $pdo, int $id): void {
    $query = "DELETE FROM `products` WHERE id = :id";
    $res = $pdo->prepare($query);
    $res->bindParam(':id', $id);
    $res->execute();
}
