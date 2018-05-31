<?php
require_once "config.php";

/*
 * return PDO DEV instance => $PDO
 */
try {
    $PDO = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=" . DB_CHARSET, DB_LOGIN, DB_PWD);

    // Permet l'affichage des erreurs sql (développement), à commenter avant de mettre en production
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // si on veut une connexion permanente, on décommente ceci
    //$PDO->setAttribute(PDO::ATTR_PERSISTENT);

} catch (PDOException $e) {

    echo "Erreur: " . $e->getMessage();
    echo "<br>";
    echo "N° " . $e->getCode();// code erreur
    die();// arrêt du script
}