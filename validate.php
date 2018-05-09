<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Validation</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
    </head>
<body>

<?php

if(isset($_GET['id'])&& isset($_GET['key'])){
    $clef=$_GET['key'];
    $identifiant=$_GET['id'];
    $recup = confirmUser($mysqli, $identifiant, $clef);
    if($recup=="ok") {
        echo "<div class=\"limiter\">
		<div class=\"container-table100\">
			<div class=\"wrap-table100\">
					<div class=\"table\">
						<div class=\"row\">
							<div  class=\"cell\" data-title=\"Full Name\">
								Votre compte a bien été validé !
							</div>
						</div>
					</div>
					<a href='?p=connect'>se connecter</a>
			</div>
		</div>
	</div>";

    }elseif ($recup=="already"){
        echo "<div class=\"limiter\">
		<div class=\"container-table100\">
			<div class=\"wrap-table100\">
					<div class=\"table\">
						<div class=\"row\">
							<div class=\"cell\" data-title=\"Full Name\">
								Votre compte est déjà validé !
							</div>
						</div>
					</div>
					<a href='?p=connect'>se connecter</a>
			</div>
		</div>
	</div>";
    }elseif ($recup=="rejected"){
        echo "<div class=\"limiter\">
		<div class=\"container-table100\">
			<div class=\"wrap-table100\">
					<div class=\"table\">
						<div class=\"row\">
							<div class=\"cell\" data-title=\"Full Name\">
								Votre compte n'est pas valide !
							</div>
						</div>
					</div>

					<a href='?p=inscription'>s'inscrire</a>
			</div>
		</div>
	</div>";
    }else{
        echo "<div class=\"limiter\">
		<div class=\"container-table100\">
			<div class=\"wrap-table100\">
					<div class=\"table\">
						<div class=\"row\">
							<div class=\"cell\" data-title=\"Full Name\">
								Votre compte n'est pas valide !
							</div>
						</div>
					</div>
					<a href='?p=inscription'>s'inscrire</a>
			</div>
		</div>
	</div>";
    }
}

?>

</body>
</html>