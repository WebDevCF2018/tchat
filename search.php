<?php
require "verifSession.php";
require_once "mysqliConnect.php";
require_once "function.php";
/*PDO connect*/
require_once "PDOConnect.php";

$info = infoUser($PDO, $_SESSION["idutil"]);

$nb_par_page = 10;
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
$resultat_search = [];
$pagination = maPagination($nb_tot, $pg,"pg",$nb_par_page);
if(isset($_POST['toto'])){
    $lulu = htmlspecialchars(trim($_POST['toto']),ENT_QUOTES);
    $iquery_count = mysqli_query($mysqli, "SELECT m.*,u.thelogin,u.thecolor 
        FROM themessage m 
        INNER JOIN theuser u 
        ON u.idutil = m.theuser_idutil WHERE `thecontent` LIKE '%$lulu%' ORDER BY thedatetime desc");
    $count = mysqli_num_rows($iquery_count);
    if($count){
        $resultat_search = mysqli_fetch_all($iquery_count, MYSQLI_ASSOC);
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tchat: Search</title>
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
                <img src="img/profil/thumbs/<?=$info["theimage"];?>">
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
<h1>Archives : Mini chat</h1>
<div class="formulaire">
</div>
<div id="searchresults">
    <?php
    if(!$count){
        echo "<h3>No message yet !</h3>";
    }else {
        foreach ($resultat_search as $ligne) {
            ?>
            <div class="archives-message"><?php echo $ligne['thecontent'] = traiteChaine(links(Censurer($ligne['thecontent']))) ?><a href="?idarticle=<?= $ligne['idmessage'] ?>"></a>
            <h4><?= $ligne['thedatetime'] ?> -
                <a href="#"><?= $ligne['thelogin'] ?></a></h4></div>
            <?php
        }
    }
    ?>
</div>

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

</body>
</html>