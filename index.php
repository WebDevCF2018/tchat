<?php

/* ouverture de session */
session_start();

/* Connexion à la base de donnée */
require_once "config.php";

/*PDO connect*/
require_once "PDOConnect.php";

/* Chargement des fonctions */
require_once "function.php";

/* Chargement de controller principal */
require "controller/mainController.php";
