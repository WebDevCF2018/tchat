<?php
require "verifSession.php";
require_once "mysqliConnect.php";
require_once "function.php";
$info = infoUser($mysqli,$_SESSION["thelogin"]);


$info = infoUser($mysqli,$_SESSION["thelogin"]);
$nb_par_page = 60;
if(!isset($_GET['idarticle'])) {
// pour pagination
    if (isset($_GET['pg']) && ctype_digit($_GET['pg'])) {
        $pg = (int)$_GET['pg'];
    } else {
        $pg = 1;
    }
}
/*/*
 *  calcul pour la pagination
 */
// nombre total d'article
$requete = mysqli_query($mysqli, "SELECT COUNT(idmessage) AS nb FROM themessage;");
$requete_assoc = mysqli_fetch_assoc($requete);
$nb_tot = $requete_assoc['nb'];
// calcul pour le premier argument du LIMIT
$limit = ($pg-1)*$nb_par_page;
// requête pour récupérer tous les articles suivant la pagination
$sql = "SELECT m.*,u.thelogin,u.thecolor,u.theimage 
        FROM themessage m 
        INNER JOIN theuser u 
        ON u.idutil = m.theuser_idutil
        ORDER BY m.thedatetime DESC 
        LIMIT $limit, $nb_par_page";
$recup = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
$pagination = maPagination($nb_tot, $pg,"pg",$nb_par_page);


// pas de résultats
if(!mysqli_num_rows($recup)){
    echo "<h3>No message yet !</h3>";
}else{
    $tous = mysqli_fetch_all($recup,MYSQLI_ASSOC);

}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Tchat - Archives</title>
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
        <script src="js/ajax.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" media="screen" href="css/style.css">

    </head>

    <body class="tchat" >
        <div id="particles-js"></div>
        <!-- scripts -->
        <script src="js/particles.min.js"></script>
        <script src="js/app.min.js"></script>
        <nav>
            <div class="display">
                <a href="profil.php">
                    <div class="user-tchat">
                        <img src="img/profil/thumbs/<?=$info["theimage"]?>"height="50" width="50" >
                        <li>Bonjour, <b><?= $_SESSION["thelogin"]; ?></b></li>
                    </div>
                </a>
                <li><a href="index.php">Return</a></li>
                <a href="deco.php"><li class="signout"><b>Sign out</b></li></a>
                <form action='search.php' id="demo-2" method='POST'>
                    <input type="search" name='toto' placeholder="Search & enter" required>
                </form>
            </div>
        </nav>
        <h1>Archives : Mini chat <small>(<?php if(!empty($nb_tot)) echo ($nb_tot>1)? "$nb_tot messages": "$nb_tot message" ?>)</small></h1>
        <p><?=$pagination?></p>
		<div id="archives">	
		<?php
                foreach($tous AS $item){

            $item['thecontent'] = traiteChaine(links(Censurer($item['thecontent'])));
    		echo "<div class='archives-message' style='color:{$item["thecolor"]};'><strong>{$item['thelogin']}</strong> <span id='date'>{$item['thedatetime']} - ".thedate($item['thedatetime'])."</span><p>{$item['thecontent']}<br><br></p></div>";

        
			}
			?>
    </div>
        <p><?=$pagination?></p>
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