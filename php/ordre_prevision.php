<?php
session_start();
include('../connexion/connexionDB.php');
    $IDordre = $_POST['IDordre'];
	$art= $_POST['listeART'];
	

    $nbr=$_POST['nbr'];
	
	
	

	if(isset($_POST['chek'])){
	$statut="auto";
	
	}else{
	
	$statut="waiting";
	  
	}
		
$sql = "DELETE FROM ordre_prevision where IDordre='$IDordre' and IDarticle='$art'";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    
}else{
$i=0;
while($nbr>$i){
$i++;
 $Q="Q".$i;
 $D="D".$i;


 $v1=$_POST[$Q];
 $v2=$_POST[$D];


	$sql2=("INSERT INTO ordre_prevision(IDordre, IDarticle,qty,dateP)VALUES ('$IDordre','$art','$v1','$v2')");
	if (!mysql_query($sql2)) {
die('Error: ' . mysql_error()); 
}else{
	header('Location: ../pages/ordre_prevision.php');
}
 //echo $v1;
}
 
    $userid=$_SESSION['userID'];
	$msg="a modifié les dates prévue de l'ordre d'achat N° <b>".$IDordre."</b>";
    $His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','commande2','$IDordre',NOW())"); 
}  

?>