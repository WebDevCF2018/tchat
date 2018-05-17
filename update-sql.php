<?php
require_once "config.php";
require_once "mysqliConnect.php";

$sql = "ALTER TABLE `theuser` ADD `theimage` VARCHAR(128) NOT NULL DEFAULT 'img/profil.png' AFTER `thevalidate`";
//$sql = "SELECT * FROM theuser WHERE theuser = 'shaban'";
$recup = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
?>