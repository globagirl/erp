<?php 
include('../connexion/connexionDB.php');
    $OF = $_POST['OF'];
    $nbr =@$_POST['nbr'];
    $PO = $_POST['PO'];
	$PRD= $_POST['PRD'];
	$qte= $_POST['qte'];
	$dateL = $_POST['dateL'];
	$dateE = $_POST['dateE'];
	$statut=$_POST['statutPO'];
	
	
    


$sql="DELETE FROM plan1 where OF='$OF'";
if (!mysql_query($sql)) {
  $sqlUP = mysql_query("UPDATE ordre_fabrication1 SET date_lance='$dateL',date_exped_conf='$dateE' WHERE OF='$OF'");
   
}else{
  $sql1 =mysql_query("SELECT taille_lot FROM produit1 where code_produit='$PRD'");
  $tlots=mysql_result($sql1,0);
//Update des plans 
$cmdcal=$qte;
                         if($cmdcal>$tlots){						
								if (($cmdcal%$tlots)==0)
								{
								$divs = $cmdcal/$tlots;
								$totale = $divs;
								$plan=$tlots;
								$planS=0;
								
								}
								else 
								{
								$divs = $cmdcal/$tlots;
								$totale = intval($divs);
								$totale++;
								$planS=$cmdcal%$tlots;
								$plan=$tlots;
								}
								}
								else{
									$totale=1;
									$plan=$cmdcal;
									$planS=0;
								}

if($planS==0){
	$n=$totale;
	for ($i=1; $i <= $n; $i++){

    $numPlan = $OF.'-'.$i;
	$sql1=mysql_query("INSERT INTO plan1(numPlan,OF,qte_p) VALUES ('$numPlan','$OF','$plan')");
	}
}
else{
	$n=$totale-1;
	for ($i = 1; $i <= $n; $i++){

    $numPlan = $OF.'-'.$i;
	$sql1=mysql_query("INSERT INTO plan1(numPlan,OF,qte_p) VALUES ('$numPlan','$OF','$plan')");
	}
    $numPlan = $OF.'-'.$i;
	$sql1=mysql_query("INSERT INTO plan1(numPlan,OF,qte_p) VALUES ('$numPlan','$OF','$planS')");
}

if($statut != "OK"){
$sql1=mysql_query("UPDATE commande_items SET statut='$statut' WHERE POitem='$PO'");
}

$sqlUP = mysql_query("UPDATE ordre_fabrication1 SET qte='$qte',date_lance='$dateL',date_exped_conf='$dateE',nbr_plan='$totale' WHERE OF='$OF'");


}
mysql_close();
header('Location: ../pages/update_ordre_fabrication.php');
//echo($va);	
  
?>