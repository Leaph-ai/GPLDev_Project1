<?php
require 'Model/login.php';
if (!empty($_POST['username']) && !empty($_POST['pass'])) {
    $username = cleanString($_POST['username']);
    $pass = cleanString($_POST['pass']);
    $user = getUser($pdo, $username);
    if (empty($user)) {
        $errors = ["Nom d'utilisateur ou mot de passe incorrect"];
    }
    if (is_array($user) && $user['enabled'] !== 0 && password_verify($pass, $user['password'])) {
        $_SESSION['auth'] = true;
        $_SESSION['username'] = $user['username'];
        header('Content-Type: application/json');
        echo json_encode(['authentication' => true]);
        exit();
    } elseif ($user['enabled'] === 0 ) {
        $errors[] = 'Votre compte est désactivé';
    } else {
        $errors[] = 'L\'identification a échoué';
    }
    if (!empty($errors)) {
        header("Content-Type: application/json");
        echo json_encode(['errors' => $errors]);
        exit();
    }
}
require 'View/login.php';