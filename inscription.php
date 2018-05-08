<!DOCTYPE html>
<html lang="fr">
<head>
    <?php

        if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
            //get verified response data

            //your site secret key
            $secret = '6LfI91cUAAAAAGwrXFjV2opL6PmI8KVse-2LQyZ6';

            $gRecaptcha = $_POST['g-recaptcha-response'];
            $gRecaptcha = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$_POST['g-recaptcha-response'];

            $response = file_get_contents($gRecaptcha);
            $responseData = json_decode($response);

            if($responseData->success){
               echo "<script>alert('sucesss !')</script>";
              if(isset($_GET['error'])){
            if($_GET['error'] == 1){
             $erreur = "Nom d'utilisateur déjà utilisé !";
            }
        }
        if (isset($_POST['thelogin']) && isset($_POST["thepwd"]) && isset($_POST["themail"])) {
            if (empty($_POST['thelogin']) && empty($_POST["thepwd"]) && empty($_POST["themail"])) {
                $erreur = "Veuillez remplir tous les champs !";
        
            }
            else if(empty($_POST['thelogin'])){
                $erreur = "Veuillez insérer un nom d'utilisateur !";
            }
            else if(empty($_POST['thepwd'])){
                $erreur = "Veuillez insérer un mot de passe !";
            }
            else if(empty($_POST['themail'])){
                $erreur = "Veuillez insérer une adresse mail !";
            } 
        
        else {
            $login = htmlspecialchars(strip_tags(trim($_POST['thelogin'])), ENT_QUOTES);
            $pwd = strip_tags(trim($_POST['thepwd']));
            $email = filter_var($_POST['themail'], FILTER_VALIDATE_EMAIL);
            $envReq = newuser($mysqli, $login, $pwd, $email);
                if($envReq){
                    $erreur = "Vous êtes bien inscrit. Vous allez recevoir un mail de confirmation avant de pouvoir vous connecter";
                    }else {
                        $erreur = "Echec de l'inscription, veuillez recommencer";
                    }
                }
            }    
        }
    }
?>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
    <link rel="stylesheet" href="css/style.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
	
</head>
<body>
<?php if (isset($erreur)) {?>
<div class="erreur"><?=$erreur;?></div>
<?php }?>
<form action="" method="post">
	<div class="retour"><a href="index.php">Retour</a></div>
    <h1>Inscription</h1>

    <label for="login">Login :</label>
    <input type="text" id="login" name="thelogin" class="input-deco input-user" autocomplete="off" value="<?=@$_POST["thelogin"];?>">
    <label for="pwd">Password :</label>
    <input type="password" id="pwd" name="thepwd" class="input-deco input-pwd" autocomplete="off" value="<?=@$_POST["thepwd"];?>">
    <label for="mail">E-mail :</label>
    <input type="email" id="mail" name="themail" class="input-deco input-mail" autocomplete="off" value="<?=@$_POST["themail"];?>">
	
    <div class="g-recaptcha" data-sitekey="6LfI91cUAAAAAOxgTFYAqh-cO4aihwC_Nm5u3-_D"></div>
    <br>
    <input id="button" type="submit">
</form>
</body>
</html>
