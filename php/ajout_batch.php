<?php 
include('../connexion/connexionDB.php');
$reception=$_POST['reception'];

$pos1="|";
$n=strpos($reception,$pos1);
$IDrecep=substr($reception,0,$n); //definir l'id reception
$l=strlen($reception);
$reception=substr($reception,$n+1,$l); //mettre a jour la chaine
$l=strlen($reception);

while($l>1){
	$pos2="*";
	$n=strpos($reception,$pos2);
	$artRecep=substr($reception,0,$n); //tous les cases du paquet
	$reception=substr($reception,$n+2,$l); //mettre a jour la chaine
	////
	$n=strpos($artRecep,$pos1);
    $IDpaquet=substr($artRecep,0,$n); //definir le code paquet
    $l=strlen($artRecep);
    $artRecep=substr($artRecep,$n+1,$l); //mettre a jour la chaine
		
	$l=strlen($artRecep);
    $batch=substr($artRecep,0,$l); //definir la suite
	$l=strlen($reception);
	$sql=mysql_query("UPDATE paquet2 SET batch='$batch' WHERE IDpaquet='$IDpaquet' and idRO='$IDrecep'");
}
$sql6=mysql_query("UPDATE reception_ordre_achat1 SET statut='received' WHERE idRO='$IDrecep'");
echo("../pages/ajout_batch.php");
	
//echo($reception);	
  
?>
