<?php
session_start();
include('../connexion/connexionDB.php');
$IDoperateur=$_SESSION['userID'];
$OF = $_POST['OF'];
$nbr = $_POST['nbr'];
$PO = $_POST['PO'];
$PRD= $_POST['PRD'];
$qte= $_POST['qte'];
$dateL = $_POST['dateL'];
$dateE = $_POST['dateE'];
$statut=$_POST['statutPO'];
$sql = "UPDATE ordre_fabrication1 SET qte='$qte',date_lance='$dateL',date_exped_conf='$dateE' WHERE OF='$OF'";
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
    header('Location: ../pages/update_ordre_fabrication.php?status=fail');
}else{
    if($statut != "OK"){
        $sql1=mysql_query("UPDATE commande_items SET statut='$statut' WHERE POitem='$PO'");
    }
    $sql11=mysql_query("UPDATE commande_items SET dateExp='$dateE'  where POitem='$PO'");
    $sql12=mysql_query("UPDATE commande2 SET date_exped='$dateE' where PO='$PO'");
    $i=0;
    while($nbr>$i){
        $i++;
        $p="P".$i;
        $q="q".$i;
        $v2=$_POST[$q];
        $v1=$_POST[$p];
        $sql2=mysql_query("UPDATE plan1 SET qte_p='$v2' WHERE numPlan='$v1'");
    }
    //historique
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','update','ordre fabrication','$OF',NOW())");
    header('Location: ../pages/update_ordre_fabrication.php?status=sent');
}
?>