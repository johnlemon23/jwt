<?php
require __DIR__ . '/vendor/autoload.php'; // Chemin vers le fichier autoload.php de Composer
use \Firebase\JWT\JWT;


session_start();
session_unset();

// Vérification des informations d'identification (utilisation de valeurs codées en dur)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = "admin";
    $password = "admin";

    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    if ($input_username === $username && $input_password === $password) {

        $_SESSION["username"] = $input_username;

        // Authentification réussie, génération du JWT
        $secret_key = "your_secret_key"; // Clé secrète pour signer le JWT
        $token = array(
            "username" => $input_username,
            "password" => $input_password,
        );
        $alg = "HS256";
        $jwt = JWT::encode($token, $secret_key, $alg);

        // Stockez le JWT dans la session ou envoyez-le au client, selon vos besoins
        $_SESSION["jwt"] = $jwt;

        // Authentification réussie, redirigez vers la page sécurisée
        header("Location: secure_page.php");
        exit();
    } else {
        // Informations d'identification incorrectes, afficher un message d'erreur
        $error_message = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 90%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Connexion</h2>
        <?php if (isset ($error_message)) { ?>
            <p style="color: red;">
                <?php echo $error_message; ?>
            </p>
        <?php } ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
            <input type="password" name="password" placeholder="Mot de passe" required><br>
            <input type="submit" value="Se Connecter">
        </form>
    </div>
</body>

</html>