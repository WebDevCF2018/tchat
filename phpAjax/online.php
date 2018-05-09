<?php
// on évite la mise en cache
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
require "../verifSession.php";
require_once "../mysqliConnect.php";
require_once "../function.php";

//TOTAL d'utilisateur connecté 
$sql = "SELECT COUNT(theonline) FROM `theuser` WHERE theonline = 1";
//Les utilisateurs connectés
$sql1 = "SELECT thelogin,theonline FROM `theuser` WHERE theonline = 1";
$recup = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));

// pas de résultats
if(!mysqli_num_rows($recup)){
    echo "<h3>Pas d'utilisateur en ligne</h3>";
}else{
    $tous = mysqli_fetch_all($recup,MYSQLI_ASSOC);

    foreach($tous AS $item){
        echo $item["COUNT(theonline)"];
    }
}
