<?php

/**
 * The function addUser inserts a new user with username and hashed password into a database using PDO in PHP.
 * 
 * @param string $username 
 * @param string $password (already hashed before calling this function)
 * @param PDO $pdo 
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
