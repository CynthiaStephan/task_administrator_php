<?php
/**
 * The function `getTasks` retrieves tasks associated with a specific user ID from a database using PDO
 * in PHP.
 * 
 * @param int user_id 
 * @param PDO pdo
 * 
 * @return array An array of tasks associated with the specified user ID is being returned. Each task
 * is represented as an associative array containing task details.
 */

function getTasks(int $user_id, PDO $pdo): array{
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
