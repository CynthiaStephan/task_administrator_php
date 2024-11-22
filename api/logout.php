<?php
    session_start();

    $response = [
        'message' => "Requête invalide",
    ];
    
/* This PHP code snippet is responsible for destroying an active session and clearing any associated
session cookies. */
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
        $response['message'] = "Déconnexion réussie";
    
        // Check if the session use cookies
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, 
                $params["path"], $params["domain"], 
                $params["secure"], $params["httponly"]
            );
        }
    }

    echo json_encode($response);
    exit;

