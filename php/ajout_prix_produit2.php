<?php
session_start ();
include('../connexion/connexionDB.php');
$PRD=@$_POST['produit'];

$nbr=@$_POST['nbr'];

$i=0;
$sql = mysql_query("DELETE FROM prices WHERE IDproduit='$PRD'");
   while($i<$nbr){
	   $i++;
	   $mL="mL".$i;
	   $mH="mH".$i;
	   $prix="P".$i;
	
	   $L=$_POST[$mL];
	   $H=$_POST[$mH];
	   $P=$_POST[$prix];
	 
	$sql = mysql_query("INSERT INTO prices(IDproduit, marginL, marginH, price) VALUES ('$PRD','$L','$H','$P')");
   } 
 //historique
 $IDoperateur=$_SESSION['userID'];
     $HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','add','prices','$PRD',NOW())"); 
	   //

   header('Location: ../pages/ajout_prix_produit2.php?status=sent');
   
 //  echo($nbr);
?>