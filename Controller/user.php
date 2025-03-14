<?php
require "Model/user.php";
if (isset($_POST['username'])) {
    $username = cleanString($_POST['username']);
    $password = password_hash(cleanString($_POST['password']), PASSWORD_DEFAULT);
    $admin = isset($_POST['adminCheckBox']) ? 1 : 0;
    $exists = getUser($pdo, $username);
    if (!$exists && is_string($username) && is_string($password)) {
        createUser($pdo, $username, $password, $admin);
    } else {
        $error = "Cet utilisateur existe déjà";
    }
}
require "View/user.php";