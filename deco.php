<?php
require_once "config.php";
require_once "mysqliConnect.php";
require_once "function.php";

session_start();

if(!isset($_SESSION["key"])){
	header("Location: index.php");
}

$nom = $_SESSION["thelogin"];
disconnect($mysqli, $nom);
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
session_destroy();
echo '<meta http-equiv="refresh" content="3">';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tchat: Déconnexion</title>
    <script type="javascript" src="js/ajax.js"></script>
    <meta name="description" content="particles.js is a lightweight JavaScript library for creating particles.">
    <meta name="author" content="Vincent Garreau" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" media="screen" href="css/style.css">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
</head>

<body class="tchat" onload="chargeContent('06-recup.php','content')">
<div id="particles-js"></div>

<!-- scripts -->
<script src="particles.js"></script>
<script src="js/app.js"></script>

<h1>Déconnexion</h1>
<center><p>Aurevoir <?=$nom;?> et à bientôt !</p></center>
</body>
</html>