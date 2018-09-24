<meta charset="utf-8" />
 <?php
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=tyco_account.xls");
include('../connexion/connexionDB.php');

 $week=$_POST['week'];
 $Z=$_POST['Z'];

$req= mysql_query("SELECT max(date_pay) FROM fact1 where client='TYCO2' and statut='paid'");
$dernier_pay=mysql_result($req,0);
$dernier_pay2 = strtotime($dernier_pay);
$dernier_pay2= date("d- M -Y",$dernier_pay2);
  echo'
    
		  <br>
		  <br>
		  <h3>Last payment: '.$dernier_pay2.'</h3>
		  <br>
		  <br>
  <table border="1px">
<thead style="width:100%"><tr>
<th style="width:14.6%;height:60px">Day</th>
<th style="width:10.6%;height:60px">Left_over</th>
<th style="width:14.6%;height:60px">Unpaid sales</th>
<th style="width:14.6%;height:60px">Sales</th>
<th style="width:14.6%;height:60px">Unpaid purchases</th>
<th style="width:14.7%;height:60px">Purchases</th>
<th style="width:14.8%;height:60px">Income</th>  
</tr></thead><tbody id="tbody2" style="width:100%">';



//$jour1=date('Y-m-d');
$jour = strtotime($dernier_pay);
$nextM=strtotime("next Monday",$jour);
$nextM=date('Y-m-d',$nextM);
$num = strftime("%a",$jour);

$lastM=$dernier_pay;

$req1= mysql_query("SELECT sum(tot_val) FROM fact1 where client='TYCO2' and date_pay < '$lastM' and statut='unpaid'");
$unpaid_sales=mysql_result($req1,0);
$unpaid_sales=round($unpaid_sales,4);

$req31= mysql_query("SELECT sum(total) FROM supplier_invoice where supplier='TYCO ELECTRONIC LOGI' and dateP <'$lastM' and status='unpaid' and typeI='Purchase'");
$unpaid_purchases=mysql_result($req31,0);
$unpaid_purchases=round($unpaid_purchases,4);

while($nextM<=$week) 
{ 
$req2= mysql_query("SELECT sum(tot_val) FROM fact1 where client='TYCO2' and date_pay >'$lastM' and date_pay <='$nextM' and statut='unpaid'");
$total_sales=mysql_result($req2,0);
$total_sales=round($total_sales,4);

$req3= mysql_query("SELECT sum(total) FROM supplier_invoice where supplier='TYCO ELECTRONIC LOGI' and dateP >'$lastM' and dateP <='$nextM' and status='unpaid' and typeI='Purchase'");
$total_purchases=mysql_result($req3,0);
$total_purchases=round($total_purchases,4);
$tot_sales=$total_sales+$unpaid_sales;
$tot_purchases=$total_purchases+$unpaid_purchases;
$income=($tot_sales-$tot_purchases)-$Z;

//Affichage
 echo'<tr>
<td style="width:14.8%;height:40px">'.$nextM.'</td>
<td style="width:10.8%;height:40px">- '.$Z.'</td>
<td style="width:14.8%;height:40px">+ '.$unpaid_sales.'</td>
<td style="width:14.8%;height:40px">+ '.$total_sales.'</td>
<td style="width:14.8%;height:40px">- '.$unpaid_purchases.'</td>
<td style="width:14.8%;height:40px">- '.$total_purchases.'</td>
<td style="width:14.8%;height:40px">'.$income.'</td>  
</tr>';
//

if($income<0){
$Z=abs($income);
}else{
$Z=0;
}
$unpaid_purchases=0;
$unpaid_sales=0;
$lastM=$nextM;
$nextM= strtotime($nextM."+7 days");
$nextM=date('Y-m-d',$nextM);
}

  echo '</tbody></table>';



  ?>