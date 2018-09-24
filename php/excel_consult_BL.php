 <meta charset="utf-8" />
 <?php
   // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=BL.xls");
//
include('../connexion/connexionDB.php');

 $valeur=$_POST['valeur'];
 $recherche=$_POST['recherche'];
 $statut=$_POST['statut']; 

  if($statut=="a"){
if ($recherche=="a"){
$req= "SELECT * FROM bon_livr order by num_bl DESC LIMIT 200";
}else if (($recherche == "client") or ($recherche == "date_liv")or ($recherche == "num_bl")) {
$req= "SELECT * FROM bon_livr where  $recherche='$valeur' order by num_bl DESC";
}else{
$req1= mysql_query("SELECT DISTINCT idBL FROM bon_livr_items where $recherche LIKE '%$valeur%' order by idBL DESC");

$req= "x";
}
}else{
if ($recherche=="a"){
$req= "SELECT * FROM bon_livr where etat_fact='$statut' order by num_bl DESC";
}else if (($recherche == "client") or ($recherche == "date_bl")) {
$req= "SELECT * FROM bon_livr where $recherche='$valeur' and etat_fact='$statut' order by num_bl DESC";
}else{
$req1= mysql_query("SELECT DISTINCT idBL FROM bon_livr_items where $recherche LIKE '%$valeur%' order by idBL DESC");

$req= "x";
}
}

   echo'<table border="1" bordercolor="BLUE" ><tr>
  <td>BL N° </td>
  <td>Client</td>  
  <td>Date Expedition </td>
  <td>PO </td>
  <td>Produit </td>
  <td>QTY</td>
  <td> Boxs </td>
  <td> Etat </td>
  <td></td>
  </tr>';

if($req=="x"){
 
 while($data=mysql_fetch_object($req1)){
 $BL=$data->idBL;
 if($statut=="a"){
 $req= "SELECT * FROM bon_livr where num_bl='$BL'";
 }else{
 $req= "SELECT * FROM bon_livr where num_bl='$BL' and etat_fact='$statut'";
 }
 $r=mysql_query($req) or die(mysql_error());
 
  while($a=mysql_fetch_object($r))
    {
    $num_bl = $a->num_bl;
    $client = $a->client;
	$adL = $a->adress_liv;
	$adF = $a->adress_fact;
	
	$nbr = $a->nbr_box;
	$etat= $a->etat_fact;
	$date_liv= $a->date_bl;
	$req11= mysql_query("SELECT nomClient FROM client1 where name_client='$client'");
	$clt=mysql_result($req11,0);
	$req2= mysql_query("SELECT * FROM bon_livr_items where idBL='$num_bl'");
	while($a1=mysql_fetch_object($req2))
    {
	$prd=$a1->IDproduit;
	$po=$a1->PO;
	$qtu=$a1->qty;
    echo"<tr><td>$num_bl</td><td>$clt</td><td>$date_liv</td><td>$po</td><td>$prd</td><td>$qtu</td><td>$nbr</td><td>$etat</td>
	<td><input  type=\"button\"  value=\">>\" onclick=\"afficheItems('".$num_bl."');\"></td></tr>";
    }
	}
 }
}else{
  $r=mysql_query($req) or die(mysql_error());
 
  while($a=mysql_fetch_object($r))
    {
    $num_bl = $a->num_bl;
    $client = $a->client;
	
	
	$nbr = $a->nbr_box;
	$date_liv= $a->date_liv;
	$etat= $a->etat_fact;
	$req11= mysql_query("SELECT nomClient FROM client1 where name_client='$client'");
	$clt=mysql_result($req11,0);
	
    $req2= mysql_query("SELECT * FROM bon_livr_items where idBL='$num_bl'");
	while($a1=mysql_fetch_object($req2))
    {
	$prd=$a1->IDproduit;
	$po=$a1->PO;
	$qtu=$a1->qty;
    echo"<tr><td>$num_bl</td><td>$clt</td><td>$date_liv</td><td>$po</td><td>$prd</td><td>$qtu</td><td>$nbr</td><td>$etat</td>
	<td><input  type=\"button\"  value=\">>\" onclick=\"afficheItems('".$num_bl."');\"></td></tr>";
    }
    }
	}
  echo '</table>';
  mysql_close();
  ?>
