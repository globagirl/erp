<?php
session_start();
include('../connexion/connexionDB.php');
$userid=$_SESSION['userID'];
$recherche=$_POST['recherche'];
$valeur=$_POST['valeur'];
$dateD=$_POST['dateD'];
$nbrP=$_POST['nbrP'];
$nbr=$_POST['nbr'];
$sq = mysql_query("SELECT OF FROM ordre_fabrication1 where $recherche='$valeur'");
$OF=mysql_result($sq,0);
$IDrelance=$OF."RL".$nbrP;
$sql = mysql_query("INSERT INTO bande_relance(IDrelance,dateE,dateD, IDdemandeur, OF, nbr_piece) VALUES
                   ('$IDrelance',NOW(),'$dateD','$userid','$OF','$nbrP')");
$i=0;
while($nbr>$i){
 $i++;
 $idRI=$IDrelance."-".$i;
 $art="art".$i;
 $qte="qte".$i; 
 $art=$_POST[$art];
 $qte=@$_POST[$qte];
 if($qte>0 && $qte != ""){
     $sql1 = mysql_query("INSERT INTO bande_relance_items(ID,IDrelance, IDitem, qty) VALUES ('$idRI','$IDrelance','$art','$qte')");
 }
}

//Notification
	$msg= " Vous avez une nouvelle bande de relance ";
    $sql2=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$userid','LOG','$msg',NOW(),'msg')");
//Historique
    
	$msg="a ajouté la bande relance N° <b>".$IDrelance."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','bande_relance','$IDrelance',NOW())"); 
	//
	mysql_close();
	//
	header('Location: ../pages/bande_relance.php');
?>