<?php
/**
 * @var PDO $pdo
 */

require "Model/user.php";

if(getSessionUserId($pdo)['id'] == $_GET['id']) {
    header("Location: index.php?component=users");
    $errors[] = "Vous ne pouvez pas modifier votre propre compte";
    exit();
}

if (isset($_POST['username'])) {
    $id = $_GET['id'];
    $username = cleanString($_POST['username']);
    $password = password_hash(cleanString($_POST['password']), PASSWORD_DEFAULT);
    $admin = isset($_POST['adminCheckBox']) ? 1 : 0;
    $exists = getUser($pdo, $username);
    if (!$exists && is_string($username) && is_string($password) && $_GET['action'] === 'create') {
        createUser($pdo, $username, $password, $admin);
        header("Location: index.php?component=users");
        exit();
    } else if ($_GET['action'] === 'edit') {
        if (userExistsExceptCurrent($pdo, $username, $id)) {
            $errors[] = 'Nom d\'utilisateur indisponible';
        }
        else {
            if (password_verify($_POST['password'], verifyPassword($pdo, $id)['password'])) {
                updateUser($pdo, $id, $username, $admin);
                header("Location: index.php?component=users");
                exit();
            }
        }
    }
}

require "View/user.php";