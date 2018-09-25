<?php
 session_start();
 $IDoperateur=$_SESSION['userID'];
 include('../connexion/connexionDB.php');
 $sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
 $operateur=mysql_result($sqlOP,0);
 $PO = $_POST['PO'];
 $OF = $_POST['OF'];
 $PRD = $_POST['PRD'];
 $nbr = $_POST['nbr'];
 //
$sqlPO=mysql_query("SELECT PO from commande_items where POitem='$PO'");
$PO1=mysql_result($sqlPO,0);
$sql=mysql_query("SELECT statut from commande_items where POitem='$PO'");
$stat=mysql_result($sql,0);
if($stat=="incomplete"){
	$statut="incomplete";
}else{
	$statut="in progres";
}	
	$sql =mysql_query("UPDATE commande_items SET statut='$statut'  where POitem='$PO'"); 	 
	$sqlPO2 =mysql_query("UPDATE commande2 SET col='#E3E3E3'  where PO='$PO1'"); 	 
    $sql11 =mysql_query("UPDATE ordre_fabrication1 SET statut='in progres' where OF='$OF'"); 
    $sql12 =mysql_query("UPDATE plan1 SET statut='waiting' where OF='$OF'"); 
    //$typeS="Production";
while($nbr>$i){
	$i++;
	$A="A".$i;
	$P="P".$i;
	$Q="Q".$i;
	$vA = $_POST[$A];
    $vP = $_POST[$P];
    $vQ = $_POST[$Q];
	$sql2=mysql_query("INSERT INTO sortie_stock1(IDpaquet,commande,OF,date_sortie,operateur,qte,typeS) VALUES ('$vP','$PO','$OF',NOW(),'$operateur','$vQ','P')");
	$sqlOF=mysql_query("SELECT qte_res from  paquet2 where IDpaquet='$vP'");
	$qtePaq=mysql_result($sqlOF,0);
	$qtePaqR=$qtePaq-$vQ;
	if(($qtePaqR>0) and ($qtePaqR <1)){
	$qtePaqR=0;
	}
	$sql3=mysql_query("UPDATE paquet2 SET qte_res='$qtePaqR' where IDpaquet='$vP'");
	$sql4=mysql_query("UPDATE article1 SET stock= stock-'$vQ' where code_article='$vA'");
	//historique
	  $msg=" a saisie la sortie de <b> ".$vQ." </b> du paquet N°  <b>".$vP."</b>";
	$HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','sortie_stock1/paquet','$vP',NOW())");
}
     mysql_close();
     header('Location: ../pages/sortie_stock.php?status=sent');
?>