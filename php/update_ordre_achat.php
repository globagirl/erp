<?php
session_start();
include('../connexion/connexionDB.php');
 $ord1 =@$_POST['ord1'];
 $four=@$_POST['four'];
 $devise=@$_POST['devise'];
 $dateD =@$_POST['dateD'];
 $pay=@$_POST['pay'];
 $tax=@$_POST['tax'];
 $transport=@$_POST['transport'];
 $pt =@$_POST['prixT'];
 $nbr=@$_POST['nbr'];
	
	

$sql = "UPDATE ordre_achat2 SET date_demand_starz='$dateD',fournisseur='$four',devise='$devise',terme_pay='$pay',prix_total='$pt',tax='$tax',transport='$transport' WHERE IDordre='$ord1'";

if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/update_ordre_achat.php?status=fail');
}else{
$i=0;
while($nbr>$i){
$i++;

$item="item".$i;

$qte="qte".$i;
$prixU="prixU".$i;
$prixT="prixT".$i;
$ordX="ordX".$i;
 $v2=$_POST[$item];
 $vX=$_POST[$ordX];
 $v4=$_POST[$qte];
 $v5=$_POST[$prixT];
 $v6=$_POST[$prixU];

      
	$sql2=mysql_query("UPDATE ordre_achat_article1 SET IDarticle='$v2',qte_demande='$v4',prix_unitaire='$v6',prix_facture='$v6',prix_total='$v5'  WHERE idOA='$vX'");
   // $sql616=mysql_query("UPDATE ordre_prevision SET qty='$v4' WHERE IDordre='$ord1' and IDarticle='$v2'");
}
 
    
	//historique
	$userid=$_SESSION['userID'];
    $msg="a modifié l'ordre d'achat N° <b>".$ord1."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','ordre_achat2','$ord1',NOW())");  
	 header('Location: ../pages/update_ordre_achat.php?status=sent');
}  

?>