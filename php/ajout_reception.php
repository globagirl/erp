<?php
 session_start();
 $IDoperateur=$_SESSION['userID'];
 include('../connexion/connexionDB.php');
 $sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
 $user=mysql_result($sqlOP,0);
 $shipment=@$_POST['shipment'];
 $dateR=@$_POST['dateR'];
 $idR=@$_POST['reception'];
$nbr=@$_POST['nbr'];

$dateN=date("Y-m-d");
$supplier=@$_POST['four'];


$sql="INSERT INTO reception(IDreception,IDshipment,supplier, dateR, dateE, operator, status) VALUES ('$idR','$shipment','$supplier','$dateR',NOW(),'$user','waiting')";
if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/ajout_reception.php?status=fail');
}else{  
 
 for($i=1;$i<= $nbr ; $i++){

	  $orderN="O".$i;
      $itemN="I".$i;
      $qtyN="Q".$i;
	 
	  $OrderI=@$_POST[$orderN];
      $ItemI=@$_POST[$itemN];
	
      $QtyI=@$_POST[$qtyN];
	  
	  $sqlP=mysql_query("select prix_unitaire from ordre_achat_article1 where IDordre='$OrderI' and IDarticle='$ItemI'");
      $prix_unitaire=mysql_result($sqlP,0);
	  $price=$QtyI*$prix_unitaire;
	  
	  $sql1=mysql_query("INSERT INTO reception_items(IDreception, IDorder, item,qtyBR,qty,price, status) VALUES ('$idR','$OrderI','$ItemI','$QtyI','$QtyI','$price','waiting')");
	  $sqlUp=mysql_query("UPDATE ordre_achat2 SET date_recep=NOW() WHERE IDordre='$OrderI'");
	
  }
   $msg= " Vous avez une nouvelle reception <br> ID reception :  <b>".$idR."</b>";
  $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$user','MAG','$msg',NOW(),'ajout_stock.php')");
  //Historique
  $msg="a recue une commande , Reception ID : <b>".$idR."</b>";
  $HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','reception','$idR',NOW())");   
  header('Location: ../pages/ajout_reception.php?status=sent');
  
}
?>