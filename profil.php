<?php
require "verifSession.php";
require_once "config.php";
require_once "mysqliConnect.php";
require_once "function.php";

$info = infoUser($mysqli,$_SESSION["thelogin"]);

@updateUser($mysqli,$_SESSION["thelogin"],$_POST["password"],$_POST["repassword"]);
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