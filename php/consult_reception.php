 <?php
include('../connexion/connexionDB.php');

$val=@$_POST['valeur'];
$recherche=@$_POST['recherche'];
$statut=@$_POST['statut'];

if($statut=="a"){
if($recherche=="item" || $recherche=="IDorder" ){
   $req= "SELECT * from reception_items where $recherche LIKE '$val'";
} else {

 $req= "SELECT * from reception_items where IDreception IN (SELECT IDreception FROM reception where $recherche LIKE'$val')";
 }
}else{
	if($recherche=="item" ||$recherche=="IDorder"){
    //$req= "SELECT DISTINCT(IDreception),IDshipment,supplier,dateR,dateE,dateES,status FROM reception where status LIKE '$statut' and IDreception IN (SELECT IDreception from reception_items where $recherche LIKE'$val')";

$req= "SELECT * from reception_items where $recherche LIKE'$val' and  IDreception IN (SELECT IDreception FROM reception where status LIKE'$statut')";

} else {
 //$req= "SELECT * FROM reception where $recherche LIKE '$val'and status LIKE'$statut'";
 $req= "SELECT * from reception_items where IDreception IN (SELECT IDreception FROM reception where $recherche LIKE'$val' and status LIKE'$statut')";

}
}

  $r=mysql_query($req) or die(mysql_error());

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr>
  <th>N° reception</th><th>N° shipment</th>
  <th>Fournisseur </th><th>Article</th>
  <th> QTE </th>
    <th>N° ordre </th>
  <th>Date Reception </th>
<th>Statut</th><th></th><th></th>
  </tr>';
  while($a1=mysql_fetch_array($r))
    {
	  $R=$a1['IDreception'];
    $req1=mysql_query("SELECT * FROM reception where IDreception LIKE '$R'");
    $a=mysql_fetch_object($req1);
    $ship =$a->IDshipment;
    $sup =$a->supplier;
	$dateE=$a->dateE;
	$dateR=$a->dateR;
	$op=$a->operator;
	$magz=$a->storekeeper;

	$statut=$a->status;
	if($statut != "invoiced"){
	$col="#F6CECE";
	}else{
	$col="#F2F2F2";
	}


    echo"<tr><td style=background-color:".$col." >$R</td>
	<td style=background-color:".$col.">$ship</td>
	<td style=background-color:".$col.">$sup</td>
	<td style=background-color:".$col.">".$a1['item']."</td>
	<td style=background-color:".$col.">".$a1['qty']."</td>
  	<td style=background-color:".$col.">".$a1['IDorder']."</td>
	<td style=background-color:".$col.">$dateR</td>

	<td style=background-color:".$col.">$statut</td>

	<td style=background-color:".$col."><p style=\"float:right\"><img src=\"../image/liste.png\" onclick=afficheA('".$R."'); alt=\"Print\" style=\"cursor:pointer;\" width=\"50\" height=\"40\"  /></td>
	<td style=background-color:".$col."><p style=\"float:right\"><img src=\"../image/print.png\" onclick=printR('".$R."'); alt=\"Print\" style=\"cursor:pointer;\" width=\"50\" height=\"40\"  /></td></tr>";
    }
  echo '</thead></table>';


  ?>
