<?php
 session_start();
 $IDoperateur=$_SESSION['userID'];
 include('../connexion/connexionDB.php');
 $sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
 $operateur=mysql_result($sqlOP,0);
 $PRD = $_POST['PRD'];
 $nbr = $_POST['nbr'];
 //
    $typeS="Production";
while($nbr>$i){
	$i++;
	$A="A".$i;
	$P="P".$i;
	$Q="Q".$i;
	$vA = $_POST[$A];
    $vP = $_POST[$P];
    $vQ = $_POST[$Q];
	$sql2=mysql_query("INSERT INTO sortie_stock1(IDpaquet,date_sortie,operateur,qte,typeS) VALUES ('$vP',NOW(),'$operateur','$vQ','$typeS')");
	$sqlOF=mysql_query("SELECT qte_res from  paquet2 where IDpaquet='$vP'");
	$qtePaq=mysql_result($sqlOF,0);
	$qtePaqR=$qtePaq-$vQ;
	if(($qtePaqR>0) and ($qtePaqR <1)){
	$qtePaqR=0;
	}
	$sql3=mysql_query("UPDATE paquet2 SET qte_res='$qtePaqR' where IDpaquet='$vP'");
	$sql4=mysql_query("UPDATE article1 SET stock= stock-'$vQ' where code_article='$vA'");
	//historique
	$HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','add','sortie_stock1/paquet','$vP',NOW())");
}
     header('Location: ../pages/sortie_stock2.php?status=sent');
     mysql_close();
?>