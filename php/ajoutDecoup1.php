
<?php
session_start ();
include('../connexion/connexionDB.php');
$plan=$_POST['plan'];
$OF=$_POST['OF'];
$PO=$_POST['PO'];
$qteP=$_POST['qteP'];
$qteE=$_POST['qteE'];
$dateH=$_POST['dateH'];
$PRD=$_POST['PRD'];
$IDdecoup=$_POST['IDdecoup'];
$_SESSION['IDdecoup'] = $IDdecoup;

$sql = mysql_query("INSERT INTO decoup (num_decoupage,plan,PO,date_debut,qte_e)VALUES ('$IDdecoup','$plan','$PO',CURRENT_TIMESTAMP(),'$qteE')");
$sql2 = mysql_query("UPDATE plan1 SET date_debut=CURRENT_TIMESTAMP(),statut='Debut decoupage' where numPlan='$plan'");
mysql_close();
header('Location: ../pages/decoupage_fin.php?status=sent');

//echo($stat);
 ?>