<?php
// on évite la mise en cache
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");

require_once "../mysqliConnect.php";

// pas de variables POST attendues
if(!isset($_POST['myNAME'],$_POST['myTXT'])){
    // envoi de l'erreur
    echo "0";
    // arrêt du script
    exit();
}

// récupérations et traitement de nos variables POST
$post_name= (int) $_SESSION["idutil"];
$post_text=htmlspecialchars(strip_tags(trim($_POST['myTXT'])),ENT_QUOTES);

if(empty($post_name)||empty($post_text)){
    // envoi de l'erreur
    echo "1";
    // arrêt du script
    exit();
}

// insertion db
$sql = "INSERT INTO contenu (nom,texte) VALUES ('$post_name','$post_text') ";
$insert = @mysqli_query($mysqli,$sql);

// si pas d'insertion (0 si non inséré, -1 en cas d'erreur sql)
if(mysqli_affected_rows($mysqli)<=0){
    // envoi de l'erreur
    echo "2";
    // arrêt du script
    exit();
}

// on arrive ici, donc pas d'erreur, on envoie 3
echo "3";

