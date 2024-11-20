<?php 
    try {
        $pdo = new PDO('mysql:host=mysql', 'devuser', 'devpass');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $error) {
        http_response_code(500);
        die("Erreur de connection : " . $error->getMessage());
    }