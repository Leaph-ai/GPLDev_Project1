<?php
function getUser(PDO $pdo, string $username)//
{
    $query = 'SELECT * FROM `users` WHERE username = :username';

    $res = $pdo->prepare($query);
    $res->bindParam(':username', $username);
    $res->execute();
    return $res->fetch();
}