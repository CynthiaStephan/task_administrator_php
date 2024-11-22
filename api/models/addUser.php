<?php

/**
 * Adds a new user to the database.
 *
 * This function inserts a new user record into the `users` table with the provided
 * username and hashed password.
 *
 * @param string $username The username for the new user.
 * @param string $password The hashed password for the new user.
 * @param PDO $pdo The PDO instance used to interact with the database.
 * 
 * @return void This function does not return any value.
 * 
 * @throws Exception If an error occurs while inserting the user, an exception is thrown.
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
        throw new Exception("Error adding user to the database.");
    }
}
