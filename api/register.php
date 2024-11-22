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
        $username = $_POST['username'] ?? null;
        $password = $_POST['password'] ?? null;

        // Si les champs sont vides, renvoyer une erreur
        if (empty($username) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        // Vérifier si l'utilisateur existe déjà
        $user = getUser($username, $pdo);

        if ($user) {
            http_response_code(409); // Conflit
            $response['message'] = "Ce nom d'utilisateur est déjà pris.";
        } else {
            // Hashage du mot de passe
            $password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

            // Ajouter l'utilisateur
            addUser($username, $password, $pdo);
            $_SESSION['user'] = [
                'user_id' => $pdo->lastInsertId(),
            ];

            http_response_code(201); // Création réussie
            $response['message'] = 'Inscription réussie.';
            $response['data'] = ['user_id' => $_SESSION['user']['user_id']];
        }
    } catch (Exception $err) {
        error_log($err->getMessage());
        http_response_code(500); // Erreur serveur
        $response['message'] = "Une erreur est survenue lors de l'inscription.";
    }
}

// Envoyer la réponse JSON
echo json_encode($response);
exit;
