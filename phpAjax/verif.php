<?php
require "../verifSession.php";
// ouverture de session pour stocker le nombre d'entrées dans la base de données
session_start();
// on évite la mise en cache
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
require_once "../PDOConnect.php";

$recup = $PDO->query("SELECT COUNT(*) AS nombre FROM themessage");
$result = $recup->fetch(PDO::FETCH_ASSOC);
$nb = $result['nombre'];
// si la variable de session n'existe pas encore
if(!isset($_SESSION['nombre'])){
    // on la crée
    $_SESSION['nombre']=$nb;
    echo "rien";
}else{
    // on vérifie si $nb (nouveau count) est différent du count précédent ($_SESSION['nombre'])
    if($_SESSION['nombre']!=$nb){
        // mise à jour de la variable de session
        $_SESSION['nombre']=$nb;
        // réponse qui va actualiser le div 'content'
        echo "change";
    }else{
        echo "rien";
    }
}
// pour online

$recup = $PDO ->query("INSERT INTO theonline (idutil) VALUES (".$_SESSION['idutil'].")");