<?php
require "verifSession.php";
require_once "PDOConnect.php";
require_once "function.php";

$info = infoUser($PDO, $_SESSION["idutil"]);

$nb_par_page = 100;
if (!isset($_GET['idarticle'])) {
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
// first update to PDO

$requete = $PDO->query("SELECT COUNT(idmessage) AS nb FROM themessage;");
$requete_assoc = $requete->fetch(PDO::FETCH_OBJ);
$nb_tot = $requete_assoc->nb;

// calcul pour le premier argument du LIMIT
$limit = ($pg - 1) * $nb_par_page;

// requête préparée (même si sécurisée, comme elle a un lien avec une variable get $_GET['pg'] avec les emplacements nommés :mylimit et :mynbpg

$sql = "SELECT m.*,u.thelogin,u.thecolor,u.theimage 
        FROM themessage m 
        INNER JOIN theuser u 
        ON u.idutil = m.theuser_idutil
        ORDER BY m.thedatetime DESC         
        LIMIT :mylimit, :mynbpg";


$recup = $PDO->prepare($sql);

$recup->bindValue(":mylimit", $limit, PDO::PARAM_INT);
$recup->bindValue(":mynbpg", $nb_par_page, PDO::PARAM_INT);

try {
    $recup->execute();
} catch (PDOException $e) {
    echo "Erreur:" . $e->getMessage();
    die();
};
$pagination = maPagination($nb_tot, $pg, "pg", $nb_par_page);


// pas de résultats
if (!$recup->rowCount()) {
    $tous = [];
} else {
    $tous = $recup->fetchAll(PDO::FETCH_ASSOC);

}
?>
<!DOCTYPE html>
<html lang="fr">

    <head>
        <meta charset="UTF-8">
        <title>Tchat: Archives</title>
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
        <script src="js/ajax.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <link rel="stylesheet" media="screen" href="css/style.css">

    </head>

    <body class="tchat" >
        <div id="particles-js"></div>
        <!-- scripts -->
        <script src="js/particles.min.js"></script>
        <script src="js/app.min.js"></script>
        <nav>
            <div id="menu-mobile" onclick="menu()">☰</div>
            <div id="menu-mobile2" class="display">
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
<h1>Archives : Mini chat
    <small>(<?php if (!empty($nb_tot)) echo ($nb_tot > 1) ? "$nb_tot messages" : "$nb_tot message" ?>)</small>
</h1>
<p><?= $pagination ?></p>
<div id="archives">
    <?php
    if (empty($tous)) {
        echo "<h3>No message yet !</h3>";
    }
    foreach ($tous AS $item) {

        $item['thecontent'] = traiteChaine(links(Censurer($item['thecontent'])));
        echo "<div class='archives-message' style='color:{$item["thecolor"]};'><strong>{$item['thelogin']}</strong> <span id='date'>{$item['thedatetime']} - " . thedate($item['thedatetime']) . "</span><p>{$item['thecontent']}<br><br></p></div>";


    }
    ?>
</div>
<p><?= $pagination ?></p>
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

  var c = false;

function menu(){
  var a = document.getElementById("menu-mobile");
  var b = document.getElementById("menu-mobile2");

  if(c){
    b.style.cssText = 'display:none !important';
    c=false;

  }else{
    b.style.cssText = 'display:block !important';
    c = true;
  }
}

</script>
<!-- End Matomo Code -->
</body>
</html>