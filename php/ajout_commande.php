<?php
session_start();
include('../connexion/connexionDB.php');
 $po = $_POST['po'];
	$clt= $_POST['client'];
	
	$date_dem_clt = $_POST['date_dem_clt'];
	$date_exp_conf = $_POST['date_exp_conf'];
	$tpay= $_POST['tpay'];
	$dev = $_POST['dev'];
	$pt = $_POST['totalP'];
 $nbr=$_POST['nbr'];
	$qte = $_POST['totalQ'];
	$UPC = $_POST['UPC'];
	 //Priority
    $SQ=mysql_query("SELECT count(PR) FROM commande2 where date_exped='$date_exp_conf'");
	
    $PR=mysql_result($SQ,0);
	$PR++;
	

	if(isset($_POST['chek'])){
	$statut="auto";
	
	}else{
	
	$statut="waiting";
	  
	}
		
$sql = "INSERT INTO commande2(PO,UPC,date_ent_cmd,date_demande_client,date_exped,client,qte_demande,terme_pay,prix_total,devise,PR) 
VALUES  ('$po','$UPC',NOW(),'$date_dem_clt','$date_exp_conf','$clt','$qte','$tpay','$pt','$dev','$PR')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/ajout_commande_no.php?status=fail');
}else{
$i=0;
while($nbr>$i){
$i++;
 $PON="POI".$i;
 $PN="P".$i;
 $PU="PU".$i;
 $QN="Q".$i;
 $PT="PT".$i;

 $v1=$_POST[$PON];
 $v2=$_POST[$PN];
 $v3=$_POST[$PU];
 $v4=$_POST[$QN];
 $v5=$_POST[$PT];

        if($nbr==1){
		$v1=$po;
		}
	$sql=mysql_query("INSERT INTO commande_items(POitem, PO, produit, qty, prixU, prixT,dateExp,statut)
	VALUES ('$v1','$po','$v2','$v4','$v3','$v5','$date_exp_conf','$statut')");
	header('Location: ../pages/ajout_commande.php');
 
}
 
    $userid=$_SESSION['userID'];
	$msg="a ajouté la commande N° <b>".$po."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','commande2','$po',NOW())"); 
}  

?>