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
$sql2 = "SELECT DISTINCT theuser.thelogin as users, theonline.idutil as online FROM theuser, theonline WHERE theuser.idutil = theonline.idutil ORDER BY theuser.thelogin ASC";

$recup = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
$recup2 = mysqli_query($mysqli, $sql2) or die(mysqli_error($mysqli));


$tous = mysqli_fetch_array($recup);
$users = "";
$online = [];
while($data = mysqli_fetch_array($recup2)){
	$users .= $data['users']."**";
	$online[]= $data['online'];
}
$users = substr($users, 0, -2);

$_SESSION['online'] = $online;

$send = $tous['nb']."+".$users;
echo $send;

// supression des anciens
$sql = "DELETE FROM `theonline` WHERE thetime < '$thetime';";

$recup = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
