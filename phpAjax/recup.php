<?php
// on évite la mise en cache
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
require_once "../mysqliConnect.php";

$sql = "SELECT * FROM contenu ORDER BY id DESC LIMIT 0,30";
$recup = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
// pas de résultats
if(!mysqli_num_rows($recup)){
    echo "<h3>Pas encore de message!</h3>";
}else{
    $tous = mysqli_fetch_all($recup,MYSQLI_ASSOC);
    $tous = array_reverse($tous);
    foreach($tous AS $item){
        echo "{$item['ladate']} | {$item['nom']} | {$item['texte']}<hr>";
    }
}
