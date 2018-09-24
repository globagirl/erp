<?php
session_start();
include('../connexion/connexionDB.php');
$userid=$_SESSION['userID'];
$PO=$_POST['PO'];
$nbr=$_POST['nbr'];
$typeR=$_POST['typeR'];

$Y=rand(1,999);
$IDretour="RT".$OF."-".$Y;
$sql = mysql_query("INSERT INTO bande_retour(IDretour,dateR,operateur1, PO,typeR) VALUES ('$IDretour',NOW(),'$userid','$PO','$typeR')");
$x=0;
if($typeR=="P"){
    while($nbr>$x){
        $x++;
		$paq="paq".$x;
		$qteR="qteR".$x;
		$idSI="idSI".$x;
		$ID=$_POST[$idSI];
		$qte=@$_POST[$qteR];
		if($qte>0 && $qte != ""){
            $sql1 = mysql_query("INSERT INTO bande_retour_items(IDretour, idSI, qte) VALUES ('$IDretour','$ID','$qte')");
        }
    }
}else{
    while($nbr>$x){
	    $x++;
		$art="art".$x; 
		$qteR="qteR".$x;
		$ID=$_POST[$art];
		$qte=@$_POST[$qteR];
		if($qte>0 && $qte != ""){
            $sql1 = mysql_query("INSERT INTO bande_retour_rebut(IDretour, IDarticle, qte) VALUES ('$IDretour','$ID','$qte')");
            
        }
    }
}
//Notification
	$msg= " Vous avez une nouvelle bande de retour";
    //$sql2=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$userid','LOG','$msg',NOW(),'msg')");
//Historique
    
	$msg="a ajouté la bande retour N° <b>".$IDretour."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','bande_retour','$IDrelance',NOW())"); 
	//
	mysql_close();
	//
	header('Location: ../pages/bande_retour.php');
?>