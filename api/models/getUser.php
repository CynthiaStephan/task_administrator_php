<?php

/**
 * Retrieves user information based on their username.
 *
 * This function executes an SQL query to search for a user in the `users` table
 * using the provided username.
 *
 * @param string $username The username to search for.
 * @param PDO $pdo The PDO instance used to interact with the database.
 * 
 * @return mixed Returns an associative array with the user's data if found.
 *               Returns an empty array if no user matches the given username.
 */
function getUser($username, $pdo): mixed {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}