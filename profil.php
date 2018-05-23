<?php
require "verifSession.php";
require_once "config.php";
require_once "mysqliConnect.php";
require_once "function.php";
require_once "profilConfig.php";

$info = infoUser($mysqli,$_SESSION["thelogin"]);

@updateUser($mysqli,$_SESSION["thelogin"],$_POST["password"],$_POST["repassword"]);

if (isset($_POST['titre']) && isset($_FILES['fichier'])) {

    if (!empty($_FILES['fichier']['name'])) {

        $ext = strrchr($_FILES['fichier']['name'], ".");
        // on met l'extension en minuscule
        $ext = strtolower($ext);
        // on vérifie si l'extension se trouve dans la liste des extensions autorisées
        if (in_array($ext, $extAut)) {

            $name = date("YmdHis") . "-" . mt_rand(1000, 9999);
            // création du nom final
            $finalName = $name . $ext;
            // destination finale
            $finalDestination = $oriDest . $finalName;
            // déplacement du fichier temporaire vers la destination finale
            move_uploaded_file($_FILES['fichier']['tmp_name'], $finalDestination);

            // création de l'image de 800 px sur 600 px max avec proportions
            $gd = large($finalName, $galleryDest, $finalDestination, LARGE_WIDTH, LARGE_HEIGHT, QUALITY_JPG_LARGE);
            if($gd) {
                thumbs($finalName, $thumbDest, $finalDestination, THUMB_SIZE, QUALITY_JPG_LARGE);
            }


            $reponse = "Votre fichier a été envoyé à cette adresse <a href='$finalDestination' target='_blank'>$finalDestination</a>";
        } else {
            $reponse = "Erreur - Extension \"$ext\" non valide";
        }
    } else {
        $reponse = "Erreur - Vous devez choisir un fichier";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tchat: Profil</title>
	<link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
    <script src="js/ajax.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" media="screen" href="css/style.css">
</head>
<body>
	<!-- Background JS -->
	<div id="particles-js"></div>
	<script src="js/particles.min.js"></script>
	<script src="js/app.min.js"></script>
	<!-- /Background JS -->
    <nav>
        <div class="display">
            <a href="tchat.php">
                <div class="user-tchat">
                    <img src="<?=$info["theimage"];?>">
                    <li>Return</b></li>
                </div>
            </a>
            <a href="deco.php"><li><b>Sign out</b></li></a>
        </div>
    </nav>
    <div class="profil display">
    	<h1>Profile Setting</h1>
    	<form enctype="multipart/form-data" method="post" action="">
    		<div class="profil-form">
	    		<label>
                    Username :
	    			<input type="text" name="name" value="<?=$info["thelogin"];?>" disabled>
	    		</label>
	    		<label>
	    			e-Mail:
	    			<input type="text" name="name" value="<?=$info["themail"];?>" disabled>
	    		</label>
	    		<label>
                    New Password :
	    			<input type="password" name="password">
	    		</label>
	    		<label>
                    Enter the password again :
	    			<input type="password" name="repassword">
	    		</label>
	    		<input type="submit" name="submit">
	    	</div>
	    	<div class="profil-form pf-center">
	    		<img src="<?=$info["theimage"];?>">
	    		<input type="file" name="uploaded_file">
	    	</div>
    	</form>

    </div>
</body>
</html>