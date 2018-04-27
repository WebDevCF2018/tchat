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