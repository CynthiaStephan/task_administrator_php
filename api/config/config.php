<?php 

    try {
        $pdo = new PDO('mysql:host=mysql;dbname=local', 'devuser', 'devpass');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $error) {
        // Renvoie une erreur 500 et log l'erreur sans tuer le script
        http_response_code(500);
        error_log("Erreur de connexion à la base de données : " . $error->getMessage());
        echo "Une erreur est survenue lors de la connexion à la base de données. Veuillez réessayer plus tard.";
        exit; // Terminer l'exécution mais sans interrompre le serveur
    }
