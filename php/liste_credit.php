<?php
include('../connexion/connexionDB.php');

$lastM=$_POST['lastM'];
$nextM=$_POST['nextM'];
$client=$_POST['client'];
$fourArray=array();
$rq1= mysql_query("SELECT nom FROM fournisseur1 where client='$client'");
while($dataF=@mysql_fetch_array($rq1)){
  $fourArray[]="'".$dataF['nom']."'";
}
$fourListe= implode (",",$fourArray);
 echo'
 <table class="table table-fixed tabScroll">
<thead style="width:100%"><tr>
<th style="width:30.6%;height:60px">Credit N°</th>
<th style="width:30.6%;height:60px">Amount</th>
<th style="width:30.6%;height:60px">Payment date</th>
</tr></thead><tbody id="tbody2" style="width:100%">';


$req= mysql_query("SELECT * FROM supplier_invoice where supplier IN ($fourListe) and dateP >'$lastM' and dateP <='$nextM' and status='unpaid' and typeI LIKE 'Credit'");

while($data=mysql_fetch_array($req)){
   $dateP=$data['dateP'];
   $IDinvoice=$data['IDinvoice'];
    $n=strpos($IDinvoice,"-");
   $IDinvoice=substr($IDinvoice,$n+1);
//Affichage
echo"<tr>
<td style=\"width:30.8%;height:40px\">".$IDinvoice."</td>
<td style=\"width:30.8%;height:40px\">".$data['total']."</td>
<td style=\"width:30.8%;height:40px\" >".$dateP."</td>

</tr>";
//

}

 echo '</tbody></table>';

mysql_close();

 ?>
