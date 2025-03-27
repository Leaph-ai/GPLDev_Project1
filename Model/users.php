<?php

function getUsers($pdo, $page) {
    $limit = 10;
    $offset = ($page - 1) * $limit;
    $res = $pdo->prepare("SELECT * FROM users LIMIT :limit OFFSET :offset");
    $res->bindParam(':limit', $limit, PDO::PARAM_INT);
    $res->bindParam(':offset', $offset, PDO::PARAM_INT);
    $res->execute();
    return $res->fetchAll();
}

function deleteUser(PDO $pdo, int $id): void {
    $query = "DELETE FROM `users` WHERE id = :id";
    $res = $pdo->prepare($query);
    $res->bindParam(':id', $id);
    $res->execute();
}

function getSessionUserId(PDO $pdo): int {
    $query = "SELECT id FROM `users` WHERE username = :username";
    $res = $pdo->prepare($query);
    $res->bindParam(':username', $_SESSION['username']);
    $res->execute();
    return $res->fetch()['id'];
}