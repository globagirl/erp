 <meta charset="utf-8" />
 <?php
 
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=etat_export.xls");
include('../connexion/connexionDB.php');


 $date1=@$_POST['date1'];
 $date2=@$_POST['date2'];

$sql = mysql_query ("SELECT sum(tot_val) AS total, count(num_fact) AS nbr , date_E AS dateE ,client AS client , devise AS devise ,num_fact AS numF FROM fact1 WHERE date_E >='$date1' and date_E <= '$date2' group by date_E,client,devise");
//$sql = mysql_query ("SELECT date_E,sum(tot_val) AS totalS FROM fact1  group by date_E");

echo'<div id="div1"><br><br><table  id="myTable" class="table"><thead>';
 //affichage
 
  //echo'<tr><th></th><th></th><th></th><th>Total</th><th></th></tr>';
while($data=@mysql_fetch_array($sql)){
$tot=round($data['total'],4);
 $tot=str_replace(".",",",$tot);
 echo"<tr><td><b>Date expédition :</b>".$data['dateE']."</td><td><b> Client :</b>".$data['client']."</td>
 <td><b>Total PO</b>:".$data['nbr']."</td><td ><b>Total:</b>".$tot."</td><td><b>Devise </b>:".$data['devise']."</td></tr>";
 // Détaille 
 $D=$data['devise'];
 $C=$data['client'];
 $DE=$data['dateE'];
 $sql1 = mysql_query ("SELECT * FROM fact1 WHERE date_E ='$DE' and devise <= '$D' and client = '$C'");
 while($data1=@mysql_fetch_array($sql1)){
 $tot_val=$data1['tot_val'];
 $tot_val=str_replace(".",",",$tot_val);
 echo "<tr><td>".$data1['num_fact']."</td><td>".$tot_val." ".$data1['devise']."</td></tr>";
 }
echo "<tr></tr>";
}


  echo '</thead></table></div>';

//echo($val);

  ?>