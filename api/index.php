<?php
// Exemple d'API qui renvoie un message
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Réponse de l'API sous forme de JSON
$response = [
    'status' => 'success',
    'message' => 'Bienvenue sur l\'API !',
    'data' => [
        'user' => 'Jean Dupont',
        'role' => 'admin',
        'last_login' => '2024-10-06'
    ]
];

echo json_encode($response);
exit;
