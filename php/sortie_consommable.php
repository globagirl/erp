<?php
session_start();
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
$magazigner=mysql_result($sqlOP,0);
$idD=$_POST['idD'];
$nbr=$_POST['nbr'];
$j=0;
while($nbr>$j){
    $j++;
    $cons="C".$j;
    $chek="ch".$j;
    $qtyS="qtyS".$j;
    $CONS=$_POST[$cons];
    $QTY=$_POST[$qtyS];
    if(isset($_POST[$chek])){
        $sql3=mysql_query("UPDATE demande_items SET qtyS='$QTY' WHERE IDconsommable='$CONS' AND IDdemande='$idD'");
        $sql7=mysql_query("UPDATE demande_consommable SET statut='T',dateS=NOW(),magazigner='$magazigner' WHERE IDdemande='$idD'");
        //historique
        $msg2=" has signed the output of <b> ".$QTY." </b> of consumable having the ID <b>".$CONS."</b> , Request ID <b>".$idD."</b>";
        $HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg2','sortie consommable','$idD',NOW())");
    }
}
//Notification
$msg= " ".$magazigner." has accepted your request for consumable N °   ".$idD."";
$sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$magazigner','CONS','$msg',NOW(),'confirmation_recep_cons.php')");
header('Location: ../pages/sortie_consommable.php?status=sent');
?>