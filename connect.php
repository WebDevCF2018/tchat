<?php
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
            $connect = connectUser($mysqli, $_POST['$login'], $_POST['$pwd']);

            if ($connect) {
                $_SESSION = $connect;
                $_SESSION['key'] = session_id();
                header("Location ./");
            } else {
                $erreurCo = "incorrect";
            }

            var_dump($_SESSION);
        }

    }

?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <title>connect</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
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