<?php
session_start();
include('../connexion/connexionDB.php');
    $num_ord =@$_POST['num_ord'];
	$dateD=@$_POST['dateD'];
	$four =@$_POST['four'];
	$tpay=@$_POST['tpay'];
	$dev =@$_POST['dev'];
	$nbr =@$_POST['nbr'];
	$pt_ordre=@$_POST['total'];
	
    $tax=@$_POST['tax'];
	$transport =@$_POST['transport'];
		
$sql = "INSERT INTO ordre_achat2(IDordre,date_creation,date_demand_starz,fournisseur,prix_total,devise,terme_pay,statut,tax,transport)
 VALUES ('$num_ord',NOW(),'$dateD','$four','$pt_ordre','$dev','$tpay','waiting','$tax','$transport')";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/ajout_ordre_achat.php?status=fail');
}
else{  
  $i=0;

while($nbr>$i){
	    $i++;
        $artN="I".$i;
        $qN="Q".$i;
        $pN="PU".$i;
        $ptN="TP".$i;
	$art=@$_POST[$artN];
	//$art=trim($art);
	$q =@$_POST[$qN];
	$p=@$_POST[$pN];
	$pt =@$_POST[$ptN];
	$art=trim($art," ");
	$sql1 = mysql_query("INSERT INTO ordre_achat_article1(IDordre,IDarticle,qte_demande,prix_unitaire,prix_facture,prix_total,statut) 
	VALUES ('$num_ord','$art','$q','$p','$p','$pt','waiting')");
	
	 }
 	 
    
	$userid=$_SESSION['userID'];
    $msg="a ajouté l'ordre d'achat N° <b>".$num_ord."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','ordre_achat2','$num_ord',NOW())"); 
    header('Location: ../pages/ajout_ordre_achat.php?status=sent');	
} 

mysql_close();

?>