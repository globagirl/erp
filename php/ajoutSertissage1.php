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
$IDsert=substr($valeur,0,$n); //definir le IDdecoup
$_SESSION['IDsert'] = $IDsert;
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
 $sql = mysql_query("INSERT INTO pro_sertiss (num_sert,plan,PO,date_debut,qte_e) 
VALUES ('$IDsert','$plan','$PO',CURRENT_TIMESTAMP(),'$qtE')");
$sql2 = mysql_query("UPDATE plan1 SET statut='Debut sertissage' where numPlan='$plan'");
mysql_close();
echo("../pages/sertissage_fin.php");
 ?>