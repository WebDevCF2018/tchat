<?php
    require "verifSession.php";

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tchat</title>
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
    <script src="js/ajax.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="tchat" onload="chargeContent('phpAjax/recup.php','headercontent')">
<nav>
	<li>Bonjour, <b><?=$_SESSION["thelogin"];?></b></li>
    <p id="heures"></p>
	<a href="deco.php"><li><b>Déconnexion</b></li></a>
</nav>
<h1>Mini chat</h1>
<div id="content">
    <div id="headercontent"></div>  
</div>
<div id="envoi">
        <input type="text" class="tchat-input-30" readonly size="20" id="myNAME" placeholder="<?=$_SESSION["thelogin"];?>" required>
        <input type="text" class="tchat-input-60" size="55" id="myTXT" placeholder="Votre message" required>
        <input type="button" class="tchat-submit" onclick="uploadContent('phpAjax/insert.php','<?=$_SESSION["idutil"];?>','myTXT')" id="mySUBMIT" value="Envoyer">
    </div>
<script>
    // on va vérifier toutes les 3 secondes si quelqu'un d'autre que nous a posté un contenu
    setInterval(function(){verifContenu('phpAjax/verif.php','phpAjax/recup.php','headercontent')},3000);
    // Get the input field
    var input = document.getElementById("myTXT");

    // Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", function(event) {
        // Cancel the default action, if needed
        event.preventDefault();
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
            // Trigger the button element with a click
            document.getElementById("mySUBMIT").click();
        }
    });


</script>
</body>
</html>
