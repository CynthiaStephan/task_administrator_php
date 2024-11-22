<?php

/**
 * The function `getUser` retrieves a user's data from a database using their username as a parameter.
 * 
 * @param string username
 * @param PDO pdo 
 * @return array 
 */
function getUser(string $username, PDO $pdo) :array {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}