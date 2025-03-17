<?php
require "Model/products.php";

// Traitement des requêtes AJAX
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    if (isset($_GET["action"]) && $_GET["action"] == "index") {
        $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
        $products = getProducts($pdo, $page);
        echo json_encode($products);
        exit();
    }
}

// Pour les requêtes normales (non-AJAX)
// Récupérer le numéro de page depuis l'URL
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
if ($page < 1) $page = 1;

// Récupérer les produits pour la page actuelle
$products = getProducts($pdo, $page);

// Récupérer le nombre total de produits pour calculer la pagination
$stmt = $pdo->query("SELECT COUNT(*) as total FROM products");
$totalCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$limit = 10; // Même limite que dans getProducts()
$totalPages = ceil($totalCount / $limit);

// Passer les variables à la vue
$pageData = [
    'products' => $products,
    'currentPage' => $page,
    'totalPages' => $totalPages
];

require "View/products.php";