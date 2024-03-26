<?php
require __DIR__ . '/vendor/autoload.php'; // Chemin vers le fichier autoload.php de Composer
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

session_start();

// Vérifier si le JWT existe dans la session
if (isset ($_SESSION["jwt"])) {
    try {
        $secretKey = "your_secret_key"; // Clé secrète utilisée pour signer le JWT
        $alg = "HS256";
        $decoded = JWT::decode($_SESSION["jwt"], new Key($secretKey, $alg));
        // Le JWT est valide, vous pouvez accorder l'accès à la page sécurisée
        echo "Welcome, " . $decoded->username . "!"; // Utilisation des données du JWT
    } catch (Exception $e) {
        // Le JWT est invalide, redirigez vers la page de connexion
        echo $e->getMessage();
        header("Location: index.php");
        exit();
    }
} else {
    // Le JWT n'existe pas dans la session, redirigez vers la page de connexion
    header("Location: index.php");
    exit();
}
?>