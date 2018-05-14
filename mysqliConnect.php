<?php
require_once "config.php";
$mysqli = @mysqli_connect(DB_HOST,DB_LOGIN,DB_PWD,DB_NAME,DB_PORT);

if(mysqli_connect_error($mysqli)){
    die("Numéro d'erreur: ".mysqli_connect_errno($mysqli)."<br>Affichage de l'erreur: ".utf8_encode(mysqli_connect_error($mysqli)));
}

mysqli_set_charset($mysqli,DB_CHARSET);
