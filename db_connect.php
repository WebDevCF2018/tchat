<?php

$mysqli = @mysqli_connect('localhost','root','','tchat18cf2m',3306);

if(mysqli_connect_error($mysqli)){
    die("Numéro d'erreur: ".mysqli_connect_errno($mysqli)."<br>Affichage de l'erreur: ".utf8_encode(mysqli_connect_error($mysqli)));
}

mysqli_set_charset($mysqli,'utf8');