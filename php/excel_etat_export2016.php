<meta charset="utf-8" />
 <?php
 
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=etat2016.xls");
include('../connexion/connexionDB2.php');



$sql = mysql_query ("SELECT sum(tot_val) AS total, count(num_fact) AS nbr , date_fact AS dateE ,devise AS devise FROM fact WHERE date_fact like '2016%' group by date_fact,devise");


echo'<div id="div1"><br><br><table  id="myTable" class="table"><thead>';
 //affichage
 
while($data=@mysql_fetch_array($sql)){

$tot=round($data['total'],4);
$tot=str_replace(".",",",$tot);
$dateE=$data['dateE'];
$devise=$data['devise'];
 echo"<tr><td><b>Date expédition:</b>".$data['dateE']."</td>
 <td><b>Client </b>TYCO</td>
 <td><b>NBR PO : </b>".$data['nbr']."</td>
 <td><b> Total :</b>".$tot."</td>
 <td><b> Devise : </b>".$data['devise']."</td></tr>";
$sql2 = mysql_query ("SELECT * FROM fact WHERE date_fact='$dateE' and devise='$devise'");
while($data2=@mysql_fetch_array($sql2)){
$tot_val=$data2['tot_val'];
$tot_val=str_replace(".",",",$tot_val);
 echo"<tr><td>".$data2['num_fact']."</td><td>".$tot_val."</td></tr>";
}
echo"<tr></tr>";
}


  echo '</thead></table></div>';

//echo($val);

  ?>