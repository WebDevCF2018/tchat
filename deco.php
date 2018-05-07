<?php
session_start();

if(!isset($_SESSION["key"])){
	header("Location: index.php");
}

$nom = $_SESSION["thelogin"];
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
</head>

<body class="tchat" onload="chargeContent('06-recup.php','content')">
<h1>Déconnexion</h1>
<center><p>Aurevoir <?=$nom;?> et à bientôt !</p></center>
</body>
</html>