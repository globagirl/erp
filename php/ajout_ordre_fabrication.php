<?php 
include('../connexion/connexionDB.php');
$OF=$_POST['OF'];
$PO=$_POST['PO'];
$PRD=$_POST['PRD'];
$nbP=$_POST['nbP']; 
$qteP=$_POST['qteP'];
$qteC=$_POST['qteC']; 
$qteL=$_POST['qteL'];
$planS=$_POST['planS'];
$plan=$_POST['plan'];
$dateE=$_POST['dateE']; 
$dateL=$_POST['dateL'];
$UPC=@$_POST['UPC']; 

$sql ="INSERT INTO ordre_fabrication1 (OF,PO,nbr_plan,produit,qte,date_lance,date_exped_conf) 
VALUES ('$OF','$PO','$nbP','$PRD','$qteP','$dateL','$dateE')";

if (!mysql_query($sql)) {
    die('Error: ' . mysql_error()); 
}
if($planS==0){
	$n=$nbP;
	for ($i=1; $i <= $n; $i++){
        $numPlan = $OF.'-'.$i;
		$sql1=mysql_query("INSERT INTO plan1(numPlan,OF,qte_p) VALUES ('$numPlan','$OF','$plan')");
	}
}else{
	$n=$nbP-1;
	for ($i = 1; $i <= $n; $i++){
        $numPlan = $OF.'-'.$i;
		$sql1=mysql_query("INSERT INTO plan1(numPlan,OF,qte_p) VALUES ('$numPlan','$OF','$plan')");
	}
    $numPlan = $OF.'-'.$i;
	$sql1=mysql_query("INSERT INTO plan1(numPlan,OF,qte_p) VALUES ('$numPlan','$OF','$planS')");
}
$qte=$qteP+$qteL;
if($qteC>$qte){
	$statut='incomplete';
}else{
	$statut='planned';
}

//if UPM3 il ne passe pas par le magazin
/*$sqlP = mysql_query ("SELECT categorie FROM produit1 WHERE code_produit='$PRD'");
$category =@mysql_result($sqlP,0);
if (($category=="UPM 3")|| ($category=="UPM3")){
    $sqlP1=mysql_query("UPDATE ordre_fabrication1 SET statut='in progres'  where OF='$OF'");
    if($statut=='planned'){
        $statut='in progres';
    }
}*/
/// 
$sql11=mysql_query("UPDATE commande_items SET statut='$statut',dateExp='$dateE'  where POitem='$PO'");
$sql12=mysql_query("UPDATE commande2 SET UPC='$UPC',date_exped='$dateE' where PO='$PO'");
header('Location: ../pages/ajout_ordre_fabrication.php');
?>