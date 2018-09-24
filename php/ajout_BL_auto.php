<?php
session_start();
include('../connexion/connexionDB.php');
$dateE=$_POST['dateE'];
$userid=$_SESSION['userID'];

$sql = mysql_query("select * from expedition where date_exp='$dateE' and statut='N'");
$nbr=mysql_num_rows($sql);
$i=0;

echo('<div class="col-lg-12">
		<img src="../image/excel.png" onclick="excelBL();" alt="Excel" style="cursor:pointer;" width="60" height="50"  />
		</p>
        </div><div class="table-responsive col-lg-12" id="divRel">
<table class="table table-fixed table-bordered results" id="table3">
<thead style="width:100%"><tr>
	<th style="width:3.9%;height:60px;text-align:center" class="degraD2"> N°</th>
	<th style="width:9.8%;height:60px;text-align:center" class="degraD2">BL N°</th>
	<th style="width:12.9%;height:60px;text-align:center" class="degraD2">PO</th>
	<th style="width:9.8%;height:60px;text-align:center" class="degraD2">OF</th>
	<th  style="width:12.8%;height:60px;text-align:center" class="degraD2">Produit.</th>
	<th  style="width:7.8%;height:60px;text-align:center" class="degraD2">Qty</th>
	<th  style="width:7.8%;height:60px;text-align:center" class="degraD2">Nbr Box</th>
	<th  style="width:11.8%;height:60px;text-align:center" class="degraD2">Date Expédition</th>
	<th style="width:11.8%;height:60px;text-align:center" class="degraD2">Date client</th>
	<th style="width:9.8%;height:60px;text-align:center" class="degraD2">Client</th></tr>
   </thead>
	<tbody id="tbody2" style="width:100%">
	');
if($nbr>0){
while($data=mysql_fetch_array($sql)){

$PO=$data['PO'];
$OF=$data['OF'];
$IDexped=$data['idEXP'];
//INfo commande
$sql1 = mysql_query("SELECT client FROM commande2 where PO='$PO'");
//$data1=mysql_fetch_array($sql1);
$client=mysql_result($sql1,0);

//INfo OF
$sql2 = mysql_query("SELECT produit,qte,date_exped_conf FROM ordre_fabrication1 where OF='$OF'");
$data2=mysql_fetch_array($sql2);
$produit=$data2['produit'];
$qte=$data2['qte'];
$dateEX=$data2['date_exped_conf'];
/*
//Info client
$sql3 = mysql_query("SELECT * FROM client1 where name_client='$client'");
$data3=mysql_fetch_array($sql3);
$adF=$data3['adress_fact'];
$adL=$data3['adress_liv'];
*/
//Definir NBR BOX
$sql4 = mysql_query("SELECT nbr_box FROM produit1 where code_produit='$produit'");
$nbP=mysql_result($sql4,0);

if($nbP==0){
$box=1;
}else if($nbP>$qte){
$box=1;
}else{
$box=$qte/$nbP;
}

//NUM BL
$sql8 = mysql_query("SELECT max(num_bl) FROM bon_livr ");
$max=mysql_result($sql8,0);
$BL=$max+1;

$dateCL = strtotime($dateEX."+ 7 days");
$dateCL= date('Y-m-d', $dateCL);



//les updates
$req1=mysql_query("SELECT statut from commande_items where POitem='$PO'");
$stat=mysql_result($req1,0);
if($stat=="incomplete"){
	$statut="incomplete";
}else{
	$statut="unbilled";
	}

if(($stat=="finished") or ($stat=="incomplete")){
$BLX=$BL."B1";
$sq1 = mysql_query("INSERT INTO bon_livr (num_bl,date_bl,client,date_liv,qtu,etat_fact,nbr_box)
VALUES ('$BL','$dateEX','$client','$dateCL','$qte','unbilled','$box')");
$sq2 = mysql_query("INSERT INTO bon_livr_items(idBLI,idBL,IDproduit, PO, OF, qty, box)
VALUES ('$BLX','$BL','$produit','$PO','$OF','$qte','$box')");

$sql11=mysql_query("UPDATE commande_items SET statut='$statut' where POitem='$PO'");
$sql12=mysql_query("UPDATE ordre_fabrication1 SET statut='closed' where OF='$OF'");
$sql13=mysql_query("UPDATE expedition SET statut='T' where idEXP='$IDexped'");


$i++;
//Affichage
echo('<tr id='.$i.'>
	<td style="width:4%;height:60px;text-align:center">'.$i.'</td>
	<td style="width:10%;height:60px;text-align:center">'.$BL.'</td>
	<td style="width:13%;height:60px;text-align:center">'.$PO.'</td>
	<td style="width:10%;height:60px;text-align:center">'.$OF.'</td>
	<td  style="width:13%;height:60px;text-align:center">'.$produit.'</td>
	<td  style="width:8%;height:60px;text-align:center">'.$qte.'</td>
	<td  style="width:8%;height:60px;text-align:center">'.$box.'</td>
	<td  style="width:12%;height:60px;text-align:center">'.$dateEX.'</td>
	<td style="width:12%;height:60px;text-align:center">'.$dateCL.'</td>
	<td style="width:10%;height:60px;text-align:center">'.$client.'</td>
  </tr>
	');
}
}


}
echo('</tbody></table></div>');
mysql_close();
?>
