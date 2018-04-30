<?php
/**
 * Created by PhpStorm.
 * User: artem.tsymbalov
 * Date: 27/04/2018
 * Time: 15:55
 */
function createKey()
{
    $length = 64;
    $key = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $keyArray = str_split($key);
    $numArray = count($keyArray);
    $string = '';
    for ($i = 0; $i < $length; $i++)
    {
        $string .= $keyArray[rand(0, $numArray-1)];
    }
   return $string;

}
//var_dump(createKey());


function EnvoiConfirmMail() // les variables php du requete
{

    $to = "";  //mail d'utilisateur, qui a fait le registration

    $subject = 'Validez votre inscription sur '; // l'adresse

    $message = "
     <html>
      <head>
       <title>Validez votre inscription sur le Tchat Webdev CF2m 2018!</title>
      </head>
      <body>
       <p>Merci ('variable avec le name de db') pour votre inscription sur le Tchat Webdev CF2m 2018!</p>
       <p>Cliquez sur <a href='' target='_blank'>ce lien</a> pour valider votre compte.</p>
       <p>Si vous ne vous êtes pas inscrit sur notre site, vous pouvez ignorer ce mail!</p>
      </body>
     </html>
     ";

    $from  = 'MIME-Version: 1.0' . "\r\n";
    $from .= 'Content-type: text/html; charset=utf-8' . "\r\n";

    $from .= 'From: ' . "\r\n" . // l'adresse du site
        'Reply-To: ' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    return mail($to, $subject, $message, $from);
}

/*
 * Permet d'insérer un utilisateur dans la table chat18cf2m, renvoie true si ça a fonctionné, false en cas d'échec
 *
 * Create
 *
 */
function newuser($db,$lelogin,$lepwd){
    // vérification de sécurité de $title et $text
    if(empty($lelogin)||empty($lepwd)){
        return false;
    }
    // req sql
    $sql = "INSERT INTO chat18cf2m (thelogin,thepwd) VALUES ('$lelogin','$lepwd');";
    $ajout = mysqli_query($db,$sql);
    // si on a inséré l'article
    if(mysqli_affected_rows($db)){
        return true;
    }
    return false;

}


function traiteChaine($text){
        $text = str_replace(':)', '<img class=emoji src="img/smile.png" alt="smile">', $text);
        $text = str_replace(':-)', '<img class=emoji src="img/smile.png" alt="smile">', $text);
        $text = str_replace(':smile:', '<img class=emoji src="img/smile.png" alt="smile">', $text);
        $text = str_replace(":'(", '<img class=emoji src="img/sad.gif" alt="sad">', $text);
        $text = str_replace(':-(', '<img class=emoji src="img/sad.gif" alt="sad">', $text);
        $text = str_replace(':sad:', '<img class=emoji src="img/sad.gif" alt="sad">', $text);
        $text = str_replace('T_T', '<img class=emoji src="img/sad.gif" alt="sad">', $text);
        $text = str_replace(':nyan:', '<img class=emoji src="img/nyan.gif" alt="nyan">', $text);
        $text = str_replace(':like:', '<img class=emoji src="img/like.gif" alt="like">', $text);
        $text = str_replace('>:(', '<img class=emoji src="img/angry.gif" alt="angry">', $text);
        $text = str_replace(':angry:', '<img class=emoji src="img/angry.gif" alt="angry">', $text);
        $text = str_replace(':wow:', '<img class=emoji src="img/wow.gif" alt="wow">', $text);
        $text = str_replace(':o', '<img class=emoji src="img/wow.gif" alt="wow">', $text);
        $text = str_replace(':laugh:', '<img class=emoji src="img/laugh.gif" alt="laugh">', $text);
        $text = str_replace(':D', '<img class=emoji src="img/laugh.gif" alt="laugh">', $text);
        $text = str_replace(':knuckle:', '<img class=emoji src="img/knuckle.png" alt="knuckle">', $text);
        $text = str_replace(':troll:', '<img class=emoji src="img/troll.png" alt="troll">', $text);
        $text = str_replace(':troll:', '<img class=emoji src="img/troll.png" alt="troll">', $text);
        $text = str_replace(':heart:', '<img class=emoji src="img/heart.gif" alt="heart">', $text);
        $text = str_replace('<3', '<img class=emoji src="img/heart.gif" alt="heart">', $text);
        $text = str_replace(':confused:', '<img class=emoji src="img/confused.png" alt="confused">', $text);
        $text = str_replace('>_<', '<img class=emoji src="img/confused.png" alt="confused">', $text);
        $text = str_replace(':happy:', '<img class=emoji src="img/happy.png" alt="happy">', $text);
        $text = str_replace(':surprised:', '<img class=emoji src="img/surprised.png" alt="surprised">', $text);
        return $text = str_replace(':star:', '<img class=emoji src="img/star.png" alt="star">', $text);
}