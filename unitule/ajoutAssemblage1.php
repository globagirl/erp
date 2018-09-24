
<?php
session_start ();
include('../connexion/connexionDB.php');
$plan=$_POST['plan'];
$PO=$_POST['PO'];
$OF=$_POST['OF'];
$prd=$_POST['prd'];
$dateH=$_POST['dateH'];
$qtE=$_POST['qtE'];
$qte_p=$_POST['qte_p'];
$IDassemb=$_POST['IDassemb'];

 $sql = mysql_query("INSERT INTO pro_assem (num_ass,plan,PO,date_debut,qte_e) 
VALUES ('$IDassemb','$plan','$PO',CURRENT_TIMESTAMP(),'$qtE')");
$sql2 = mysql_query("UPDATE plan1 SET statut='Debut assemblage' where numPlan='$plan'");
header('Location: ../pages/assemblage.php?status=sent');
 ?>