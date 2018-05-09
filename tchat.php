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


    <!--================fonction pour affichage date =================-->
    
    function jourDeLaSemaine(){
        var maDate = new Date();
        var lesJours = new Array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi");
        alert(lesJours[maDate.getDay()]);
    }

    function leJourDeLaSemaine(){
        var maDate = new Date();
        var lesJours = new Array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi","Samedi");
        return lesJours[maDate.getDay()];
    }

    function leMois(){
        var maDate = new Date();
        var lesMois = new Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        return lesMois[maDate.getMonth()];
    }

    function aujourdhui() {
        var maDate = new Date();
        var minutes, secondes;
        var insert = document.getElementById('heures');

        if (maDate.getMinutes() < 10) {
            minutes = "0" + maDate.getMinutes();
        } else {
            minutes = maDate.getMinutes();
        }

        if (maDate.getSeconds() < 10) {
            secondes = "0" + maDate.getSeconds();
        } else {
            secondes = maDate.getSeconds();
        }

        document.getElementById('go').innerHTML= leJourDeLaSemaine() + " " + maDate.getDate()+ " " + leMois() + " " +  maDate.getFullYear() + ", il est maintenant " + maDate.getHours() + "h" + minutes + ":" + secondes;
    }

    function tempsReel() {
        var maDate = new Date();
        var minutes, secondes;

        if (maDate.getMinutes() < 10) {
            minutes = "0" + maDate.getMinutes();
        } else {
            minutes = maDate.getMinutes();
        }

        if (maDate.getSeconds() < 10) {
            secondes = "0" + maDate.getSeconds();
        } else {
            secondes = maDate.getSeconds();
        }

        return 	maDate.getHours() + "h" + minutes + ":" + secondes;
    }

    function ecritHeure() {
        document.getElementById("afficheHeure").innerHTML = tempsReel();
    }

    function afficheHeure() {
        setInterval(ecritHeure, 1000);
    }

    afficheHeure();
</script>
</body>
</html>