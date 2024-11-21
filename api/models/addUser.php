<?php

/**
 * The function `addUser` inserts a new user with username and password into a database using PDO in PHP.
 * 
 * @param string username 
 * @param string password
 * @param PDO pdo 
 */
function addUser(string $username, string $password, PDO $pdo): void {
    $stmt = $pdo->prepare("
    INSERT INTO users (username, password) 
    VALUES (:username, :password)
    ");
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->bindParam(":password", $password, PDO::PARAM_STR);
    $stmt->execute();
}