<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Validation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" media="screen" href="css/style.css">
        <link rel="icon" type="image/png" sizes="16x16" href="img/favicon.ico">
    </head>
    <body>
        <div id="particles-js"></div>

        <!-- scripts -->
        <script src="js/particles.min.js"></script>
        <script src="js/app.min.js"></script>


        <?php
        if (isset($_GET['id']) && isset($_GET['key'])) {
            $clef = $_GET['key'];
            $identifiant = $_GET['id'];
            $recup = confirmUser($mysqli, $identifiant, $clef);
            if ($recup == "ok") {
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
            } elseif ($recup == "already") {
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
            } elseif ($recup == "rejected") {
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
            } else {
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