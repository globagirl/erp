
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
$IDupmCUT=substr($valeur,0,$n); //definir le IDdecoup
$_SESSION['IDupmCUT'] = $IDupmCUT;
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
 $sql = mysql_query("INSERT INTO upm_cutting (id_cut,plan,PO,date_debut,qte_e) 
VALUES ('$IDupmCUT','$plan','$PO','$dateH','$qtE')");
$sql11=mysql_query("UPDATE commande2 SET statut='in progres' where PO='$PO'");
$sql12=mysql_query("UPDATE ordre_fabrication1 SET statut='in progres' where PO='$PO'");
$sql13=mysql_query("UPDATE plan1 SET date_debut='$dateH' where numPlan='$plan'");
echo("../pages/upm_cutting.php");
 ?>