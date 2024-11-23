<?php

/**
 * Retrieves a user's data based on their username.
 *
 * This function executes a query to fetch the user's details from the database 
 * using the provided username.
 *
 * @param string $username The username of the user to search for.
 * @param PDO $pdo The PDO instance used to interact with the database.
 *
 * @return mixed Returns an associative array with the user's data if found, 
 *               or `false` if no user is found or on error.
 */
function getUser($username, $pdo): mixed {
    $stmt = $pdo->prepare("
        SELECT * FROM users WHERE username = :username
        ");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}