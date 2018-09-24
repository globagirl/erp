<?php
session_start ();
include('../connexion/connexionDB.php');
$PRD=$_SESSION['PRD'];
$mLX=@$_POST['mLX'];
$PX=@$_POST['PX'];
$nbr=@$_POST['nbr'];
$i=0;

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
   $sql = mysql_query("INSERT INTO prices(IDproduit, marginL, marginH, price) VALUES ('$PRD','$mLX','-1','$PX')");
   unset($_SESSION['PRD']);
   header('Location: ../pages/ajout_produit.php?status=sent');
?>