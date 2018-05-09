<?php
	if (isset($_SESSION["key"])) {
		header("location: tchat.php");
	}
    if (isset($_POST['thelogin']) && isset($_POST["thepwd"])) {
    	if (empty($_POST['thelogin']) && empty($_POST["thepwd"])) {
    		$erreur = "Veuillez remplir tous les champs !";
    	
    	}
    	else if(empty($_POST['thelogin'])){
    		$erreur = "Veuillez insérer un nom d'utilisateur !";
    	}
    	else if(empty($_POST['thepwd'])){
    		$erreur = "Veuillez insérer un mot de passe !";
    	}
    	else {

	        $login = htmlspecialchars(strip_tags(trim($_POST['thelogin'])), ENT_QUOTES);
	        $pwd = strip_tags(trim($_POST['thepwd']));

            $connect = connectUser($mysqli, $login, $pwd);

            if($connect == false){
            	$erreur = "utilisateur ou mot de passe incorrect !";
            }
            else if($connect["thevalidate"] == 0){
            	$erreur = "Veuillez validé votre compte dans votre boîte mail !";
            }
            else {
            	$_SESSION = $connect;
            	$_SESSION["key"] = session_id();
            	header("location: tchat.php");
            	//var_dump($_SESSION);

            }
        }

    }
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>connect</title>

    <meta name="description" content="particles.js is a lightweight JavaScript library for creating particles.">
    <meta name="author" content="Vincent Garreau" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" media="screen" href="css/style.css">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">


</head>
<body>

<!-- particles.js container -->
<div id="particles-js"></div>

<!-- scripts -->
<script src="particles.js"></script>
<script src="js/app.js"></script>



<?php if (isset($erreur)) {?>
<div class="erreur"><?=$erreur;?></div>
<?php }?>
<form action="" method="post">

    <h1>Connexion</h1>
    <label for="login">Login :</label>

    <input type="text" id="login" class="input-deco input-user" name="thelogin" value="<?=@$_POST["thelogin"];?>">
    <label for="thepwd">Password :</label>
    <input type="password" id="thepwd" class="input-deco input-pwd" name="thepwd" value="<?=@$_POST["thepwd"];?>">
    <input id="button" type="submit">


    <div class="inscription">
        <a href="?p=inscription">Inscription</a>
    </div>
</body>
</html>
