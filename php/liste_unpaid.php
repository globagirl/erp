 <?php
include('../connexion/connexionDB.php');
$dateJ=date("Y-m-d");
$dateJ=strtotime($dateJ."-15 days");
$dateJ=date('Y-m-d',$dateJ);
$req= mysql_query("SELECT * FROM fact1 where date_pay <='$dateJ' and statut='unpaid'");
$nbr1=mysql_num_rows($req);
if($nbr1>0){
  echo'

  <h3>Unpaid sales</h3>
  <table class="table table-fixed  tabScroll2">
<thead style="width:100%"><tr>
<th style="width:24.6%;height:60px">Invoice N°</th>
<th style="width:24.4%;height:60px">Client</th>
<th style="width:24.2%;height:60px">Amount</th>
<th style="width:24.6%;height:60px">Payment date</th>
</tr></thead><tbody id="tbody2" style="width:100%">';




while($data=mysql_fetch_array($req)){
$dateP=$data['date_pay'];
$IDclient=$data['client'];
$sq=mysql_query("SELECT nomClient FROM client1 where name_client='$IDclient'");
$client=@mysql_result($sq,0);
//Affichage
 echo"<tr>
<td style=\"width:24.8%;height:60px\">".$data['num_fact']."</td>
<td style=\"width:24.8%;height:60px\">".$client."</td>
<td style=\"width:25%;height:60px\">".$data['tot_val']."</td>
<td style=\"width:25%;height:60px\" >".$dateP."</td>

</tr>";
//

}


  echo '</tbody></table></div>'; 
  
 } 
/////////
/*
$req1= mysql_query("SELECT * FROM supplier_invoice where supplier='TYCO ELECTRONIC LOGI' and dateP<= '$dateJ' and status='unpaid' and typeI='Purchase'");
$nbr2=mysql_num_rows($req1);
if($nbr2>0){
  echo'
  

  <h3>Unpaid purchases</h3>
  <table class="table table-fixed tabScroll2">
<thead style="width:100%"><tr>
<th style="width:24.6%;height:60px">Invoice N°</th>
<th style="width:29.6%;height:60px">Supplier</th>
<th style="width:19.6%;height:60px">Amount</th>
<th style="width:24.6%;height:60px">Payment date</th>
</tr></thead><tbody id="tbody2" style="width:100%">';




while($data1=mysql_fetch_array($req1)){
    $dateP=$data1['dateP'];
    $IDinvoice=$data1['IDinvoice'];
	$n=strpos($IDinvoice,"-");	
    $IDinvoice=substr($IDinvoice,$n+1);
//Affichage
 echo"<tr>
<td style=\"width:24.8%;height:60px\">".$IDinvoice."</td>
<td style=\"width:30%;height:60px\">".$data1['supplier']."</td>
<td style=\"width:20%;height:60px\">".$data1['total']."</td>
<td style=\"width:24.8%;height:60px\" >".$dateP."</td>

</tr>";
//

}

  echo '</tbody></table>';

}
*/
mysql_close(); 
  ?>