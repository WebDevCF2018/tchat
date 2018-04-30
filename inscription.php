<!DOCTYPE html>
<html lang="en">
<head>
    <?php
    include_once "mysqliConnect.php";
    include_once "function.php";



    if (isset($_POST['thelogin']) && isset($_POST["thepwd"])&& isset($_POST["themail"])){

        $login= htmlspecialchars(strip_tags(trim($_POST['thelogin'])),ENT_QUOTES);
        $pwd= strip_tags(trim($_POST['thepwd']));
        $email= filter_var($_POST['themail'], FILTER_VALIDATE_EMAIL);

    }else{
        return "problème survenue lors de l'envoye !";
    }
    $envReq = newuser($mysqli,$login,$pwd);
    ?>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/inscription_style.css">
</head>
<body>
<form action="" method="post">
    <h1>Inscription</h1>
    <div>
        <label for="login">Login :</label>
        <input type="text" id="login" name="thelogin">
    </div>
    <div>
        <label for="pwd">Password :</label>
        <input type="password" id="pwd" name="thepwd">

    </div>
    <div>
        <label for="mail">E-mail :</label>
        <input type="email" id="mail" name="themail">
    </div>
    <div>
        <input id="button" type="submit" name="thesend" onclick="<?=$envReq;?>">


    </div>
</form>

</body>
</html>