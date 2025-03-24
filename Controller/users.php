<?php

/**
 * @var PDO $pdo
 */

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

$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
if ($page < 1) $page = 1;

$users = getUsers($pdo, $page);

$stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
$totalCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$limit = 10; // Même limite que dans getUsers()
$totalPages = ceil($totalCount / $limit);

$pageData = [
    'users' => $users,
    'currentPage' => $page,
    'totalPages' => $totalPages
];

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    if ($id === getSessionUserId($pdo) ){
        $errors[] = "Vous ne pouvez pas supprimer cet utilisateur";
    } else {
        deleteUser($pdo, $id);
        header("Location: index.php?component=users");
        exit();
    }

}

require "View/users.php";