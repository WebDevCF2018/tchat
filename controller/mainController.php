<?php
	if(isset($_GET['p'])){
		switch($_GET['p']){
			
			case "connect":
				require "connect.php";
				break;

			case "inscription":
				require "inscription.php";
				break;

			case "validate":
				require "validate.php";
				break;

			default:
				require "404.php";
		}
	}else{
		require "connect.php";
	}


$connect = connectUser($mysqli,$_POST['theLogin'],$_POST['thePass']);
// on s'est connecté
if($connect){
    /*
    $_SESSION['idutil'] = $connect['iduser']; // iduser
    $_SESSION['login'] = $connect['login'];
    $_SESSION['name'] = $connect['username'];
    $_SESSION['permissionname'] = $connect['permissionname'];
    plus simple:
    */
    // on met toutes les variables récupérées depuis la db directement dans la session
    $_SESSION = $connect;
    // on ajoute à la variable super globale de session 'myKey' qui stoque la clef de session (PHPSESSID)
    $_SESSION['myKey'] = session_id(); // id de session

    // on réactulise sur l'accueil pour passer en mode "admin"
    header("Location: ./");

}else{
    $erreur_login = "Login et/ou mot de passe incorrect";
    require_once "v/login.html.php";
}
?>