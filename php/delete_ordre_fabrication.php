<?php
session_start();
include('../connexion/connexionDB.php');
$userid=$_SESSION['userID'];
$OF=$_POST['OF'];
$PO=$_POST['PO'];

$sq="DELETE FROM plan1 where OF='$OF'";
if (!mysql_query($sq)) {
    die('Error: ' . mysql_error()); 
    header('Location: ../pages/delete_ordre_fabrication.php?status=fail');
}else{
    $sq2="DELETE FROM ordre_fabrication1 WHERE OF='$OF'";
	if (!mysql_query($sq2)) {
        die('Error: ' . mysql_error()); 
        header('Location: ../pages/delete_ordre_fabrication.php?status=fail');
    }else{
        $sql=mysql_query("SELECT statut from commande_items where POitem='$PO'");
		$statut=mysql_result($sql,0);
		if($statut=="planned"){
            $sql1=mysql_query("UPDATE commande_items SET statut='waiting' WHERE POitem='$PO'");
        }
       //Historique
       $msg="a supprimé l'ordre de fabrication  N° <b>".$OF."</b>";
       $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','ordre_fabrication','$OF',NOW())");  
       header('Location: ../pages/delete_ordre_fabrication.php?status=sent');
	}
}
?>