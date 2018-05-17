<?php
require_once "config.php";
require_once "mysqliConnect.php";
require_once "function.php";

session_start();

if(!isset($_SESSION["key"])){
	header("Location: ./");
}

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
    <title>Tchat: Disconnected</title>
    <script type="javascript" src="js/ajax.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" media="screen" href="css/style.css">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
</head>

<body class="tchat">
<div id="particles-js"></div>

<!-- scripts -->
<script src="js/particles.min.js"></script>
<script src="js/app.min.js"></script>

<h1 style="color: ghostwhite">Déconnexion</h1>
<center><p style="color: ghostwhite">Good By<?=$nom;?> and see you soon !</p></center>
</body>
</html>