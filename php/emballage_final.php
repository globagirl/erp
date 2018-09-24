<?php
include('../connexion/connexionDB.php');
$OF=$_POST['OF'];
$QTY=$_POST['qte'];
$etat=$_POST['etat'];
$recue=$_POST['recue'];
$retour=$_POST['retour'];
$sql=mysql_query("select PO from ordre_fabrication1 where OF='$OF'");
$PO=@mysql_result($sql,0);
$sql2=mysql_query("INSERT INTO pro_emb_fin(PO,OF,statut,qte,qte_recue,qte_retour,dateE) VALUES ('$PO','$OF','$etat','$QTY','$recue','$retour',NOW())");
header('Location: ../pages/emballage_final.php?status=sent');									
?>