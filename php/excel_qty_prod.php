<meta charset="utf-8" />
 <?php
 
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=qty_prod.xls");
include('../connexion/connexionDB.php');
    $valeur=@$_POST['valeur'];
    $recherche=@$_POST['recherche'];
    $total=0;
//total
$sql2 = mysql_query ("SELECT * FROM ordre_fabrication1 WHERE $recherche LIKE '$valeur'");
while($data=@mysql_fetch_array($sql2)){
$OF=$data['OF'];

$sql3 = mysql_query ("SELECT * FROM pro_test_pol WHERE plan LIKE '$OF%'");
while($data3=@mysql_fetch_array($sql3)){
$qteS=$data3['qte_s'];
$total=$total+$qteS;

}
}

 echo'<div id="div1"><table  id="myTable" class="table"><thead><tr><td colspan=2></td><td colspan=2> <b>Total production: '.$total.'</b></td></tr>';
 //affichage
 
  echo'<tr><th>Plan</th><th>PO</th><th>QTY entrée</th><th>QTY sortie</th>
  
  </tr>';
$sql2 = mysql_query ("SELECT * FROM ordre_fabrication1 WHERE $recherche LIKE '$valeur'");
while($data=@mysql_fetch_array($sql2)){
$OF=$data['OF'];
 //echo"<tr><td>$OF</td></tr>";
$sql3 = mysql_query ("SELECT * FROM pro_test_pol WHERE plan LIKE '$OF%'");
while($data3=@mysql_fetch_array($sql3)){
$PO=$data3['PO'];
$qteE=$data3['qte_e'];
$qteS=$data3['qte_s'];
$plan=$data3['plan'];
$total=$total+$qteS;
 echo"<tr><td>$plan</td><td>$PO</td><td>$qteE</td><td>$qteS</td></tr>";
}
}


  echo '</thead></table></div>';

mysql_close();

  ?>