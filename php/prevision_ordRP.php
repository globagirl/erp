<?php
include('../connexion/connexionDB.php');
$num=@$_POST['num'];
$qte=@$_POST['qte'];
$dateN=@$_POST['dateN'];
$sq=mysql_query("SELECT * FROM po_prevision where num='$num'");
$A1=mysql_fetch_object($sq);
$PO=$A1->po;
$item=$A1->item;
$sql=mysql_query("Update ordre_prevision set statut='RP',qty= qty-'$qte',dateP='$dateN'where IDordre='$PO' and IDarticle='$item'");
echo 0;
?>