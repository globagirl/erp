 <meta charset="utf-8" />
 <?php
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=avance.xls");

include('../connexion/connexionDB.php');
$dateE=$_POST['dateE'];
$userid=$_SESSION['userID'];

$sql = mysql_query("select num_bl,date_bl,client from bon_livr where date_bl='$dateE'");
$nbr=mysql_num_rows($sql);
$i=0;

echo('<div class="col-lg-12">		
		<img src="../image/excel.png" onclick="excelBL();" alt="Excel" style="cursor:pointer;" width="60" height="50"  />
		</p>
        </div><div class="table-responsive col-lg-12" id="divRel">
<table class="table table-fixed table-bordered results" id="table3">
<thead style="width:100%"><tr>
	<th style="width:3.9%;height:60px;text-align:center" class="degraD2"> N°</th>
	<th style="width:9.8%;height:60px;text-align:center" class="degraD2">BL N°</th>
	<th style="width:12.9%;height:60px;text-align:center" class="degraD2">PO</th>
	<th style="width:9.8%;height:60px;text-align:center" class="degraD2">OF</th>
	<th  style="width:12.8%;height:60px;text-align:center" class="degraD2">Produit.</th>
	<th  style="width:7.8%;height:60px;text-align:center" class="degraD2">Qty</th>
	<th  style="width:7.8%;height:60px;text-align:center" class="degraD2">Nbr Box</th>
	<th  style="width:11.8%;height:60px;text-align:center" class="degraD2">Date Expédition</th>
	<th style="width:11.8%;height:60px;text-align:center" class="degraD2">Date client</th>
	<th style="width:9.8%;height:60px;text-align:center" class="degraD2">Client</th></tr>
   </thead>
	<tbody id="tbody2" style="width:100%">
	');
if($nbr>0){
while($data=mysql_fetch_array($sql)){
$client=$data['client'];
$BL=$data['num_bl'];

//INfo client
$sql1 = mysql_query("SELECT nomClient FROM client1 where name_client='$client'");
//$data1=mysql_fetch_array($sql1);
$clt=mysql_result($sql1,0);
$sql2 = mysql_query("SELECT IDproduit,PO,OF,qty FROM bon_livr_items where idBL='$BL'");
while($data2=mysql_fetch_array($sql2)){
$i++;
//Affichage
echo('<tr id='.$i.'>
	<td style="width:4%;height:60px;text-align:center">'.$i.'</td>
	<td style="width:10%;height:60px;text-align:center">'.$BL.'</td>
	<td style="width:13%;height:60px;text-align:center">'.$data2['PO'].'</td>
	<td style="width:10%;height:60px;text-align:center">'.$data2['OF'].'</td>
	<td  style="width:13%;height:60px;text-align:center">'.$data2['produit'].'</td>
	<td  style="width:8%;height:60px;text-align:center">'.$data2['qty'].'</td>
	<td  style="width:12%;height:60px;text-align:center">'.$dateE.'</td>
	<td style="width:10%;height:60px;text-align:center">'.$clt.'</td>
  </tr>
	');
}
}


}
echo('</tbody></table></div>');
mysql_close();
?>