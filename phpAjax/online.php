<?php

// on évite la mise en cache
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
require "../verifSession.php";
require_once "../mysqliConnect.php";
require_once "../function.php";
$thetime = date("Y-m-d H:i:s",time() - 60);
//TOTAL d'utilisateur connecté la dernière minute
$sql = "SELECT COUNT(DISTINCT idutil) AS nb FROM `theonline` WHERE thetime>'$thetime';";

$recup = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));


$tous = mysqli_fetch_array($recup);

echo $tous['nb'];

// supression des anciens
$sql = "DELETE FROM `theonline` WHERE thetime<'$thetime';";

$recup = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));