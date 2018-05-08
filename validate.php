<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Validation</title>
        <link rel="stylesheet" href="css/style.css">
    </head>

<body>

<?php
require "verifSession.php";
if(isset($_GET['id'])&& isset($_GET['key'])){
    $clef=$_GET['key'];
    $identifiant=$_GET['id'];
    $recup = confirmUser($mysqli, $identifiant, $clef);
    if($recup=="ok") {
        echo "Votre compte à été validé !";
    }elseif ($recup=="already"){
        echo "Votre compte est déjà validé !";
    }elseif ($recup=="rejected"){
        echo "Votre compte n'est pas valide !";
    }else{
        echo "Votre compte n'est pas valide !";
    }
}

?>

</body>
</html>


