<?php
	/* Connexion à la base de donnée */
	require_once "config.php";
	require_once "mysqliConnect.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chat WebDev2018</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<?php
		/* Chargement de controller principal */
		require "controller/mainController.php";
	?>
</body>
</html>