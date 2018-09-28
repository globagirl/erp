<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 28/09/2018
 * Time: 12:59
 */

//connexion DB
$db="starzcloexerp";
$host="starzcloexerp.mysql.db";
$rt="starzcloexerp";
try{
    $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
    $con=new PDO('mysql: localhost;dbname=starzcloexerp','root','',$pdo_options)
    or die("Erreur de connexion au serveur !!");
}

catch (Exception $e)
{
    die ("Erreur: ".$e->getmessage());
}
?>