<?php
session_start();

if(!isset($_SESSION["key"])){
	header("Location: index.php");
}

$nom = $_SESSION["thelogin"];

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
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
</head>

<body class="tchat" onload="chargeContent('06-recup.php','content')">
<h1>Déconnexion</h1>
<center><p>Aurevoir <?=$nom;?> et à bientôt !</p></center>
</body>
</html>