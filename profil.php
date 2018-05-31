<?php
require "verifSession.php";
require_once "config.php";
require_once "mysqliConnect.php";
require_once "function.php";

$info = infoUser($mysqli,$_SESSION["thelogin"]);

if (isset($_POST['submit'])) {
    updateUser($mysqli,$_SESSION["thelogin"],$_POST["password"],$_POST["repassword"],$_POST["color"]);

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
                    <img src="img/profil/thumbs/<?=$info["theimage"];?>">
                    <li>Return</b></li>
                </div>
            </a>
            <a href="deco.php"><li><b>Sign out</b></li></a>
        </div>
    </nav>
    <div class="profil display">
    	<h1>Profile Setting</h1>
        <form enctype="multipart/form-data" method="post" action="" name="fff">
    		<div class="profil-form">
	    		<label>
                    Username :
	    			<input type="text" name="thename" value="<?=$info["thelogin"];?>" disabled>
	    		</label>
	    		<label>
	    			e-Mail:
	    			<input type="text" name="themail" value="<?=$info["themail"];?>" disabled>
	    		</label>
	    		<label>
                    New Password :
	    			<input type="password" name="password">
	    		</label>
	    		<label>
                    Enter the password again :
	    			<input type="password" name="repassword">
	    		</label>
                <label>
                    Chose the color :
                <input  type="color" name="color" />
                </label>
	    		<input type="submit" name="submit">
	    	</div>
	    	<div class="profil-form pf-center">
	    		<img src="img/profil/large/<?=$info["theimage"];?>">
	    		<input type="file" name="uploaded_file">


	    	</div>

    	</form>

    </div>
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