 <?php
include('../connexion/connexionDB.php');

 $date1=@$_POST['date1'];
 $date2=@$_POST['date2'];

$sql = mysql_query ("SELECT sum(tot_val) AS total, count(num_fact) AS nbr , date_E AS dateE ,client AS client , devise AS devise FROM fact1 WHERE date_E >='$date1' and date_E <= '$date2' group by date_E,client,devise");


echo'<div id="div1"><br><br><table  id="myTable" class="table"><thead>';
 //affichage
 
  echo'<tr><th>Date expédition</th><th>Client</th><th>Total PO</th><th>Total</th><th>Devise</th>
  
  </tr>';
while($data=@mysql_fetch_array($sql)){

$tot=round($data['total'],4);

 echo"<tr><td>".$data['dateE']."</td><td>".$data['client']."</td><td>".$data['nbr']."</td><td>".$tot."</td><td>".$data['devise']."</td></tr>";

}


  echo '</thead></table></div>';

//echo($val);

  ?>