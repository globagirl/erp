 <?php
include('../connexion/connexionDB.php');

 $lastM=$_POST['lastM'];
 $nextM=$_POST['nextM'];
 $client=$_POST['client'];
  echo'
  <table class="table table-fixed tabScroll">
<thead style="width:100%"><tr>
<th style="width:30.6%;height:60px">Invoice N°</th>
<th style="width:30.6%;height:60px">Amount</th>
<th style="width:30.6%;height:60px">Payment date</th>
</tr></thead><tbody id="tbody2" style="width:100%">';


$req= mysql_query("SELECT * FROM fact1 where client='$client' and date_pay <'$lastM' and statut='unpaid'");

while($data=mysql_fetch_array($req)){
$dateP=$data['date_pay'];
//Affichage
 echo"<tr>
<td style=\"width:30.8%;height:40px\">".$data['num_fact']."</td>
<td style=\"width:30.8%;height:40px\">".$data['tot_val']."</td>
<td style=\"width:30.8%;height:40px\" >".$dateP."</td>

</tr>";
//

}

  echo '</tbody></table>';
mysql_close(); 


  ?>