<?php				
 echo '<div class="col-md-1 pull-right">
 <img src="../image/notShipped.png" onclick="liste_NotShipped();" alt="Not shipped" style="cursor:pointer;" width="60" height="50"  />';
 
$nbr=0;
$dateJ2=strtotime($dateJ."+7 days");
$dateJ2=date('Y-m-d',$dateJ2);
$req1=mysql_query("SELECT PO FROM commande_items where  statut='waiting'");
while($data=mysql_fetch_array($req1)){
	$PO=$data['PO'];
	$req2=mysql_query("SELECT date_exped FROM commande2 where PO='$PO'");
	$dateE=mysql_result($req2,0);
	$dateE=strtotime($dateE."+7 days");
	$dateE=date('Y-m-d',$dateE);
	if($dateE<$dateJ2){
	  $nbr++;
	  }
	  }
	if($nbr>0){
		echo '<div class="Xnote2" onClick="liste_NotShipped();">'.$nbr.'</div>';
		}
		echo '</div>';
?>