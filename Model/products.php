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