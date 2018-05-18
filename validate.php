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
                ?><div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
					<div class="table">
						<div class="row">
							<div  class="cell" data-title="Full Name">
								Your account has been validated !
							</div>
						</div>
					</div>
					<a href='?p=connect'>Login</a>
			</div>
		</div>
	</div><?php
            } elseif ($recup == "already") {

                ?> <div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
					<div class="table">
						<div class="row">
							<div class="cell" data-title="Full Name">
								Your account is already validated !
							</div>
						</div>
					</div>
					<a href='?p=connect'>Login</a>
			</div>
		</div>
	</div><?php
            } elseif ($recup == "rejected") {
                ?><div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
					<div class="table">
						<div class="row">
							<div class="cell" data-title="Full Name">
								Your account is not valid !
							</div>
						</div>
					</div>

					<a href='?p=inscription'>Register</a>
			</div>
		</div>
	</div><?php
            } else {
                ?><div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
					<div class="table">
						<div class="row">
							<div class="cell" data-title="Full Name">
								Your account is not valid !
							</div>
						</div>
					</div>
					<a href='?p=inscription'>Register</a>
			</div>
		</div>
	</div><?php
            }
        }
        ?>

    </body>
</html>