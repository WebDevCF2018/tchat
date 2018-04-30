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