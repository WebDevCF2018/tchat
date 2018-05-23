<?php
// on évite la mise en cache
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
require "../verifSession.php";
require_once "../mysqliConnect.php";
require_once "../function.php";
$sql = "SELECT m.*,u.thelogin,u.thecolor FROM themessage m 
        INNER JOIN theuser u 
          ON u.idutil = m.theuser_idutil
ORDER BY m.idmessage DESC LIMIT 0,30";
$recup = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
// pas de résultats
if (!mysqli_num_rows($recup)) {
    echo "<h3>No message yet !</h3>";
} else {
    $tous = mysqli_fetch_all($recup, MYSQLI_ASSOC);
    $tous = array_reverse($tous);
    foreach ($tous AS $item) {
        $item['thecontent'] = traiteChaine($item['thecontent']);
        $choiceLeftRight = $item["thelogin"] == $_SESSION["thelogin"] ? " right" : " left";
        ?>

        <div class='message<?= $choiceLeftRight ?>' style='color:<?= $item["thecolor"] ?>'>
            <i><?= $item['thelogin'] ?><p>connecté</p></i>
            <p><?= $item['thecontent'] ?><br><br><span id='date'><?= thedate($item['thedatetime']) ?></span></p></div>
        <?php

    }
}

function pourMot($db){
    $sql = "SELECT m.*,u.thelogin,u.thecolor FROM themessage m 
        INNER JOIN theuser u 
          ON u.idutil = m.theuser_idutil
ORDER BY m.idmessage DESC LIMIT 0,30";

    $recup= mysqli_query($db,$sql) or die (mysqli_error($db));
    if(mysqli_num_rows($recup)){
        return mysqli_fetch_assoc($recup);

    }else{
        return false;
    }

}

$requete=pourMot($mysqli);
$mot = Censure($requete['thecontent'],$gros);
var_dump($mot);