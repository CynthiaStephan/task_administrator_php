<?php

/**
 * Deletes a task from the database.
 *
 * This function removes a task from the `tasks` table using the provided task ID. 
 * It ensures that the task ID is valid and executes the deletion query. 
 * If no task is found with the given ID, an exception is thrown.
 *
 * @param int $task_id The ID of the task to be deleted.
 * @param PDO $pdo The PDO object representing the database connection.
 *
 * @throws Exception If the task ID is invalid or if no task is found with the given ID.
 * @throws PDOException If a database error occurs during the deletion process.
 */
function deleteTask(int $task_id, PDO $pdo): void {
    try {
        $stmt = $pdo->prepare("
        DELETE FROM tasks WHERE task_id = :task_id
        ");
        $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
        $stmt->execute(); 
    } catch (PDOException $err) {
        error_log('Database error: ' . $err->getMessage());
        throw new Exception("Erreur lors de la suppression de la tâche.");
    }   
}