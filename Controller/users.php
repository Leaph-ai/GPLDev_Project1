<?php
require "Model/users.php";

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    header('Content-Type: application/json');
    if (isset($_GET["action"]) && $_GET["action"] == "index") {
        $page = isset($_GET["page"]) ? $_GET["page"] : 1;
        $users = getUsers($pdo, $page);
        echo json_encode($users);
        exit();
    }
}

require "View/users.php";