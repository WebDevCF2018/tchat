<?php
	if (isset($_SESSION["key"])) {
		header("location: tchat.php");
	}
    if (isset($_POST['thelogin']) && isset($_POST["thepwd"])) {
    	if (empty($_POST['thelogin']) && empty($_POST["thepwd"])) {
    		$erreur = "Veuillez remplir tous les champs !";
    	
    	}
    	else if(empty($_POST['thelogin'])){
    		$erreur = "<p style='background-color:#2e9aaf'>Please insert a username !</p>";
    	}
    	else if(empty($_POST['thepwd'])){
    		$erreur = "<p style='background-color:#2e9aaf'>Please insert a password !</p>";
    	}
    	else {

	        $login = htmlspecialchars(strip_tags(trim($_POST['thelogin'])), ENT_QUOTES);
	        $pwd = strip_tags(trim($_POST['thepwd']));

            $connect = connectUser($PDO, $login, $pwd);

            if($connect == false){
            	$erreur = "User or password incorrect !";
            }
            else if($connect["thevalidate"] == 0){
            	$erreur = "<p style='background-color:#dda93fb3'>Please validate your account in your mailbox !</p>";
            }
            else {
            	$_SESSION = $connect;
                $_SESSION['online']=[$_SESSION['idutil']];
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
    <title>Tchat: Connect</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" media="screen" href="css/style.css">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">


</head>
<body>

<!-- particles.js container -->
<div id="particles-js"></div>

<!-- scripts -->
<script src="js/particles.min.js"></script>
<script src="js/app.min.js"></script>



<?php if (isset($erreur)) {?>
<div class="erreur"><?=$erreur;?></div>
<?php }?>
<form id="accueil-form" action="" method="post">

    <h1>Login</h1>
    <label for="login">Login :</label>

    <input type="text" placeholder="your login" id="login" class="input-deco input-user" name="thelogin" value="<?=@$_POST["thelogin"];?>">
    <label for="thepwd">Password :</label>
    <input type="password" placeholder="your password" id="thepwd" class="input-deco input-pwd" name="thepwd" value="<?=@$_POST["thepwd"];?>">
    <input id="button" type="submit" value="Sign up">

    <div class="inscription">
        <a href="?p=inscription">Registration</a>
    </div>
</body>
</html>
