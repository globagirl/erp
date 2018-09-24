 <?php
include('../connexion/connexionDB2.php');



$sql = mysql_query ("SELECT sum(tot_val) AS total, count(num_fact) AS nbr , date_fact AS dateE ,devise AS devise FROM fact WHERE date_fact like '2016%' group by date_fact,devise");


echo'<div id="div1"><br><br><table  id="myTable" class="table"><thead>';
 //affichage
 
  echo'<tr><th>Date expédition</th><th>Client</th><th>Total PO</th><th>Total</th><th>Devise</th>
  
  </tr>';
while($data=@mysql_fetch_array($sql)){

$tot=round($data['total'],4);

 echo"<tr><td>".$data['dateE']."</td><td>TYCO</td><td>".$data['nbr']."</td><td>".$tot."</td><td>".$data['devise']."</td></tr>";

}


  echo '</thead></table></div>';

//echo($val);

  ?>