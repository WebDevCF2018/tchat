<?php
// on évite la mise en cache
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
require "../verifSession.php";
require_once "../mysqliConnect.php";
// pas de variables POST attendues
if(!isset($_POST['n'],$_POST['c'])){
    // envoi de l'erreur
    echo "0";
    // arrêt du script
    exit();
}
// récupérations et traitement de nos variables POST
$post_id= (int) $_POST['n'];
$post_text=htmlspecialchars(strip_tags(trim($_POST['c'])),ENT_QUOTES);
if(empty($post_id)||empty($post_text)){
    // envoi de l'erreur
    echo "1";
    // arrêt du script
    exit();
}
// insertion db
$sql = "INSERT INTO themessage (thecontent, theuser_idutil) VALUES ('$post_text','$post_id') ";
$insert = mysqli_query($mysqli,$sql);

// si pas d'insertion (0 si non inséré, -1 en cas d'erreur sql)
if(mysqli_affected_rows($mysqli)<=0){
    // envoi de l'erreur
    echo "2";
    // arrêt du script
    exit();
}
// on arrive ici, donc pas d'erreur, on envoie 3
echo "3";