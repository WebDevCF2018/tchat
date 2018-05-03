<!DOCTYPE html>
<html lang="en">
<head>
    <?php

    if (isset($_POST['thelogin']) && isset($_POST["thepwd"]) && isset($_POST["themail"])) {
        $login = htmlspecialchars(strip_tags(trim($_POST['thelogin'])), ENT_QUOTES);
        $pwd = strip_tags(trim($_POST['thepwd']));
        $email = filter_var($_POST['themail'], FILTER_VALIDATE_EMAIL);
        $envReq = newuser($mysqli, $login, $pwd, $email);
    }

    ?>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<form action="" method="post">
	<div class="retour"><a href="index.php">Retour</a></div>
    <h1>Inscription</h1>

    <label for="login">Login :</label>
    <input type="text" id="login" name="thelogin" autocomplete="off">
    <label for="pwd">Password :</label>
    <input type="password" id="pwd" name="thepwd" autocomplete="off">
    <label for="mail">E-mail :</label>
    <input type="email" id="mail" name="themail" autocomplete="off">
    <input id="button" type="submit" name="thesend">
</form>
</body>
</html>