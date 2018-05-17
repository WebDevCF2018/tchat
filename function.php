<?php

function sha256($lepwd) {
    $lepwd = hash('sha256', $lepwd);
    return $lepwd;
}

//var_dump(sha256($lepwd));
function createKey() {


    // longueur chaîne de sortie
    $length = 64;
    $key = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    // création d'un tableau indexé à partir de la chaîne $key (0=>"A"
    $keyArray = str_split($key);
    // nombre d'entrées dans ce tableau
    $numArray = count($keyArray);
    // préparation de la variable de sortie au format string
    $string = '';
    // tourne autant de X que $length
    for ($i = 0; $i < $length; $i++) {
        // on concatène à la variable de sortie le tableau $keyArray[] avec une clef au hasard rand() entre 0 et la longueur du tableau -1 ($numArray-1)
        $string .= $keyArray[rand(0, $numArray - 1)];
    }
    return $string;
}

//var_dump(createKey());


function EnvoiConfirmMail($lelogin, $themail, $lastid, $thekey) { // les variables php du requete

    $to = "$themail";  //mail d'utilisateur, qui a fait le registration

    $subject = 'Validez votre inscription sur le Tchat Webdev CF2m 2018'; // l'adresse

    $message = "
     <html>
      <head>
       <title>Validez votre inscription sur le Tchat Webdev CF2m 2018!</title>
      </head>
      <body>
       <p>Merci $lelogin pour votre inscription sur le Tchat Webdev CF2m 2018!</p>
       <p>Cliquez sur <a href='https://yourtchat.webdev-cf2m.be/?p=validate&id=$lastid&key=$thekey' target='_blank'>ce lien</a> pour valider votre compte.</p>
       <p>Si vous ne vous êtes pas inscrit sur notre site, vous pouvez ignorer ce mail!</p>
      </body>
     </html>
     ";

    $from = 'MIME-Version: 1.0' . "\r\n";
    $from .= 'Content-type: text/html; charset=utf-8' . "\r\n";

    $from .= 'From: tchat@webdev-cf2m.be ' . "\r\n" . // l'adresse du site
            'Reply-To: tchat@webdev-cf2m.be ' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
    return @mail($to, $subject, $message, $from);
}

/*
 * Permet d'insérer un utilisateur dans la table chat18cf2m, renvoie true si ça a fonctionné, false en cas d'échec
 *
 * Create
 *
 */

function newuser($db, $lelogin, $lepwd, $themail) {
    // vérification de sécurité de $title et $text
    if (empty($lelogin) || empty($lepwd)) {
        return false;
    }
    $lepwd = sha256($lepwd);
    $thekey = createKey();
    // req sql
    $sql = "INSERT INTO theuser (thelogin,thepwd,themail,thekey) VALUES ('$lelogin','$lepwd','$themail','$thekey');";
    $ajout = mysqli_query($db, $sql) or die(mysqli_error($db));
    if (mysqli_error($db)) {
        header("Location: ./?p=inscription&error=1");
        return false;
    }
    $lastid = mysqli_insert_id($db);
    // si on a inséré l'article
    if (mysqli_affected_rows($db)) {
        EnvoiConfirmMail($lelogin, $themail, $lastid, $thekey);
        return true;
    }
    return false;
}

// identification pour administration- connectUser()
function connectUser($db, $lelogin, $pass) {
    $lelogin = htmlspecialchars(strip_tags(trim($lelogin)), ENT_QUOTES);
    $pwd = htmlspecialchars(strip_tags(trim($pass)), ENT_QUOTES);
    $pwd = sha256($pwd);

    $sql = "SELECT idutil, thelogin,thevalidate FROM theuser WHERE thelogin= '$lelogin' AND thepwd= '$pwd' ;";


    $recupLogin = mysqli_query($db, $sql) or die(mysqli_error($db));

    return mysqli_fetch_assoc($recupLogin);
}


/* Fonctions de Niko */

/* Fonction de remplacement de strings par smileys */

function traiteChaine($text) {
    $text = str_replace(':)', '<img class=emoji src="img/smile.png" alt="smile" title=":smile:">', $text);
    $text = str_replace(':-)', '<img class="emoji" src="img/smile.png" alt="smile" title=\':smile:\'>', $text);
    $text = str_replace(':smile:', '<img class=emoji src="img/smile.png" alt="smile" title=":smile:">', $text);
    $text = str_replace(":'(", '<img class=emoji src="img/sad.gif" alt="sad" title=":sad:">', $text);
    $text = str_replace(':-(', '<img class="emoji" src="img/angry.gif" alt="angry" title=\':angry:\'>', $text);
    $text = str_replace(':sad:', '<img class=emoji src="img/sad.gif" alt="sad" title=":sad:">', $text);
    $text = str_replace('T_T', '<img class=emoji src="img/sad.gif" alt="sad" title="sad">', $text);
    $text = str_replace(':nyan:', '<img class=emoji src="img/nyan.gif" alt="nyan" title=":nyan:">', $text);
    $text = str_replace(':like:', '<img class=emoji src="img/like.gif" alt="like" title=":like:">', $text);
    $text = str_replace('>:(', '<img class=emoji src="img/angry.gif" alt="angry" title=":angry:">', $text);
    $text = str_replace(':angry:', '<img class=emoji src="img/angry.gif" alt="angry" title=":angry:">', $text);
    $text = str_replace(':wow:', '<img class=emoji src="img/wow.gif" alt="wow" title=":wow:">', $text);
    $text = str_replace(':o', '<img class=emoji src="img/wow.gif" alt="wow" title=":wow:">', $text);
    $text = str_replace(':laugh:', '<img class=emoji src="img/laugh.gif" alt="laugh" title=":laugh:">', $text);
    $text = str_replace(':D', '<img class=emoji src="img/laugh.gif" alt="laugh" title=":laugh:">', $text);
    $text = str_replace(':knuckle:', '<img class=emoji src="img/knuckle.png" alt="knuckle" title=":knuckle:">', $text);
    $text = str_replace(':troll:', '<img class=emoji src="img/troll.png" alt="troll" title=":troll:">', $text);
    $text = str_replace(':heart:', '<img class=emoji src="img/heart.gif" alt="heart" title=":heart:">', $text);
    $text = str_replace('<3', '<img class=emoji src="img/heart.gif" alt="heart" title=":heart:">', $text);
    $text = str_replace(':confused:', '<img class=emoji src="img/confused.png" alt="confused" title=":confused:">', $text);
    $text = str_replace('>_<', '<img class=emoji src="img/confused.png" alt="confused" title=":confused:">', $text);
    $text = str_replace(':happy:', '<img class=emoji src="img/happy.png" alt="happy" title=":happy:">', $text);
    $text = str_replace(':surprised:', '<img class=emoji src="img/surprised.png" alt="surprised" title=":surprised:">', $text);
    return $text = str_replace(':star:', '<img class=emoji src="img/star.png" alt="star" title=":star:">', $text);
}

/* Fonction d'activation du compte du nouvel utilisateur */

function confirmUser($connexion, $idutil, $thekey) {
    // permet de rendre une variable globale déjà existante active dans la fonction => global $mysqli;

    /*
     * Protection des variables car elles peuvent être manipulées par les utilisateurs
     */

    $idutil = (int) $idutil;
    $thekey = htmlspecialchars(strip_tags($thekey), ENT_QUOTES);

    /* Récupère la clé d'activation */
    $req = mysqli_query($connexion, "SELECT thekey, thevalidate FROM theuser WHERE idutil= $idutil") or die(mysqli_error($connexion));
    // si on ne récupère pas d'utilisateur on quitte la fonction
    if (!mysqli_num_rows($req))
        return false;


    $data = mysqli_fetch_assoc($req);


    /* Si la clé n'est pas identique à celle reçue via l'url OU qu'on a banni l'utilisateur */
    if ($thekey != $data['thekey'] || $data['thevalidate'] == 2) {
        /* Bad Key */
        return "rejected";
        /* Sinon */
    } else {
        /* Si compte déja validé */
        if ($data['thevalidate'] == 1) {
            /* Already activated */
            return "already";
            /* Sinon */
        } else {
            /* Activation permited */
            $req = mysqli_query($connexion, "UPDATE theuser SET thevalidate = 1 WHERE idutil = $idutil") or die(mysqli_error($connexion));
            colorMessage($connexion, $idutil);
            return "ok";
        }
    }
}

/* ---------------Fin des fonctions de Niko---------------- */

function colorMessage($db, $idutil) {
    $idutil = (int) $idutil;
    $colorArray = ['#000000', '#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#00FFFF', '#FF00FF', '#C0C0C0', '#808080', '#800000', '#808000', '#008000', '#800080', '#008080', '#000080'];
    $thecolor = $colorArray[mt_rand(0, count($colorArray) - 1)];
    $sql = "UPDATE theuser SET thecolor = '$thecolor' WHERE idutil = $idutil";
    mysqli_query($db, $sql) or die(mysqli_error($db));
}

function infoUser($db,$lelogin) {

    $sql = "SELECT thelogin,themail,theimage FROM theuser WHERE thelogin= '$lelogin';";


    $recupLogin = mysqli_query($db, $sql) or die(mysqli_error($db));

    return mysqli_fetch_assoc($recupLogin);
}

function updateUser($db,$idutil,$password,$repassword){
    if (isset($_POST["submit"])){
        if(!empty($_FILES['uploaded_file']) && empty($password)){
            $path = "img/";
            $path = $path . basename( $_FILES['uploaded_file']['name']);
            if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
                echo "Mise à jour du profil !";
                $theimage = basename($_FILES['uploaded_file']['name']);
                $sql = "UPDATE theuser SET theimage = '$theimage' WHERE thelogin = '$lelogin'";
                $query = mysqli_query($db, $sql) or die(mysqli_error($db));
            } else{
                echo "erreur d'upload !";
            }
        }
        else if (!empty($password) && empty($_FILES['uploaded_file'])) {
            if($password == $repassword){
                echo "Mise à jour du profil !";
                $password = htmlspecialchars(strip_tags(trim($pass)), ENT_QUOTES);
                $password = sha256($pwd);
                
                $sql = "UPDATE theuser SET thepwd = '$password' WHERE thelogin = '$lelogin'";
                $query = mysqli_query($db, $sql) or die(mysqli_error($db));
                
            }else {
                echo "les mots de passes ne sont pas identiques !";
            }
        }
        else if(!empty($_FILES['uploaded_file']) && !empty($password)){
            if($password == $repassword){
                $password = htmlspecialchars(strip_tags(trim($pass)), ENT_QUOTES);
                $password = sha256($pwd);
                
                $sql = "UPDATE theuser SET thepwd = '$password', theimage = '$theimage' WHERE thelogin = '$lelogin'";
                $query = mysqli_query($db, $sql) or die(mysqli_error($db));
                $path = "img/";
                $path = $path . basename( $_FILES['uploaded_file']['name']);
                if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
                  echo "Mise à jour du profil";
                } else{
                    echo "erreur d'upload !";
                }

            }else {
                echo "les mots de passes ne sont pas identiques !";
            }
        }
    }
}