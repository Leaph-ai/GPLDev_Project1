<?php
require 'Model/login.php';

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');

    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = cleanString($_POST['username']);
        $pass = cleanString($_POST['password']);
        $user = getUser($pdo, $username);

        if (empty($user)) {
            echo json_encode(['errors' => ["Nom d'utilisateur ou mot de passe incorrect"]]);
            exit();
        }

        if (is_array($user) && password_verify($pass, $user['password'])) {
            $_SESSION['auth'] = true;
            $_SESSION['username'] = $user['username'];
            echo json_encode(['authentication' => true]);
            exit();
        } else {
            echo json_encode(['errors' => ['L\'identification a échoué']]);
            exit();
        }
    } else {
        echo json_encode(['errors' => ['Veuillez remplir tous les champs']]);
        exit();
    }
} else {
    require 'View/login.php';
}