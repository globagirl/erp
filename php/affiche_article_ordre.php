<?php 
include('../connexion/connexionDB.php');
$ordre=$_POST['ordre'];
$i=1;
$sql = "SELECT * FROM ordre_achat_article1 where IDordre='$ordre'";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
	$ar="ar"+$i;
	$qtd="qtd"+$i;
	$qtr="qtr"+$i;
	$qtr2="qtR"+$i;
	$idB="b"+$i;
  	echo " Code article   <input type=\"text\" size=\"10 \" name=\"".$ar."\" value=\"".$data['IDarticle']."\"/  READONLY> 
	Quantité demandée <input  type=\"text\" size=\"5 \" name=\"".$qtd."\" value=\"".$data['qte_demande']."\"/  READONLY>
	Quantité reçue  <input type=\"text\" size=\"5 \" id=\"".$qtr."\" name=\"".$qtr."\" value=\"".$data['qte_recue']."\"/  READONLY> 
	*<input type=\"text\" size=\"5 \" id=\"".$qtr2."\" name=\"".$qtr2."\">
	<hr>";
	$i=$i+1;
}
mysql_close();	
?>
	
