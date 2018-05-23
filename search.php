<?php
require "verifSession.php";
require_once "mysqliConnect.php";
require_once "function.php";

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

$sql = "SELECT m.*,u.thelogin,u.thecolor 
        FROM themessage m 
        INNER JOIN theuser u 
        ON u.idutil = m.theuser_idutil
        ORDER BY m.idmessage DESC 
        LIMIT $limit, $nb_par_page";
$recup = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
$pagination = maPagination($nb_tot, $pg,"pg",$nb_par_page);
if(isset($_POST['toto'])){
    $lulu = htmlspecialchars($_POST['toto'],ENT_QUOTES);
    $iquery_count = mysqli_query($mysqli, "SELECT m.*,u.thelogin,u.thecolor 
        FROM themessage m 
        INNER JOIN theuser u 
        ON u.idutil = m.theuser_idutil WHERE `thecontent` LIKE '%$lulu%' ");
    $count = mysqli_num_rows($iquery_count);
    if($count){
        $resultat_search = mysqli_fetch_all($iquery_count, MYSQLI_ASSOC);
    }
}
/*if(isset($resultat_search)){
    echo "Nombre de page(s): $count";
    echo "<pre>";
    var_dump($resultat_search);
    echo "</pre>";
}*/


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
    <title>Tchat</title>
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
                <img src="https://cdn.icon-icons.com/icons2/877/PNG/512/male-profile-picture_icon-icons.com_68388.png">
                <li>Bonjour, <b><?= $_SESSION["thelogin"]; ?></b></li>
            </div>
        </a>
        <li><a href="index.php">Return</a></li>
        <a href="deco.php"><li><b>Sign out</b></li></a>
    </div>
</nav>
<h1>Archives : Mini chat</h1>
<div class="formulaire">
    <form action='' class="form-wrapper" method='POST'>
        <input type="text" name='toto' id="search" placeholder="Recherche de..." required>
        <input type="submit" value="go" id="submit">
    </form>
</div>
<div id="searchresults">
    <?php
    foreach ($resultat_search as $ligne){
        ?>
        <p><?php echo $ligne['thecontent']?><a href="?idarticle=<?=$ligne['idmessage']?>"></a></p>
        <h4><?=$ligne['thedatetime']?> -
            <a href="mailto:<?=$ligne['themail']?>"><?=$ligne['thelogin']?></a></h4>
        <hr/>
        <?php
    }
    ?>

</div>

</body>
</html>