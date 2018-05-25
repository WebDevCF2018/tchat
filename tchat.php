<?php
require "verifSession.php";
//var_dump($_SESSION);
require_once "config.php";
require_once "mysqliConnect.php";
require_once "function.php";
$info = infoUser($mysqli,$_SESSION["thelogin"]);
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Tchat</title>
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
        <script src="js/lib/jquery-3.3.1.js"></script>
        <script src="js/lib/jquery.js"></script>
        <script src="js/ajax.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" media="screen" href="css/style.css">
    </head>

    <body class="tchat" onload="chargeContent('phpAjax/recup.php', 'headercontent');chargeContent('phpAjax/online.php','row-connected');">
        <div id="particles-js"></div>

        <!-- scripts -->
        <script src="js/particles.min.js"></script>
        <script src="js/app.min.js"></script>
        <nav>
            <div class="display">
                <a href="profil.php">
                    <div class="user-tchat">
                        <img src="img/profil/thumbs/<?=$info["theimage"];?>">
                        <li>Bonjour, <b><?= $_SESSION["thelogin"]; ?></b></li>
                    </div>
                </a>
                <li id="button-archives" onclick="location.href= 'archives.php'"><a href="archives.php">Archives</a></li>
                <a href="deco.php"><li><b>Sign out</b></li></a>
            </div>

        </nav>
        <h1>Mini chat</h1>
        <div id="user-connected"><p><i>•</i> <b id="row-connected"></b> connected</p></div>
        <div id="content">
            <div id="headercontent"></div>
            <div id="emoji-bar">
                <img onclick="emojiBar('smile')" class="emoji" src="img/icones/smile.png">
                <img onclick="emojiBar('happy')" class="emoji" src="img/icones/happy.png">
                <img onclick="emojiBar('angry')" class="emoji" src="img/icones/angry.gif">
                <img onclick="emojiBar('sad')" class="emoji" src="img/icones/sad.gif">
                <img onclick="emojiBar('laugh')" class="emoji" src="img/icones/laugh.gif">
                <img onclick="emojiBar('wow')" class="emoji" src="img/icones/wow.gif">
                <img onclick="emojiBar('surprised')" class="emoji" src="img/icones/surprised.png">
                <img onclick="emojiBar('confused')" class="emoji" src="img/icones/confused.png">
                <img onclick="emojiBar('like')" class="emoji" src="img/icones/like.gif">
                <img onclick="emojiBar('heart')" class="emoji" src="img/icones/heart.gif">
                <img onclick="emojiBar('troll')" class="emoji" src="img/icones/troll.png">
                <img onclick="emojiBar('star')" class="emoji" src="img/icones/star.png">
                <img onclick="emojiBar('knuckle')" class="emoji" src="img/icones/knuckle.png">
                <img onclick="emojiBar('nyan')" class="emoji" src="img/icones/nyan.gif">
            </div>
        </div>



        <div id="envoi">
            <input type="text" class="tchat-input-30" readonly size="20" id="myNAME" placeholder="<?= $_SESSION["thelogin"]; ?>" required>
            <input type="text" class="tchat-input-60" size="55" id="myTXT" placeholder="Your
             message" required>
            <button><img src="img/icones/emobar.png" alt=""></button>
            <input type="button" class="tchat-submit" onclick="uploadContent('phpAjax/insert.php', '<?= $_SESSION["idutil"]; ?>', 'myTXT')" id="mySUBMIT" value="Send">
        </div>
        <script>
            // Affichage des personnes connectés
            setInterval(function(){ chargeContent('phpAjax/online.php','row-connected');},10000);
            // on va vérifier toutes les 3 secondes si quelqu'un d'autre que nous a posté un contenu
            setInterval(function () {
                verifContenu('phpAjax/verif.php', 'phpAjax/recup.php', 'headercontent')
            }, 3000);
            // Get the input field
            var input = document.getElementById("myTXT");

            // Execute a function when the user releases a key on the keyboard
            input.addEventListener("keyup", function (event) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Number 13 is the "Enter" key on the keyboard
                if (event.keyCode === 13) {
                    // Trigger the button element with a click
                    document.getElementById("mySUBMIT").click();
                }
            });
            function emojiBar(emoji) {
                document.getElementById('myTXT').value += ":" + emoji + ":";
            }
        </script>
    </body>
</html>