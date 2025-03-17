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