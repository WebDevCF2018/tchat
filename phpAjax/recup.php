<?php
// on évite la mise en cache
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
require "../verifSession.php";
require_once "../mysqliConnect.php";
require_once "../function.php";
require_once "../PDOConnect.php";

$sql = "SELECT m.*,u.idutil,u.thelogin,u.thecolor,u.theimage FROM themessage m 
        INNER JOIN theuser u 
          ON u.idutil = m.theuser_idutil
ORDER BY m.thedatetime DESC LIMIT 0,30";
$recup = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
// pas de résultats
if (!mysqli_num_rows($recup)) {
    echo "<h3>No message yet !</h3>";
} else {

    $tous = mysqli_fetch_all($recup, MYSQLI_ASSOC);
    $tous = array_reverse($tous);


    foreach ($tous AS $item) {

        $item['thecontent'] = traiteChaine(links(Censurer($item['thecontent'])));
        $choiceLeftRight = $item["thelogin"] == $_SESSION["thelogin"] ? " right" : " left";
        $choiceOnlineOffline = in_array($item['idutil'],$_SESSION['online']) ? " online" : " offline";
        ?>

        <div class='message<?= $choiceLeftRight ?>' style='color:<?= $item["thecolor"] ?>'>
            <i class='<?= $choiceOnlineOffline ?>'>
            	<img src="http://yourtchat.webdev-cf2m.be/img/profil/thumbs/<?=$item['theimage']?>"height="50" width="50" >               
            </i>
            <div>
            	<span class='<?= $choiceLeftRight ?>'><?=$item['thelogin']." / ".yourStatus(counter($PDO,$item['idutil']))?> </span>
            	<p><?= $item['thecontent'] ?></p>
        	</div>
            <span id='date'>
            	<?= thedate($item['thedatetime']) ?>
            	</span>
        </div>
        <?php
    }
}



//var_dump($_SESSION['online']);

