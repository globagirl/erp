<?php
 session_start();
 $IDoperateur=$_SESSION['userID'];
 include('../connexion/connexionDB.php');
 $sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
 $operateur=mysql_result($sqlOP,0);
 $PO = $_POST['PO'];
 $demande = $_POST['demande'];
 $PRD = $_POST['prd'];
 $nbr = $_POST['nbr'];
 ////		

    $typeS="relance";
	
	$sql11 =mysql_query("UPDATE demande_relance SET statut='S' , magazigner='$operateur' where IDrelance='$demande' "); 
while($nbr>$i){
	$i++;
	$A="A".$i;
	$P="P".$i;
	$Q="Q".$i;
	$vA = $_POST[$A];
    $vP = $_POST[$P];
    $vQ = $_POST[$Q];
	$sql2=mysql_query("INSERT INTO sortie_stock1(IDpaquet,commande,IDrelance,date_sortie,operateur,qte,typeS) VALUES ('$vP','$PO','$demande',NOW(),'$operateur','$vQ','$typeS')");
	
	$sql3=mysql_query("UPDATE paquet2 SET qte_res= qte_res-'$vQ' where IDpaquet='$vP'");
	$sql4=mysql_query("UPDATE article1 SET stock= stock-'$vQ' where code_article='$vA'");
	//historique
	$HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','add','sortie_relance/paquet','$vP',NOW())"); 
	//
}	


     header('Location: ../pages/relance_sortie.php?status=sent');
  

?>