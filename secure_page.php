<?php
    session_start();
    
    if( !isset($_SESSION["username"]) || $_SESSION["username"]==""){
        header("Location: index.php?error=1");
    }

    echo "<h1>Bienvenue, " . $_SESSION["username"] . "!</h1>";
    echo "<p>Vous êtes connecté à la page sécurisée.</p>";

?>