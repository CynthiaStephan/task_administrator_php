<?php

/**
 * Summary of getUser
 * @param mixed $username
 * @param mixed $pdo
 * @return array
 */
function getUser($username, $pdo): array {
    // Préparer la requête pour récupérer l'utilisateur avec son nom d'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Retourner l'utilisateur ou false si aucun utilisateur trouvé
    return $stmt->fetch(PDO::FETCH_ASSOC);
}