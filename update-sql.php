<?php
	require_once "mysqliConnect.php";
	$sql = "UPDATE theuser SET thevalidate = '1' WHERE thelogin = 'alba'";
	//$sql = "ALTER TABLE `theuser` ADD `theonline` BOOLEAN NOT NULL DEFAULT FALSE AFTER `thevalidate`";
	$recup = mysqli_query($mysqli,$sql) or die(mysqli_error($mysqli));
	if($recup){
		echo "La colonne 'theonline' a très bien été ajouté !";
	}
?>
