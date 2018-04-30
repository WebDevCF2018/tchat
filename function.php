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