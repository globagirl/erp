<meta charset="utf-8" />
 <?php
 
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=etat2015.xls");
include('../connexion/connexionDB2.php');



$sql = mysql_query ("SELECT sum(tot_val) AS total, count(num_fact) AS nbr , date_fact AS dateE ,devise AS devise FROM fact WHERE date_fact like '2015%' group by date_fact,devise");


echo'<div id="div1"><br><br><table  id="myTable" class="table"><thead>';
 //affichage
 
  echo'<tr><th>Date expédition</th><th>Client</th><th>Total PO</th><th>Total</th><th>Devise</th>
  
  </tr>';
while($data=@mysql_fetch_array($sql)){

$tot=round($data['total'],4);
$tot=str_replace(".",",",$tot);
 echo"<tr><td>".$data['dateE']."</td><td>TYCO</td><td>".$data['nbr']."</td><td>".$tot."</td><td>".$data['devise']."</td></tr>";

}


  echo '</thead></table></div>';

//echo($val);

  ?>