<meta charset="utf-8" />
 <?php
 
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=bon_achat.xls");
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
/*$date1 = "2015-01-01"; 
$date2 = date('Y-m-d'); 
//Date Client
$date2 = strtotime($date2."+ 30 days");
$date2= date('Y-m-d', $date2);
}*/

   if($recherche != "fournisseur"){
      $req= "SELECT * FROM ordre_achat_article1 where ($recherche LIKE '$valeur') and (statut IN ($statut))and (dateR >= '$date1') and (dateR <= '$date2')";
	 
  }else {
      $req= "SELECT * FROM ordre_achat_article1 where  ($recherche1 >= '$date1') and ($recherche1 <= '$date2') and  (statut IN ($statut)) and (IDordre IN ('SELECT IDordre from  ordre_achat2 where fournisseur LIKE '$valeur'))";
 }
}else{

   if($recherche != "fournisseur"){
      $req= "SELECT * FROM ordre_achat_article1 where ($recherche LIKE '$valeur') and (statut IN ($statut))";
	 
  }else {
      $req= "SELECT * FROM ordre_achat_article1 where  (statut IN ($statut)) and (IDordre IN (SELECT IDordre from  ordre_achat2 where fournisseur LIKE '$valeur'))";
 }
}
echo '<table  class="table table-fixed  results" id="table3">
												    <thead style="width:100%">       
			                                        <tr>
													<th style="width:6.8%;text-align:center" >Order N°</th>
													<th style="width:18.8%;text-align:center">Fournisseur</th>
													<th style="width:13.8%;text-align:center">Article</th>	
													<th style="width:9.9%;text-align:center">QTE demand</th>
													<th style="width:9.9%;text-align:center">QTE reçue</th>
													<th style="width:10%;text-align:center">Reception</th>
													<th style="width:9.9%;text-align:center">Prix unitaire</th>
													<th style="width:9.9%;text-align:center" >Total</th>
													<th style="width:8.9%;text-align:center">Statut</th>		  
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">';

$r=mysql_query($req) or die(mysql_error());
 while($a=@mysql_fetch_array($r))
													 {
												
													 $IDordre =$a['IDordre'];  
													
													
													 $req1= mysql_query("SELECT fournisseur FROM ordre_achat2 where IDordre='$IDordre'");
													 $fournisseur=mysql_result($req1,0);
													 
													 echo('<tr>
													 <td style="width:6.6%;text-align:center" class="tdTab">'.$IDordre.'</td>
													 <td  style="width:19%;text-align:center">'.$fournisseur.'</td>
													 <td  style="width:14.1%;text-align:center">'.$a['IDarticle'].'</td>
													 <td style="width:10%;text-align:center">'.$a['qte_demande'].'</td>
													 <td style="width:10.1%;text-align:center">'.$a['qte_recue'].'</td>
													 <td style="width:10.1%;text-align:center">'.$a['dateR'].'</td>
													 <td style="width:10.1%;text-align:center">'.$a['prix_unitaire'].'</td>
													 <td style="width:10%;text-align:center">'.$a['prix_total'].'</td>
													 <td style="width:9%;text-align:center">'.$a['statut'].'</td></tr>');
													 }
													 echo '</tbody></table>';
													 mysql_close();

  ?>