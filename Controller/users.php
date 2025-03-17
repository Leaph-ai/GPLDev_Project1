<?php
require "Model/users.php";

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    if (isset($_GET["action"]) && $_GET["action"] == "index") {
        $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
        $users = getUsers($pdo, $page);
        echo json_encode($users);
        exit();
    }
}

// Pour les requêtes normales (non-AJAX)
$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
if ($page < 1) $page = 1;

// Récupérer les utilisateurs pour la page actuelle
$users = getUsers($pdo, $page);

// Récupérer le nombre total d'utilisateurs pour calculer la pagination
$stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
$totalCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$limit = 10; // Même limite que dans getUsers()
$totalPages = ceil($totalCount / $limit);

// Passer les variables à la vue
$pageData = [
    'users' => $users,
    'currentPage' => $page,
    'totalPages' => $totalPages
];

require "View/users.php";