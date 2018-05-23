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
function newuser($db, $lelogin, $lepwd, $themail) {
    // vérification de sécurité de $title et $text
    if (empty($lelogin) || empty($lepwd)) {
        return false;
    }
    $lepwd = sha256($lepwd);
    $thekey = createKey();
    // req sql
    $sql = "INSERT INTO theuser (thelogin,thepwd,themail,thekey) VALUES ('$lelogin','$lepwd','$themail','$thekey');";
    $ajout = mysqli_query($db, $sql);
    if (mysqli_error($db)) {
        header("Location: ./?p=inscription&error=$lelogin");
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
    $text = str_replace(':)', '<img class="emoji" src="img/icones/smile.png" alt="smile" title=":smile:">', $text);
    $text = str_replace(':-)', '>', $text);
    $text = str_replace(':smile:', '<img class="emoji" src="img/icones/smile.png" alt="smile" title=":smile:">', $text);
    $text = str_replace(":'(", '<img class="emoji" src="img/icones/sad.gif" alt="sad" title=":sad:">', $text);
    $text = str_replace(':-(', '>', $text);
    $text = str_replace(':sad:', '<img class="emoji" src="img/icones/sad.gif" alt="sad" title=":sad:">', $text);
    $text = str_replace('T_T', '<img class="emoji" src="img/icones/sad.gif" alt="sad" title="sad">', $text);
    $text = str_replace(':nyan:', '<img class="emoji" src="img/icones/nyan.gif" alt="nyan" title=":nyan:">', $text);
    $text = str_replace(':like:', '<img class="emoji" src="img/icones/like.gif" alt="like" title=":like:">', $text);
    $text = str_replace('>:(', '<img class="emoji" src="img/icones/angry.gif" alt="angry" title=":angry:">', $text);
    $text = str_replace(':angry:', '<img class="emoji" src="img/icones/angry.gif" alt="angry" title=":angry:">', $text);
    $text = str_replace(':wow:', '<img class="emoji" src="img/icones/wow.gif" alt="wow" title=":wow:">', $text);
    $text = str_replace(':o', '<img class="emoji" src="img/icones/wow.gif" alt="wow" title=":wow:">', $text);
    $text = str_replace(':laugh:', '<img class="emoji" src="img/icones/laugh.gif" alt="laugh" title=":laugh:">', $text);
    $text = str_replace(':D', '<img class="emoji" src="img/icones/laugh.gif" alt="laugh" title=":laugh:">', $text);
    $text = str_replace(':knuckle:', '<img class="emoji" src="img/icones/knuckle.png" alt="knuckle" title=":knuckle:">', $text);
    $text = str_replace(':troll:', '<img class="emoji" src="img/icones/troll.png" alt="troll" title=":troll:">', $text);
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
    $colorArray = ['#660000', '#FF6600', '#CC3300', '#FF0000', '#990033', '#330000', '#FF0066', '#CC0099', '#6600FF', '#000033', '#00CCFF', '#003333', '#00CCCC', '#330033', '#99CCCC', '#009999', '#33FFCC', '#339966', '#66FF00', '#003300', '#CCFF00', '#CCCC99', '#333300', '#999966', '#333333', '#9966CC', '#CCCC00', '#FF6699', '#3399CC'];
    ;
    $thecolor = $colorArray[mt_rand(0, count($colorArray) - 1)];
    $sql = "UPDATE theuser SET thecolor = '$thecolor' WHERE idutil = $idutil";
    mysqli_query($db, $sql) or die(mysqli_error($db));
}
function infoUser($db, $lelogin) {
    $sql = "SELECT thelogin,themail,theimage FROM theuser WHERE thelogin= '$lelogin';";
    $recupLogin = mysqli_query($db, $sql) or die(mysqli_error($db));
    return mysqli_fetch_assoc($recupLogin);
}
function updateUser($db, $lelogin, $password, $repassword) {
    if (isset($_POST["submit"])) {
        if (!empty($_FILES['uploaded_file']) && empty($password)) {
            $path = "img/";
            $path = $path . basename($_FILES['uploaded_file']['name']);
            if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
                echo "Mise à jour du profil !";
                $theimage = basename($_FILES['uploaded_file']['name']);
                $sql = "UPDATE theuser SET theimage = '$theimage' WHERE thelogin = '$lelogin'";
                $query = mysqli_query($db, $sql) or die(mysqli_error($db));
            } else {
                echo "erreur d'upload !";
            }
        } else if (!empty($password) && empty($_FILES['uploaded_file'])) {
            if ($password == $repassword) {
                echo "Mise à jour du profil !";
                $password = htmlspecialchars(strip_tags(trim($password)), ENT_QUOTES);
                $password = sha256($password);
                $sql = "UPDATE theuser SET thepwd = '$password' WHERE thelogin = '$lelogin'";
                $query = mysqli_query($db, $sql) or die(mysqli_error($db));
            } else {
                echo "les mots de passes ne sont pas identiques !";
            }
        } else if (!empty($_FILES['uploaded_file']) && !empty($password)) {
            if ($password == $repassword) {
                $password = htmlspecialchars(strip_tags(trim($password)), ENT_QUOTES);
                $password = sha256($password);
                $sql = "UPDATE theuser SET thepwd = '$password', theimage = '$theimage' WHERE thelogin = '$lelogin'";
                $query = mysqli_query($db, $sql) or die(mysqli_error($db));
                $path = "img/";
                $path = $path . basename($_FILES['uploaded_file']['name']);
                if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
                    echo "Mise à jour du profil";
                } else {
                    echo "erreur d'upload !";
                }
            } else {
                echo "les mots de passes ne sont pas identiques !";
            }
        }
    }
}
/* Fonctions de Romain */
/*  liens cliquables qui s'ouvrent dans une nouvelle fenêtre */
function links($text)
{
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
function large($nom,$destination,$source,$largeurMax,$hauteurMax,$qualite){
    // on récupère les infos sur la source
    $taille_original = getimagesize($source);
    $largeurOri = $taille_original[0];
    $hauteurOri = $taille_original[1];
    // si l'image est plus petite en hauteur comme en largeur que les dimensions maximales, inutile de redimensionner
    if($hauteurOri<=$hauteurMax && $largeurOri<=$largeurMax){
        // taille originale
        $newWidth = $largeurOri;
        $newHeight = $hauteurOri;
    }else{
        // si l'image est en paysage
        if($largeurOri>$hauteurOri){
            $ratio = $largeurMax/$largeurOri;
            // nous sommes en portrait ou l'image est carré
        }else{
            $ratio = $hauteurMax/$hauteurOri;
        }
        // valeurs arrondies en pixel
        $newWidth = round($largeurOri*$ratio);
        $newHeight = round($hauteurOri*$ratio);
    }
    // on va créer les copies d'images suivant le type MIME de celles-ci (copier)
    switch($taille_original['mime']){
        case "image/jpeg":
        case "image/pjpeg":
            $nouvelle = imagecreatefromjpeg($source);
            break;
        default:
            die("Format de fichier incorrecte");
    }
    // on va créer l'image réceptrice de notre copie avec les dimensions souhaitées (create)
    $newImage = imagecreatetruecolor($newWidth,$newHeight);
    // on va "coller" l'image originale dans la nouvelle image
    imagecopyresampled($newImage,$nouvelle,0,0,0,0,$newWidth,$newHeight,$largeurOri,$hauteurOri);
    // on crée physiquement l'image
    switch($taille_original['mime']){
        case "image/jpeg":
        case "image/pjpeg":
            $nouvelle = imagejpeg($newImage,$destination.$nom,$qualite);
            break;
        default:
            die("Format de fichier incorrecte");
    }
    return true;
}
function thumbs($nom,$destination,$source,$taille,$qualite){
    // on récupère les infos sur la source
    $taille_original = getimagesize($source);
    $largeurOri = $taille_original[0];
    $hauteurOri = $taille_original[1];
    // si l'image est en paysage - on inverse la division ($largeurOri devient $largeurOri) pour que le résultat soit plus grand que la miniature carrée
    if($largeurOri>$hauteurOri){
        $ratio = $taille/$hauteurOri;
        $milieuX = round(($largeurOri*$ratio)/2);
        $milieuY = 0;
        // nous sommes en portrait ou l'image est carré
    }else{
        $ratio = $taille/$largeurOri;
        $milieuX = 0;
        $milieuY = round(($hauteurOri*$ratio)/2);
    }
    // valeurs arrondies en pixel
    $newWidth = round($largeurOri*$ratio);
    $newHeight = round($hauteurOri*$ratio);
    // on va créer les copies d'images suivant le type MIME de celles-ci (copier)
    switch($taille_original['mime']){
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
    switch($taille_original['mime']){
        case "image/jpeg":
        case "image/pjpeg":
            $nouvelle = imagejpeg($newImage,$destination.$nom,$qualite);
            break;
        default:
            die("Format de fichier incorrecte");
    }
    return true;
}
function thedate($date)
{
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
        return ($nbYears > 1) ? "$nbYears years ago" : "1 year ago";
    endif;
    if ($diff > $month):
        $nbMonth = floor($diff / $month);
        return ($nbMonth > 1) ? "$nbMonth months ago" : "1 month ago";
    endif;
    if ($diff > $weeks):
        $nbWeeks = floor($diff / $weeks);
        return ($nbWeeks > 1) ? "$nbWeeks weeks ago" : "1 week ago";
    endif;
    if ($diff > $days):
        $nbDays = floor($diff / $days);
        return ($nbDays > 1) ? "$nbDays days ago" : "1 day ago";
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
    /* $timeSec = time();
      $date = strtotime($date);
      $diff = $timeSec - $date;
      if ($diff >= 31536000) {
      return "il y a " .  date('Y', $diff) . " ans";
      } elseif ($diff >= 2629738){
      return "il y a " . date('M', $diff) . " mois";
      } elseif ($diff >= 86400) {
      return "il y a " .  date('d', $diff) . " jours";
      } elseif ($diff >= 3600) {
      return "il y a " . date('H', $diff) . " heures";
    }else{
        echo "il y a moins d'une minute";
      }elseif ($diff >= 60){
      return "il y a " . date('i', $diff) . " minutes";
      }else{
      return "il y a moin d'une minute";
      } */
}
/* PAGINATION */
function maPagination($nombre_elements_total, $page_actuelle, $nom_variable_get = "pg", $nb_elements_par_pg = 5)
{
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
    // Ici c'est notre fonction qui sera appelée avec ob_end_flush().
    $buffer = str_replace(array('con ','merde','fils de pute','batard','asshole','salope','pétasse','connard','salaud', ' pd','nique ta mère','connasse','gounafié','négro','bitch','fuck',' bite'), '<span style="color: red;"> [Censuré] </span>', $buffer);
    return $buffer;
}
// algorithme pour créer le login si il est occupé
function createFreeLogin($lelogin,$idcible){
    $vArray = ['Mr.', 'Ms.', '666.', 'Tchat.', 'CF2M.', '2018.'];    $sortir = "";
    for($i=0;$i<3;$i++ ){
        $has = array_rand($vArray);
        $rand = $vArray[$has];
        $sortir.="<p onclick='document.getElementById(\"$idcible\").value=\"$rand$lelogin\"'>".$rand.$lelogin."</p>";
        unset($vArray[$has]);
    }
    return $sortir;
}