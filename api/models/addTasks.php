<?php

/**
 * Adds a new task to the database.
 *
 * This function inserts a new task into the `tasks` table in the database.
 * It requires the user's ID, task title, and description as input. 
 * The task is marked as incomplete (`completed` = 0) and the current timestamp is added as `created_at`.
 *
 * @param int $user_id The ID of the user who is adding the task.
 * @param string $title The title of the task.
 * @param string $description The description of the task.
 * @param PDO $pdo The PDO object for database connection.
 *
 * @throws Exception If there is an error during the task insertion.
 */
function addTask(int $user_id, string $title, string $description, PDO $pdo): void {
    try {

        if (empty($title) || empty($description)) {
            throw new Exception("The title and description are required.");
        }

        $stmt = $pdo->prepare("
            INSERT INTO tasks (user_id, title, description, completed, created_at)
            VALUES (:user_id, :title, :description, 0, NOW())
        ");
        
        $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
        $stmt->bindParam(":description", $description, PDO::PARAM_STR);

        $stmt->execute();
    } catch (PDOException $err) {
        error_log('Database error: ' . $err->getMessage());
        throw new Exception("Error adding task: " . $err->getMessage());
    }
}
