<?php
session_start();
include('../connexion/connexionDB.php');
$BL=$_POST['BL'];
//$adL=$_POST['adL'];
//$adF=$_POST['adF'];
$client=$_POST['client'];
$nbr=$_POST['nbr'];

$sql = mysql_query("INSERT INTO bon_livr (num_bl, date_bl,client,etat_fact)
VALUES ('$BL',NOW(),'$client','unbilled')");

$i=0;
$qteT=0;
$boxT=0;
//$prixT=0;
while($nbr>$i){
$i++;

$O="OF".$i;
$B="BOX".$i;
$P="PO".$i;
$vO=$_POST[$O];
if($vO != ""){
$OF=$_POST[$O];
$box=$_POST[$B];
$boxT=$box+$boxT;
$sql = mysql_query("SELECT * FROM ordre_fabrication1 where OF='$OF'");
$data=mysql_fetch_array($sql);
$PO=$data['PO'];
$produit=$data['produit'];
$qte=$data['qte'];
$qteT=$qteT+$qte;
$dateEX=$data['date_exped_conf'];

$date_pay = strtotime($data['date_exped_conf']."+ 7 days");
$dateCL= date('Y-m-d', $date_pay);
$BLX=$BL."B".$i;
$sql1 = mysql_query("INSERT INTO bon_livr_items(idBLI,idBL,IDproduit, PO, OF, qty,box)
VALUES ('$BLX','$BL','$produit','$PO','$OF','$qte','$box')");
$sql=mysql_query("SELECT statut from commande_items where POitem='$PO'");
$stat=mysql_result($sql,0);
if($stat=="incomplete"){
	$statut="incomplete";
}else{
	$statut="unbilled";
	}
$sql11=mysql_query("UPDATE commande_items SET statut='$statut' where POitem='$PO'");
$sql11=mysql_query("UPDATE ordre_fabrication1 SET statut='closed' where OF='$OF'");
$sql11=mysql_query("UPDATE bon_livr SET date_bl='$dateEX',date_liv='$dateCL',nbr_box='$boxT',qtu='$qteT' where num_bl='$BL'");


}else{
$PO=$_POST[$P];
$box=$_POST[$B];
$boxT=$box+$boxT;
$sql = mysql_query("SELECT * FROM commande_items where POitem='$PO'");
$data=mysql_fetch_array($sql);
$POG=$data['PO'];
$sqlG=mysql_query("select * from commande2 where PO='$POG'");
$dataG=mysql_fetch_array($sqlG);
$produit=$data['produit'];
$qte=$data['qty'];
$qteT=$qteT+$qte;
$dateEX=$dataG['date_exped'];

$dateCL= $dataG['date_demande_client'];
$BLX=$BL."B".$i;
$sql1 = mysql_query("INSERT INTO bon_livr_items(idBLI,idBL,IDproduit, PO, qty, box)
VALUES ('$BLX','$BL','$produit','$PO','$qte','$box')");
$sql11=mysql_query("UPDATE bon_livr SET date_bl='$dateEX',date_liv='$dateCL',nbr_box='$boxT',qtu='$qteT' where num_bl='$BL'");
}

}
//Historique
    $userid=$_SESSION['userID'];
	$msg="a ajouté le bon de livraison  N° <b>".$BL."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','bon livraison','$BL',NOW())");
//Close BD
mysql_close();
//redirection
header('Location: ../pages/ajout_BL.php?status=sent');

?>
