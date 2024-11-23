<?php

/**
 * Updates the completion status of a task in the database.
 *
 * This function updates the `completed` status of a task in the `tasks` table in the database based on the provided `task_id`.
 * It allows marking a task as completed (1) or incomplete (0).
 *
 * @param int $task_id The ID of the task to be updated.
 * @param int $completed The completion status to set for the task (1 for completed, 0 for incomplete).
 * @param PDO $pdo The PDO object representing the database connection.
 *
 * @throws Exception If there is an error during the task update process.
 */
function editTask(int $task_id, int $completed, PDO $pdo ) {
    try {
        $stmt = $pdo->prepare("
            UPDATE tasks 
            SET completed = :completed
            WHERE task_id = :task_id
        ");
        $stmt->bindParam(":task_id", $task_id, PDO::PARAM_INT);
        $stmt->bindParam(":completed", $completed, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        // Handle any errors, log them as needed
        error_log('Database error: ' . $e->getMessage());
        // Optionally, you can throw an exception or return an error message
        throw new Exception("Erreur lors de l'edition de la tâche");
    }

}