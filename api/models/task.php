<?php

function getTasks(string $task, PDO $pdo): array{
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id");
    $stmt->bindParam(":user_id", $task, PDO::PARAM_
}