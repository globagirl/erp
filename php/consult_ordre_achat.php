 <?php
 //Les fonction a utiliser 
 function afficheLigne($IDordre,$four,$art,$qteD,$qteR,$dateR,$prixU,$stat,$col){
     $prixT=$prixU*$qteR;
     echo('<tr>
				<td style="width:6.6%;height:60px;text-align:center;background-color:'.$col.'">'.$IDordre.'</td>
				<td  style="width:19%;height:60px;text-align:center;background-color:'.$col.'">'.$four.'</td>
				<td  style="width:14.1%;height:60px;text-align:center;background-color:'.$col.'">'.$art.'</td>
				<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$qteD.'</td>
				<td style="width:10.1%;height:60px;text-align:center;background-color:'.$col.'">'.$qteR.'</td>
				<td style="width:10.1%;height:60px;text-align:center;background-color:'.$col.'">'.$dateR.'</td>
				<td style="width:10.1%;height:60px;text-align:center;background-color:'.$col.'">'.$prixU.'</td>
				<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$prixT.'</td>
				<td style="width:9%;height:60px;text-align:center;background-color:'.$col.'">'.$stat.'</td>
	</tr>');
 
 }
 
 //
include('../connexion/connexionDB.php');
$statut=$_POST['statut'];
$valeur=@$_POST['valeur'];
$recherche=$_POST['recherche'];
$recherche1=$_POST['recherche1'];
$date1=@$_POST['date1'];
$date2=@$_POST['date2'];
if($statut=="A"){
   $statut="'received','waiting','incomplete'";
 
}else{
  $statut="'".$statut."'";
}
if($valeur==""){
 $valeur="%%";
}
if(($date1 != "") && ($date2 != "")){

   if($recherche != "fournisseur"){
      $req= "SELECT * FROM ordre_achat_article1 where ($recherche LIKE '$valeur') and (statut IN ($statut))and (dateR >= '$date1') and (dateR <= '$date2') order by IDordre DESC";
	 
  }else {
      $req= "SELECT * FROM ordre_achat_article1 where  ($recherche1 >= '$date1') and ($recherche1 <= '$date2') and  (statut IN ($statut)) and (IDordre IN (SELECT IDordre from  ordre_achat2 where fournisseur LIKE '$valeur')) order by IDordre DESC";
 }
}else{

   if($recherche != "fournisseur"){
      $req= "SELECT * FROM ordre_achat_article1 where ($recherche LIKE '$valeur') and (statut IN ($statut)) order by IDordre DESC";
	 
  }else {
      $req= "SELECT * FROM ordre_achat_article1 where  (statut IN ($statut)) and (IDordre IN (SELECT IDordre from  ordre_achat2 where fournisseur LIKE '$valeur')) order by IDordre DESC";
 }
}

$r=mysql_query($req) or die(mysql_error());
while($a=@mysql_fetch_array($r)){
		$IDordre =$a['IDordre'];
		$statut =$a['statut'];
		$IDarticle=$a['IDarticle'];
		$qteD =$a['qte_demande'];
		$prixU =$a['prix_unitaire'];
		$qteR =$a['qte_recue'];
		$dateR =$a['dateR'];
		$req1= mysql_query("SELECT fournisseur FROM ordre_achat2 where IDordre='$IDordre'");
		$fournisseur=mysql_result($req1,0);
  $col="#F5ECCE";
		afficheLigne($IDordre,$fournisseur,$IDarticle,$qteD,$qteR,$dateR,$prixU,$statut,$col);
		if($statut != 'waiting'){		 
		  //$req2= mysql_query("SELECT IDreception, qty ,status FROM reception_items where IDorder='$IDordre' and item='$IDarticle'");
    $req2= mysql_query("SELECT DISTINCT dateES FROM reception where IDreception IN (SELECT IDreception FROM reception_items where IDorder='$IDordre' and item='$IDarticle')");
		  if(mysql_num_rows($req2)>1){
		    while($a2=mysql_fetch_array($req2)){ 
		         $dateES=$a2['dateES'];		        
           $req3= mysql_query("SELECT sum(qty) FROM reception_items where IDorder='$IDordre' and item='$IDarticle' and IDreception IN (SELECT IDreception from reception where dateES='$dateES')");
           $qteR=@mysql_result($req3,0);
				       $val="--";
           $col="#F2F2F2";
				       afficheLigne($val,$val,$val,$val,$qteR,$dateES,$prixU,$val,$col);
		         
		   } 
		  }	   
  }
	}
 mysql_close();

?>