<!DOCTYPE html>
<html>
    <head>
        <title>Validation</title>
    </head>

<body>

<?php

if(isset($_GET['id'])&& isset($_GET['key'])){
    $clef=$_GET['key'];
    $identifiant=$_GET['id'];
    echo "Votre compte à été validé !";
}else{

    false;

}

?>

</body>
</html>


