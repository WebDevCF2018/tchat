<?php
    session_start();
	if (isset($_SESSION["key"])) {
		echo "Il y a une session ! ";
        var_dump($_SESSION);
	}
    else{
        header("location: index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tchat</title>
    <script type="javascript" src="js/ajax.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body onload="chargeContent('06-recup.php','content')">
<h1>Mini chat</h1>
<div id="content"></div>
<div id="envoi">
    <input type="text" size="20" id="myNAME" placeholder="Votre surnom" required>
    <input type="text" size="55" id="myTXT" placeholder="Votre message" required>
    <input type="button" onclick="uploadContent('06-insert.php','myNAME','myTXT');" id="mySUBMIT" value="Envoyer">
</div>
<script>
    // on va vérifier toutes les 3 secondes si quelqu'un d'autre que nous a posté un contenu
    setInterval(function(){verifContenu()},3000);
</script>
</body>
</html>