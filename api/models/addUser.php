<?php

/**
 * Adds a new user to the database.
 *
 * This function inserts a new user into the `users` table with the provided
 * username and hashed password.
 *
 * @param string $username The username of the user to be added.
 * @param string $password The hashed password of the user.
 * @param PDO $pdo The PDO instance used to interact with the database.
 *
 * @return void This function does not return any value.
 *
 * @throws Exception Throws an exception if there is an error during the database operation.
 */
function addUser(string $username, string $password, PDO $pdo): void {
    try {
        // Prepare the SQL query to insert the user data
        $stmt = $pdo->prepare("
            INSERT INTO users (username, password) 
            VALUES (:username, :password)
        ");
        
        // Bind the parameters to the statement
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        
        // Execute the query
        $stmt->execute();
        
    } catch (PDOException $e) {
        // Handle any errors, log them as needed
        error_log('Database error: ' . $e->getMessage());
        // Optionally, you can throw an exception or return an error message
        throw new Exception("Erreur lors de l'ajout de l'utilisateur");
    }
}
