<?php
session_start ();
include('../connexion/connexionDB.php');
$valeur=$_POST['valeur'];

$pos1="|";
$n=strpos($valeur,$pos1);
$plan=substr($valeur,0,$n); //definir le plan
$l=strlen($valeur);
$valeur=substr($valeur,$n+1,$l); //mettre a jour la chaine

$n=strpos($valeur,$pos1);
$IDupmPLG=substr($valeur,0,$n); //definir le IDdecoup
$_SESSION['IDupmPLG'] = $IDupmPLG;
$l=strlen($valeur);
$valeur=substr($valeur,$n+1,$l); //mettre a jour la chaine

$n=strpos($valeur,$pos1);
$dateH=substr($valeur,0,$n); //definir la date & l'heure
$l=strlen($valeur);
$valeur=substr($valeur,$n+1,$l); //mettre a jour la chaine

$n=strpos($valeur,$pos1);
$PO=substr($valeur,0,$n); //definir le PO
$l=strlen($valeur);
$valeur=substr($valeur,$n+1,$l); //mettre a jour la chaine


 $qtE=$valeur;//definir la quantité entrée
 $sql = mysql_query("INSERT INTO upm_plug_insertion (id_plg,plan,PO,date_debut,qte_e) 
VALUES ('$IDupmPLG','$plan','$PO','$dateH','$qtE')");
echo("../pages/upm_plug_ins.php");
 ?>