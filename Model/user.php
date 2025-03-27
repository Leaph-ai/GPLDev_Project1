<?php

function getUser(PDO $pdo, string $username):bool {
    $query = "SELECT * FROM `users` where username = :username";
    $res = $pdo->prepare($query);
    $res->bindParam(':username', $username);
    $res->execute();
    if ($res->fetch()) {
        return true;
    } else {
        return false;
    }
}

function createUser(PDO $pdo, string $username, string $password, int $admin):void {
    $query = "INSERT INTO `users` (username, password, admin) VALUES (:username, :password, :admin)";
    $res = $pdo->prepare($query);
    $res->bindParam(':username', $username);
    $res->bindParam(':password', $password);
    $res->bindParam(':admin', $admin);
    $res->execute();
}

function getUserInfos(PDO $pdo, int $id): array {
    $query = "SELECT username, admin FROM `users` WHERE id = :id";
    $res = $pdo->prepare($query);
    $res->bindParam(':id', $id);
    $res->execute();
    return $res->fetch(PDO::FETCH_ASSOC);
}

function updateUser(PDO $pdo, int $id, string $username,int $admin):void {

    $query = "UPDATE `users` SET username = :username, admin = :admin WHERE id = :id";
    $res = $pdo->prepare($query);
    $res->bindParam(':id', $id);
    $res->bindParam(':username', $username);
    $res->bindParam(':admin', $admin);
    $res->execute();
}

function verifyPassword(PDO $pdo, int $id) {
    $query = "SELECT password FROM `users` where id = :id";
    $res = $pdo->prepare($query);
    $res->bindParam(':id', $id);
    $res->execute();
    return $res->fetch(PDO::FETCH_ASSOC);
}

function userExistsExceptCurrent(PDO $pdo, string $username, int $currentUserId): bool {
    $query = "SELECT * FROM `users` WHERE username = :username AND id != :currentUserId";
    $res = $pdo->prepare($query);
    $res->bindParam(':username', $username);
    $res->bindParam(':currentUserId', $currentUserId);
    $res->execute();

    return $res->fetch() ? true : false;
}

function getSessionUserId($pdo) {
    $query = "SELECT id FROM `users` WHERE username = :username";
    $res = $pdo->prepare($query);
    $res->bindParam(':username', $_SESSION['username']);
    $res->execute();
    return $res->fetch(PDO::FETCH_ASSOC);
}