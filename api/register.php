<?php

session_start();
require_once './config/config.php';
require_once './models/addUser.php';
require_once './models/getUser.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$response = [
    'message' => 'Requête invalide',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Récupérer les données de la requête via $_POST
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Vérifier que les champs sont remplis
        if (empty($username) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        // does user exist? 
        $user = getUser($username, $pdo);

        if ($user) {
            http_response_code(409); // Conflit
            $response['message'] = "Ce nom d'utilisateur est déjà pris.";
        } else {
            // hash password
            $passwordHashed = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

            // Ajouter le nouvel utilisateur
            addUser($username, $passwordHashed, $pdo);

            // Démarrer la session de l'utilisateur
            $_SESSION['user'] = [
                'user_id' => $pdo->lastInsertId(),
            ];

            http_response_code(201); // Créé
            $response['message'] = 'Inscription réussie.';
        }

    } catch (Exception $err) {
        // Enregistrer l'erreur dans les logs pour le débogage
        error_log($err->getMessage());
        // Retourner un message d'erreur générique
        http_response_code(500); // Erreur interne du serveur
        $response['message'] = "Une erreur est survenue lors de l'inscription.";
    }
}

// Retourner la réponse JSON
echo json_encode($response);
exit;
