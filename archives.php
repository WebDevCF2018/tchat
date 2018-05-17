<?php
require "verifSession.php";
require_once "mysqliConnect.php";
require_once "function.php";
$sql = "SELECT m.*,u.thelogin,u.thecolor FROM themessage m 
        INNER JOIN theuser u 
          ON u.idutil = m.theuser_idutil
ORDER BY m.idmessage DESC";
$recup = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
// pas de résultats
if(!mysqli_num_rows($recup)){
    echo "<h3>Pas encore de message!</h3>";
}else{
    $tous = mysqli_fetch_all($recup,MYSQLI_ASSOC);

}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Tchat</title>
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
        <script src="js/ajax.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" media="screen" href="css/style.css">
    </head>

    <body class="tchat" >
        <div id="particles-js"></div>
        <!-- scripts -->
        <script src="js/particles.min.js"></script>
        <script src="js/app.min.js"></script>
        <nav>
            <li>Bonjour, <b><?= $_SESSION["thelogin"]; ?></b></li>
            <a href="deco.php"><li><b>Déconnexion</b></li></a>
        </nav>
        <h1>Archives : Mini chat</h1>
		<div id="archives">	
		<?php
                foreach($tous AS $item){
            $item['thecontent'] = traiteChaine($item['thecontent']);
    		echo "<div class='archives-message' style='color:{$item["thecolor"]};'><strong>{$item['thelogin']}</strong> <span id='date'>{$item['thedatetime']}</span><p>{$item['thecontent']}<br><br></p></div>";
			}
			?>
    </div>
	<div id="back-to-tchat">
	<p><a href="index.php">Retour au tchat</a></p>
	</div>


    </body>
</html>
