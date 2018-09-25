<?php
session_start();
include('../connexion/connexionDB.php');
$IDoperateur=$_SESSION['userID'];
$sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
$user=mysql_result($sqlOP,0);
$po1 = $_POST['PO1'];
$po = $_POST['PO'];
$UPC = $_POST['UPC'];
$clt= $_POST['client'];
$dateD = $_POST['dateD'];
$dateE = $_POST['dateE'];
$pay= $_POST['pay'];
$devise= $_POST['devise'];
$pt = $_POST['prixT'];
$nbr=$_POST['nbr'];
$qty = $_POST['qtyT'];
$sql = "UPDATE commande2 SET PO='$po',UPC='$UPC',date_demande_client='$dateD',date_exped='$dateE',client='$clt',qte_demande='$qty',terme_pay='$pay',prix_total='$pt',devise='$devise' WHERE PO='$po1'";
if (!mysql_query($sql)) {
    die('Error: ' . mysql_error());
    header('Location: ../pages/update_commande.php?status=fail');
}else{
    $i=0;
    while($nbr>$i){
        $i++;
        $POI="poI".$i;
        $item="item".$i;
        $r="r".$i;
        $qte="qte".$i;
        $stat="S".$i;
        $prixU="prixU".$i;
        $prixT="prixT".$i;
        $v1=$_POST[$POI];
        $v2=$_POST[$item];
        $v3=$_POST[$r];
        $v4=$_POST[$qte];
        $v5=$_POST[$prixT];
        $v6=$_POST[$prixU];
        $statut=$_POST[$stat];
        if($nbr==1){
            $poI=$po;
        }else{
            $poI=$po."-".$i;
        }
        $sql2=mysql_query("UPDATE commande_items SET POitem='$v1',produit='$v2',qty='$v4',prixU='$v6',prixT='$v5'  WHERE PO='$poI'");
        if($statut=='planned'){
            $msg= " ".$user ."  a modifié le PO  ".$v1." veillez verifier vos PLANS SVP !! ";
            $sql3=mysql_query("UPDATE ordre_fabrication1 SET produit='$v2',qte='$v4' WHERE PO='$v1'");
            $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$user','LOG','$msg',NOW(),'update_ordre_fabrication.php')");
        }else if($statut=='unbilled'){
            $sql33=mysql_query("select idBL from bon_livr_items where PO='$v1'");
            $BL=mysql_result($sql33,0);
            $sql3=mysql_query("UPDATE bon_livr SET client='$clt' WHERE num_bl='$BL'");
        }else if($statut=='closed'){
            $sql33=mysql_query("select idF from fact_items where PO='$v1'");
            $num_fact=mysql_result($sql33,0);
            $sql3=mysql_query("UPDATE bon_livr SET client='$clt' WHERE num_bl='$num_fact'");
            $sql4=mysql_query("UPDATE fact1 SET devise='$devise',client='$clt' WHERE num_fact='$num_fact'");
        }
    }
    header('Location: ../pages/update_commande.php?status=sent');
    //historique
    $msg2="a modifié la commande N° <b>".$po."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg2','commande','$po',NOW())");
}
mysql_close();
?>