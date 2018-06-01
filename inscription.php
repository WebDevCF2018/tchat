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

        if (isset($_POST['thelogin']) && isset($_POST["thepwd"]) && isset($_POST["themail"])) {
            if (empty($_POST['thelogin']) && empty($_POST["thepwd"]) && empty($_POST["themail"])) {
                $erreur = "Please complete all fields !
";
        
            }
            else if(empty($_POST['thelogin'])){
                $erreur = "<p style='background-color:#2e9aaf'>Please insert a username !</p>";
            }
            else if(empty($_POST['thepwd'])){
                $erreur = "<p style='background-color:#2e9aaf'>Please insert a password !</p>";
            }
            else if(empty($_POST['themail'])){
                $erreur = "<p style='background-color:#2e9aaf'>Please insert an email address !</p>";
            } 
        
        else {
            $login = htmlspecialchars(strip_tags(trim($_POST['thelogin'])), ENT_QUOTES);
            $pwd = strip_tags(trim($_POST['thepwd']));
            $email = filter_var($_POST['themail'], FILTER_VALIDATE_EMAIL);
            $envReq = newuser($PDO, $login, $pwd, $email);
                if($envReq){
                    $erreur = "<p style='background-color:#dda93fb3'>You are registered. You will receive a confirmation email before you can log in</p>";
                    }else {
                        $erreur = "<p style='background-color:#2e9aaf'>Failed to register, please try again</p>";
                    }
                }
            }    
        }
    }
    if(isset($_GET['error'])){
            $erreur = "<p style='background-color:#2e9aaf'>Username already used !</p>"."<p>Choose an another one: ".createFreeLogin($_GET['error'],'login')."</p>";


    }
?>
    <meta charset="UTF-8">
    <title>Tchat: Registration</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" media="screen" href="css/style.css">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
    <script src='https://www.google.com/recaptcha/api.js'></script>


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
<form id="register-form" action="?p=inscription" method="post">
	<div class="retour"><a href="index.php">Return</a></div>
    <h1>Registration</h1>

    <label for="login">Login :</label>
    <input type="text" placeholder="your login" id="login" name="thelogin" class="input-deco input-user" autocomplete="off" value="<?=@$_POST["thelogin"];?>">
    <label for="pwd">Password :</label>
    <input type="password" placeholder="your password" id="pwd" name="thepwd" class="input-deco input-pwd" autocomplete="off" value="<?=@$_POST["thepwd"];?>">
    <label for="mail">E-mail :</label>
    <input type="email" placeholder="your email" id="mail" name="themail" class="input-deco input-mail" autocomplete="off" value="<?=@$_POST["themail"];?>">
	
    <div class="g-recaptcha" data-sitekey="6LfI91cUAAAAAOxgTFYAqh-cO4aihwC_Nm5u3-_D"></div>
    <br>
    <input id="button" type="submit" value="Send">


</form>
<!-- Matomo -->
<script type="text/javascript">
  var _paq = _paq || [];
  /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//statistiques.cf2m.be/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', '1']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->
</body>
</html>
