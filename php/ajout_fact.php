<?php
session_start();
$userid=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$min_bl =$_POST['min_bl'];
$max_bl =$_POST['max_bl'];
$devise=$_POST['devise'];
$termeP=$_POST['tpay'];
for($i = $min_bl; $i<= $max_bl; $i++){
	$sql_fact = mysql_query("SELECT * FROM bon_livr WHERE num_bl='$i'");
	$row=mysql_fetch_array($sql_fact);
	$etat_fact= $row['etat_fact'];
	if($etat_fact=='unbilled'){
	$num_fact=$i;
	//$descrip = $row['descrp'];
	$qte = $row['qtu'];
	$client =  $row['client'];
	$etat= "invoiced";
	$date_fact = $row['date_bl'];
	$date_liv = $row['date_liv'];
	//$date_p = strtotime($date_fact."+ 30 days");
	$val=stristr($termeP," ");
    $date_p = strtotime($date_fact."+ ".$val." days");
    $date_pay= date('Y-m-d',$date_p);	//
	$dateP=strtotime("next Monday",$date_p);
    $dateP= date("Y-m-d",$dateP);
	//$IDpay='PREV'.$dateP;
	//
	$prixT=0;
    $sql = mysql_query("INSERT INTO fact1 (num_fact, date_fact,date_E,client,num_bl,qte,devise,date_pay,termePay)
    VALUES ('$num_fact', NOW(),'$date_fact','$client','$num_fact','$qte','$devise','$date_pay','$termeP')");
    $sq1 = mysql_query("SELECT * FROM bon_livr_items WHERE idBL='$min_bl'");
    while($row1=mysql_fetch_array($sq1)){
        $produit=$row1['IDproduit'];
		$qte=$row1['qty'];
		$PO=$row1['PO'];
		$OF=$row1['OF'];
		$sql2 = mysql_query("SELECT price FROM prices where IDproduit='$produit' and (marginL<= '$qte' and (marginH >= '$qte' or  marginH = '-1'))");
		$PU=mysql_result($sql2,0);
		$PT=$PU*$qte;
		$prixT=$PT+$prixT;
		$sql1 = mysql_query("INSERT INTO fact_items(idF,produit,PO,OF,qty,prixU,prixT )VALUES ('$num_fact','$produit','$PO','$OF','$qte','$PU','$PT')");
		$sql3=mysql_query("SELECT statut from commande_items where POitem='$PO'");
		$stat=mysql_result($sql3,0);
		if($stat=="incomplete"){
	        $statut="incomplete";
        }else{
	        $statut="closed";
	    }
        $sql11=mysql_query("UPDATE commande_items SET statut='$statut' where POitem='$PO'");
    }

    $req= mysql_query("UPDATE fact1 SET tot_val='$prixT' WHERE num_fact=$min_bl");
	$req= mysql_query("UPDATE bon_livr SET etat_fact='$etat' WHERE num_bl=$min_bl");
    //Historique
	$msg="a ajouté la facture N° <b>".$min_bl."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','fature','$min_bl',NOW())");

    }
    $min_bl++;
}
mysql_close();
header('Location: ../pages/ajout_fact.php?status=sent');
?>
