 <?php
include('../connexion/connexionDB.php');

$dateJ=date("Y-m-d");
$dateJ=strtotime($dateJ."+7 days");
$dateJ=date('Y-m-d',$dateJ);

  echo'

  <h3>Liste des commandes NON expédié </h3>
  <table class="table table-fixed  tabScroll2">
<thead style="width:100%"><tr>
<th style="width:24.6%;height:60px">PO</th>
<th style="width:19.4%;height:60px">Shipping date</th>
<th style="width:14.2%;height:60px">QTY</th>
<th style="width:19.6%;height:60px">Amount</th>

<th style="width:19.6%;height:60px"></th>
</tr></thead><tbody id="tbody2" style="width:100%">';


$req1=mysql_query("SELECT PO FROM commande_items where  statut='waiting'");
										while($a=mysql_fetch_array($req1)){
										$PO=$a['PO'];
										$req2=mysql_query("SELECT * FROM commande2 where PO='$PO'");
										$data=mysql_fetch_array($req2);
										$dateE=$data['date_exped'];
										$dateE=strtotime($dateE."+7 days");
                                        $dateE=date('Y-m-d',$dateE);
										if($dateE<$dateJ){
//Affichage
 echo"<tr>
<td style=\"width:25%;height:60px\">".$data['PO']."</td>
<td style=\"width:20%;height:60px\">".$data['date_exped']."</td>
<td style=\"width:15%;height:60px\">".$data['qte_demande']."</td>
<td style=\"width:20%;height:60px\" >".$data['prix_total']." ".$data['devise']."</td>
<td style=\"width:20%;height:60px\" > <input type=\"button\" id=\"".$PO."\" class=\"btn btn-default red\" onClick=deletePO('".$PO."'); value=\"Delete\"></td>


</tr>";
//

}

}
  echo '</tbody></table></div>'; 
  
 mysql_close(); 

  ?>