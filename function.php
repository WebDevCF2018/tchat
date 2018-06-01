<?php
function sha256($lepwd) {
    $lepwd = hash('sha256', $lepwd);
    return $lepwd;
}

function createKey($length = 64) {
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

function EnvoiConfirmMail($lelogin, $themail, $lastid, $thekey) { // les variables php du requete
    $to = "$themail";  //mail d'utilisateur, qui a fait le registration
    $subject = 'Validez votre inscription sur le Tchat Webdev CF2m 2018'; // l'adresse
    $message = "
     <html>
      <head>
       <title>Confirm your registration on the Webdev CF2m 2018 Chat !</title>
      </head>
      <body>
       <p>Thanks $lelogin for your registration on the Webdev CF2m 2018 Chat !</p>
       <p>Click on <a href='https://yourtchat.webdev-cf2m.be/?p=validate&id=$lastid&key=$thekey' target='_blank'>this link</a> to validate your account.</p>
       <p>If you have not registered on our site, you can ignore this mail !</p>
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
function newuser(PDO $db, $lelogin, $lepwd, $themail) {
    // vérification de sécurité de $title et $text
    if (empty($lelogin) || empty($lepwd)) {
        return false;
    }
    $lepwd = sha256($lepwd);
    $thekey = createKey();
    // req sql
    $sql = "INSERT INTO theuser (thelogin,thepwd,themail,thekey) VALUES (?,?,?,'$thekey');";
    $recup = $db->prepare($sql);
    $recup->bindValue(1,$lelogin,PDO::PARAM_STR);
    $recup->bindValue(2,$lepwd,PDO::PARAM_STR);
    $recup->bindValue(3,$themail,PDO::PARAM_STR);
    try {
        $recup->execute();
    }catch (PDOException $e){
        header("Location: ./?p=inscription&error=$lelogin");
        return false;
    }
    $lastid = $db->lastInsertId();
    // si on a inséré l'article
    if ($recup) {
        EnvoiConfirmMail($lelogin, $themail, $lastid, $thekey);
        return true;
    }
    return false;
}



// identification pour administration- connectUser()
function connectUser(PDO $db, $lelogin, $pass) {
    $lelogin = htmlspecialchars(strip_tags(trim($lelogin)), ENT_QUOTES);
    $pwd = htmlspecialchars(strip_tags(trim($pass)), ENT_QUOTES);
    $pwd = sha256($pwd);
    $sql = "SELECT idutil, thelogin,thevalidate FROM theuser WHERE thelogin=? AND thepwd= ? ;";
    $recup = $db->prepare($sql);
    $recup->bindValue(1,$lelogin,PDO::PARAM_STR);
    $recup->bindValue(2,$pwd,PDO::PARAM_STR);
    $recup->execute();

    return $recup->fetch(PDO::FETCH_ASSOC);
}



/* Fonctions de Niko */
/* Fonction de remplacement de strings par smileys */
function traiteChaine($text) {
    $text = str_replace(':)', '<img class="emoji" src="img/icones/smile.png" alt="smile" title="smile">', $text);
    $text = str_replace(':-)', '>', $text);
    $text = str_replace(':smile:', '<img class="emoji" src="img/icones/smile.png" alt="smile" title="smile">', $text);
    $text = str_replace(":'(", '<img class="emoji" src="img/icones/sad.gif" alt="sad" title="sad">', $text);
    $text = str_replace(':-(', '>', $text);
    $text = str_replace(':sad:', '<img class="emoji" src="img/icones/sad.gif" alt="sad" title="sad">', $text);
    $text = str_replace('T_T', '<img class="emoji" src="img/icones/sad.gif" alt="sad" title="sad">', $text);
    $text = str_replace(':nyan:', '<img class="emoji" src="img/icones/nyan.gif" alt="nyan" title="nyan">', $text);
    $text = str_replace(':like:', '<img class="emoji" src="img/icones/like.gif" alt="like" title="like">', $text);
    $text = str_replace('>:(', '<img class="emoji" src="img/icones/angry.gif" alt="angry" title="angry">', $text);
    $text = str_replace(':angry:', '<img class="emoji" src="img/icones/angry.gif" alt="angry" title="angry">', $text);
    $text = str_replace(':wow:', '<img class="emoji" src="img/icones/wow.gif" alt="wow" title="wow">', $text);
    $text = str_replace(':o', '<img class="emoji" src="img/icones/wow.gif" alt="wow" title="wow">', $text);
    $text = str_replace(':laugh:', '<img class="emoji" src="img/icones/laugh.gif" alt="laugh" title="laugh">', $text);
    $text = str_replace(':D', '<img class="emoji" src="img/icones/laugh.gif" alt="laugh" title="laugh">', $text);
    $text = str_replace(':knuckle:', '<img class="emoji" src="img/icones/knuckle.png" alt="knuckle" title="knuckle">', $text);
    $text = str_replace(':troll:', '<img class="emoji" src="img/icones/troll.png" alt="troll" title="troll">', $text);
    $text = str_replace(':heart:', '<img class="emoji" src="img/icones/heart.gif" alt="heart" title=":heart:">', $text);
    $text = str_replace('<3', '<img class="emoji" src="img/icones/heart.gif" alt="heart" title=":heart:">', $text);
    $text = str_replace(':confused:', '<img class="emoji" src="img/icones/confused.png" alt="confused" title=":confused:">', $text);
    $text = str_replace('>_<', '<img class="emoji" src="img/icones/confused.png" alt="confused" title=":confused:">', $text);
    $text = str_replace(':happy:', '<img class="emoji" src="img/icones/happy.png" alt="happy" title=":happy:">', $text);
    $text = str_replace(':surprised:', '<img class="emoji" src="img/icones/surprised.png" alt="surprised" title=":surprised:">', $text);
    return $text = str_replace(':star:', '<img class="emoji" src="img/icones/star.png" alt="star" title=":star:">', $text);
}
/* Fonction d'activation du compte du nouvel utilisateur */
function confirmUser($connexion, $idutil, $thekey) {
    $idutil = (int) $idutil;
    $thekey = htmlspecialchars(strip_tags($thekey), ENT_QUOTES);
    /* Récupère la clé d'activation */
    $recup = $connexion->query("SELECT thekey, thevalidate FROM theuser WHERE idutil= $idutil");
    // si on ne récupère pas d'utilisateur on quitte la fonction
    if (!$recup->rowCount()) return false;
    $data = $recup->fetch(PDO::FETCH_ASSOC);
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
            $recup = $connexion->query("UPDATE theuser SET thevalidate = 1 WHERE idutil = $idutil");
            colorMessage($connexion, $idutil);
            return "ok";
        }
    }
}
/* ---------------Fin des fonctions de Niko---------------- */
function colorMessage($db, $idutil) {
    $idutil = (int) $idutil;

    $colorArray = ['#f44336','#e91e63','#9c27b0','#673ab7','#3f51b5','#2196f3','#03a9f4','#00bcd4','#8bc34a','#4caf50','#009688','#cddc39','#ffeb3b','#ffc107','#ff9800','#ff5722','#795548','#9e9e9e','#607d8b','#1b5571','#c12e00','#908314','#4A76A8','#E7C0D3','#009687','#0E6251','#AF7AC5','#2C3E50'];


    $thecolor = $colorArray[mt_rand(0, count($colorArray) - 1)];
    $sql = "UPDATE theuser SET thecolor = '$thecolor' WHERE idutil = $idutil";
    $db->query($sql);
}


function infoUser(PDO $db, int $id) {
    $sql = "SELECT thelogin,themail,theimage, thecolor FROM theuser WHERE idutil= $id;";
    $recupLogin = $db->query($sql);
    return $recupLogin->fetch(PDO::FETCH_ASSOC);
}

function updateUser($db, $lelogin, $password, $repassword , $color) {
    if (isset($_POST["submit"])) {
        if (!empty($_FILES['uploaded_file'])) {
            // constante pour les thumbs (100 px L comme H)
            define("THUMB_SIZE", 50);

// constantes pour les grandes (800 px L max sur 600 px H max)
            define("LARGE_WIDTH", 800);
            define("LARGE_HEIGHT", 600);

// définition de la qualité pour les images .jpg
            define("QUALITY_JPG_THUMB", 85);
            define("QUALITY_JPG_LARGE", 90);


// chemin du dossier original (vers lequel sont chargé les fichiers originaux)
            $oriDest = "img/profil/ori/";

// chemin du dossier des miniatures (vers lequel sont chargé les fichiers de 100px sur 100px)
            $thumbDest = "img/profil/thumbs/";

// chemin du dossier des grandes images pour la galerie (vers lequel sont chargé les fichiers qui garde les proportions de maximum 800px de large  sur maximum 600px de haut)
            $galleryDest = "img/profil/large/";

// extensions acceptées
            $extAut = [".jpg", ".jpeg"];
            $ext = strrchr($_FILES['uploaded_file']['name'], ".");
            // on met l'extension en minuscule
            $ext = strtolower($ext);
            // on vérifie si l'extension se trouve dans la liste des extensions autorisées
            if (in_array($ext, $extAut)) {

                $name = date("YmdHis") . "-" . mt_rand(1000, 9999);
                // création du nom final
                $finalName = $name . $ext;
                // destination finale
                $finalDestination = $oriDest . "$finalName";
                // déplacement du fichier temporaire vers la destination finale

                $theuser = htmlspecialchars(strip_tags(trim($_POST['theuser'])),ENT_QUOTES);
                move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $finalDestination);
                $sql = "UPDATE theuser SET theimage = '$finalName' WHERE thelogin = '$lelogin'";
                $db->exec($sql);
                // création de l'image de 800 px sur 600 px max avec proportions
                $gd = large($finalName, $galleryDest, $finalDestination, LARGE_WIDTH, LARGE_HEIGHT, QUALITY_JPG_LARGE);
                if ($gd) {
                    thumbs($finalName, $thumbDest, $finalDestination, THUMB_SIZE, QUALITY_JPG_LARGE);
                }
                header("Location: profil.php");
            } else {
                $reponse = "Erreur - Extension \"$ext\" non valide";
            }
        }
        if (!empty($password)) {
            if ($password == $repassword) {
                echo "Mise à jour du profil !";
                $password = htmlspecialchars(strip_tags(trim($password)), ENT_QUOTES);
                $password = sha256($password);
                $sql = $db->exec("UPDATE theuser SET thepwd = '$password' WHERE thelogin = '$lelogin'");
            } else {
                echo "les mots de passes ne sont pas identiques !";
            }

        }
    }if (!empty($color)){
        $sql = "UPDATE theuser SET thecolor = '$color' WHERE thelogin = '$lelogin'";
        $db = $db->exec($sql);
    }
}

/* Fonctions de Romain */

/*  liens cliquables qui s'ouvrent dans une nouvelle fenêtre */

function links($text) {

    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

    if (preg_match($reg_exUrl, $text, $url)) {

        // make the urls hyper links
        return preg_replace($reg_exUrl, '<a href="' . $url[0] . '" rel="nofollow" target="_blank">' . $url[0] . '</a>', $text);
    } else {
        // if no urls in the text just return the text
        return $text;
    }
}

/* Fonction de Romain */
/* image de profil, cliquable zoom */


function large($nom, $destination, $source, $largeurMax, $hauteurMax, $qualite) {
    // on récupère les infos sur la source
    $taille_original = getimagesize($source);
    $largeurOri = $taille_original[0];
    $hauteurOri = $taille_original[1];
    // si l'image est plus petite en hauteur comme en largeur que les dimensions maximales, inutile de redimensionner
    if ($hauteurOri <= $hauteurMax && $largeurOri <= $largeurMax) {
        // taille originale
        $newWidth = $largeurOri;
        $newHeight = $hauteurOri;
    } else {
        // si l'image est en paysage
        if ($largeurOri > $hauteurOri) {
            $ratio = $largeurMax / $largeurOri;
            // nous sommes en portrait ou l'image est carré
        } else {
            $ratio = $hauteurMax / $hauteurOri;
        }
        // valeurs arrondies en pixel
        $newWidth = round($largeurOri * $ratio);
        $newHeight = round($hauteurOri * $ratio);
    }
    // on va créer les copies d'images suivant le type MIME de celles-ci (copier)
    switch ($taille_original['mime']) {
        case "image/jpeg":
        case "image/pjpeg":
            $nouvelle = imagecreatefromjpeg($source);
            break;
        default:
            die("Format de fichier incorrecte");
    }
    // on va créer l'image réceptrice de notre copie avec les dimensions souhaitées (create)
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    // on va "coller" l'image originale dans la nouvelle image
    imagecopyresampled($newImage, $nouvelle, 0, 0, 0, 0, $newWidth, $newHeight, $largeurOri, $hauteurOri);

    // on crée physiquement l'image
    switch ($taille_original['mime']) {
        case "image/jpeg":
        case "image/pjpeg":
            $nouvelle = imagejpeg($newImage, $destination . $nom, $qualite);
            break;
        default:
            die("Format de fichier incorrecte");
    }
    return true;
}

function thumbs($nom, $destination, $source, $taille, $qualite) {

    // on récupère les infos sur la source
    $taille_original = getimagesize($source);
    $largeurOri = $taille_original[0];
    $hauteurOri = $taille_original[1];
    // si l'image est en paysage - on inverse la division ($largeurOri devient $largeurOri) pour que le résultat soit plus grand que la miniature carrée
    if ($largeurOri > $hauteurOri) {
        $ratio = $taille / $hauteurOri;
        $milieuX = round(($largeurOri * $ratio) / 2);
        $milieuY = 0;
        // nous sommes en portrait ou l'image est carré
    } else {
        $ratio = $taille / $largeurOri;
        $milieuX = 0;
        $milieuY = round(($hauteurOri * $ratio) / 2);
    }
    // valeurs arrondies en pixel
    $newWidth = round($largeurOri * $ratio);
    $newHeight = round($hauteurOri * $ratio);
    // on va créer les copies d'images suivant le type MIME de celles-ci (copier)
    switch ($taille_original['mime']) {
        case "image/jpeg":
        case "image/pjpeg":
            $nouvelle = imagecreatefromjpeg($source);
            break;
        default:
            die("Format de fichier incorrecte");
    }
    // on va créer l'image réceptrice de notre copie avec les dimensions souhaitées fixes, par exemple 100 sur 100 (create)

    $newImage = imagecreatetruecolor($taille,$taille);
    // on va "coller" l'image originale dans la nouvelle image
    imagecopyresampled($newImage,$nouvelle,0,0,$milieuX,$milieuY,$newWidth,$newHeight,$largeurOri,$hauteurOri);
    // on crée physiquement l'image
    switch ($taille_original['mime']) {
        case "image/jpeg":
        case "image/pjpeg":
            $nouvelle = imagejpeg($newImage, $destination . $nom, $qualite);
            break;
        default:
            die("Format de fichier incorrecte");
    }
    return true;
}

function thedate($date) {
    // original => return $diff (int) in seconds ($timeSec NOW() - $thedate (a date)
    $timeSec = time();
    $thedate = strtotime($date);
    $diff = $timeSec - $thedate;

    // in seconds
    $minutes = 60;
    $hours = $minutes * 60;
    $days = $hours * 24;
    $weeks = $days * 7;
    $month = $days * 30;
    $years = $month * 12;

    if ($diff > $years):
        $nbYears = floor($diff / $years);
        $nbMonthY = floor(($diff - ($nbYears*$years)) / $month);
        $Syears = ($nbYears > 1) ? "$nbYears years " : "1 year ";
        if($nbMonthY==0) return $Syears." ago";
        return ($nbMonthY>1) ? "$Syears and $nbMonthY months ago" : "$Syears and $nbMonthY month ago";
    endif;
    if ($diff > $month):
        $nbMonth = floor($diff / $month);
        $nbWeeksM = floor(($diff - ($nbMonth*$month)) / $weeks);
        $Smonths = ($nbMonth > 1) ? "$nbMonth months " : "1 month ";
        if($nbWeeksM==0) return $Smonths." ago";
        return ($nbWeeksM>1) ? "$Smonths and $nbWeeksM weeks ago" : "$Smonths and $nbWeeksM week ago";
    endif;
    if ($diff > $weeks):
        $nbWeeks = floor($diff / $weeks);
        $nbDaysW = floor(($diff - ($nbWeeks*$weeks)) / $days);
        $Sweeks = ($nbWeeks > 1) ? "$nbWeeks weeks " : "1 week ";
        if($nbDaysW==0) return $Sweeks." ago";
        return ($nbDaysW>1) ? "$Sweeks and $nbDaysW days ago" : "$Sweeks and $nbDaysW day ago";
    endif;
    if ($diff > $days):
        $nbDays = floor($diff / $days);
        $nbHoursD = floor(($diff - ($nbDays*$days)) / $hours);
        $Sdays = ($nbDays > 1) ? "$nbDays days " : "1 day ";
        if($nbHoursD==0) return $Sdays." ago";
        return ($nbHoursD>1) ? "$Sdays and $nbHoursD hours ago" : "$Sdays and $nbHoursD hour ago";
    endif;
    if ($diff > $hours):
        $nbHours = floor($diff / $hours);
        return ($nbHours > 1) ? "$nbHours hours ago" : "1 hour ago";
    endif;
    if ($diff > $minutes):
        $nbMinutes = floor($diff / $minutes);
        return ($nbMinutes > 1) ? "$nbMinutes minutes ago" : "1 minute ago";
    endif;
    return "less than a minute";

}


/* PAGINATION */

function maPagination($nombre_elements_total, $page_actuelle, $nom_variable_get = "pg", $nb_elements_par_pg = 5) {

    // on calcul ne nb de pages en divisant le nb total par le nombre par page en arrondissant à l'entier supérieur (ceil)
    $nb_pg = ceil($nombre_elements_total / $nb_elements_par_pg);
    // si on a qu'une seule page
    if ($nb_pg < 2) {
        // on renvoie la page 1 non cliquable, ce qui arrête la fonction
        return "<div id='pagination'>page 1</div>";
    }
    // ouverture de la variable de sortie (string)
    $sortie = "<div id='pagination'>";
    // tant qu'on a des pages
    for ($i = 1; $i <= $nb_pg; $i++) {
        // si on est au premier tour de boucle
        if ($i == 1) {
            // si c'est la page actuelle
            if ($page_actuelle == $i) {
                $sortie .= "|<< ";
                $sortie .= "<<&nbsp;&nbsp; ";
                $sortie .= "$i ";
                // retour en arrière pour page 2
            } elseif ($page_actuelle == 2) {
                $sortie .= "<a href='?$nom_variable_get=$i' title='First'>|<<</a> ";
                $sortie .= "<a href='?$nom_variable_get=$i'><<</a>&nbsp;&nbsp; ";
                // pas de variable GET de pagination sur l'accueil
                $sortie .= "<a href='?$nom_variable_get=$i'>$i</a> ";
                // on est sur une autre page
            } else {
                $sortie .= "<a href='?$nom_variable_get=$i' title='First'>|<<</a> ";
                $sortie .= "<a href='?$nom_variable_get=" . ($page_actuelle - 1) . "'><<</a>&nbsp;&nbsp; ";
                // pas de variable GET de pagination sur l'accueil
                $sortie .= "<a href='?$nom_variable_get=$i'>$i</a> ";
            }
            // sinon si on est au dernier tour
        } elseif ($i == $nb_pg) {
            // si c'est la page actuelle
            if ($page_actuelle == $i) {
                $sortie .= "$i ";
                $sortie .= "&nbsp;&nbsp; >> ";
                $sortie .= " >>|";
                // on est sur une autre page
            } else {
                $sortie .= "<a href='?$nom_variable_get=$i'>$i</a> ";
                $sortie .= "&nbsp;&nbsp;<a href='?$nom_variable_get=" . ($page_actuelle + 1) . "'>>></a> ";
                $sortie .= " <a href='?$nom_variable_get=$nb_pg' title='Final'>>>|</a>";
            }
            // sinon (tous les autres tours)
        } else {
            if ($page_actuelle == $i) {
                $sortie .= " $i ";
            } else {
                // affichage de la variable GET et de sa valeur en lien
                $sortie .= "<a href='?$nom_variable_get=$i'>$i</a> ";
            }
        }
    }
    $sortie .= "</div>";
    return $sortie;
}

//fonction de censure
function Censurer($buffer) {

    $buffer = str_replace(array('con ','merde','fils de pute','batard','asshole','salope','pétasse','connard','salaud', 'pd','nique ta mère','connasse','gounafié','négro','bitch','fuck','bite'), '<span style="color: red;"> [Censuré] </span>', $buffer);
    return $buffer;
}


// algorithme pour créer le login si il est occupé
function createFreeLogin($lelogin, $idcible) {
    $vArray = ['Mr.', 'Ms.', '666.', 'Tchat.', 'CF2M.', '2018.'];
    $sortir = "";
    for ($i = 0; $i < 3; $i++) {
        $has = array_rand($vArray);
        $rand = $vArray[$has];
        $sortir .= "<p onclick='document.getElementById(\"$idcible\").value=\"$rand$lelogin\"'>" . $rand . $lelogin . "</p>";
        unset($vArray[$has]);
    }
    return $sortir;
}

// création de la fonction counter ( qui compte le nombre de méssages envoyer

/**
 * @param $db
 * @param $idutil
 */
function counter(PDO $db,int $idutil){


    $sql = "SELECT m.theuser_idutil,COUNT( m.thecontent) FROM themessage AS m WHERE m.theuser_idutil = '$idutil'";
    $recup = $db->query($sql);
    $tabrecup = $recup->fetch(PDO::FETCH_ASSOC);

   
  return $tabrecup['COUNT( m.thecontent)'];
}

// function donner le role
function yourStatus($nm=0){

    $status=""; //votre status
    if($nm <= 5){
        $status="Hello world!";
    }elseif ($nm <= 10){
        $status="Newbie";
    }elseif ($nm <= 50){
        $status="Qualified User";
    }elseif ($nm <= 150){
        $status="Power User";
    }elseif ($nm <= 250){
        $status="Advanced User";
    }elseif ($nm <= 400){
        $status="Proficient User";
    }
  return $status;
}


