<?php
/**
 * Retrieves all tasks for a specific user from the database.
 *
 * This function fetches all tasks associated with a specific user ID
 * from the `tasks` table and returns them as an associative array.
 *
 * @param int $user_id The ID of the user whose tasks are to be fetched.
 * @param PDO $pdo The PDO instance used to interact with the database.
 *
 * @return mixed Returns an associative array of tasks if found, or an empty array if no tasks are found.
 */

function getTasks(int $user_id, PDO $pdo): mixed{
    $stmt = $pdo->prepare("
        SELECT task_id AS id, title, description, completed
        FROM tasks 
        WHERE user_id = :user_id
        ORDER BY created_at DESC
    ");
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
