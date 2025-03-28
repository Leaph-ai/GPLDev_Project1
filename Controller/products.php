<?php
/**
 * @var PDO $pdo
 */

require "Model/products.php";

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    if (isset($_GET["action"]) && $_GET["action"] == "index") {
        $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
        $products = getProducts($pdo, $page);
        echo json_encode($products);
        exit();
    }
}

$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
if ($page < 1) $page = 1;

$products = getProducts($pdo, $page);

$stmt = $pdo->query("SELECT COUNT(*) as total FROM products");
$totalCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$limit = 10;
$totalPages = ceil($totalCount / $limit);

$pageData = [
    'products' => $products,
    'currentPage' => $page,
    'totalPages' => $totalPages
];

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    deleteProduct($pdo, $id);
    header("Location: index.php?component=products");
    exit();
}

require "View/products.php";