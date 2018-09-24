<?php
 session_start();
 $IDoperateur=$_SESSION['userID'];
 include('../connexion/connexionDB.php');
 $sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
 $user=mysql_result($sqlOP,0);
 //$user="Nour Ghribi";
 

$dateD=@$_POST['dateD'];
$idD=@$_POST['demande'];
$nbr=@$_POST['nbr'];


$sql="INSERT INTO demande_consommable(IDdemande,dateD,demandeur, statut) VALUES ('$idD','$dateD','$user','D')";
if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/ajout_reception.php?status=fail');
}else{  
 
 for($i=1;$i<= $nbr ; $i++){

	  $consN="C".$i;
      
      $qtyN="Q".$i;
	 
	  $consI=@$_POST[$consN];
      
	
      $QtyI=@$_POST[$qtyN];
	  
	 
	  
	  $sql1=mysql_query("INSERT INTO demande_items (IDdemande, IDconsommable,qtyD ) VALUES ('$idD','$consI','$QtyI')");
	  
	
  }
  $msg= " ".$user ."  a demandé des consommables <br> ID demande :  ".$idD."";
 $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$user','MAG','$msg',NOW(),'sortie_consommable.php')");
 
 	//historique
	  $msg2="  a demandé des consommables ,ID demande :  <b>".$idD."</b>";
	$HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg2','Demande consommable','$vP',NOW())"); 
  header('Location: ../pages/ajout_demande.php?status=sent');
  //echo($nbr);
}
?>