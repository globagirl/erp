<meta charset="utf-8" />
 <?php
 
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=profits.xls");
include('../connexion/connexionDB.php');


$date1=@$_POST['date1'];
$date2=@$_POST['date2'];
$recherche=@$_POST['recherche'];
$valeur=@$_POST['valeur'];
$R2=@$_POST['R2'];
$totalProfit=0;
$totalRevenues=0;
$totalCosts=0;

$devise="";
$req= "SELECT * FROM commande2 where date_exped >= '$date1' and date_exped<= '$date2'";





  $r=mysql_query($req) or die(mysql_error());

  echo' <table border="1px">
<thead style="width:100%">
<tr>
<th style="width:4%;height:60px" class="degraD2"><b>N°</b></th>
  <th style="width:10%;height:60px" class="degraD2"><b>Purchase order N°</b></th>
  <th style="width:10%;height:60px" class="degraD2"><b>Shipping date</b></th>
  <th style="width:10%;height:60px" class="degraD2"><b>Item ID</b></th>
  <th style="width:5%;height:60px" class="degraD2"><b>Lgth</b></th>
  <th style="width:9%;height:60px" class="degraD2"><b>Qty</b></th>
  <th style="width:10%;height:60px" class="degraD2"><b>Revenue</b></th>
  <th style="width:10%;height:60px" class="degraD2"><b>Theoretical costs</b></th>
  <th style="width:10%;height:60px" class="degraD2"><b>Real costs</b></th>
  <th style="width:10%;height:60px" class="degraD2"><b>Gross margin</b></th>
  <th style="width:10%;height:60px" class="degraD2"><b>Gross margin %</b></th>

  </tr></thead><tbody id="tbody2" style="width:100%">';
  $i=1;
  while($a=@mysql_fetch_object($r)){
	$PO=$a->PO;	 
	$dateE=$a->date_exped;	
	$devise=$a->devise;
	//selection des commandes
	
	if($R2=="shipped"){
	$req1= mysql_query("SELECT * FROM commande_items where PO='$PO' and statut !='waiting' and statut !='planned'");
	}else if($R2=="shippedNot"){
	$req1= mysql_query("SELECT * FROM commande_items where PO='$PO' and (statut ='waiting' or statut ='planned')");
	}else{
	$req1= mysql_query("SELECT * FROM commande_items where PO='$PO'");
	}
	while($data=mysql_fetch_object($req1))
    {
	
	 
     $PO=$data->PO;	 
     $qteC=$data->qty;	 
	 $prixT=$data->prixT;	
	 $produit=$data->produit;
	 $statut=$data->statut;
	 
	 if($statut=="incomplete"){
	 $reqInc=mysql_query("SELECT sum(qte) FROM ordre_fabrication1 where PO='$PO'");
	 $qteC=mysql_result($reqInc,0);
	 }
	 //theoretical cost
	 $totalTC=0;
	  $req3= mysql_query("SELECT DISTINCT IDarticle,qte FROM produit_article1 where IDproduit='$produit'");
	 while($data3=@mysql_fetch_object($req3)){
	 $qteB=$data3->qte;	 
	 $article=$data3->IDarticle;
	
	 $req4= mysql_query("SELECT * FROM article1 where code_article='$article'");
	 $data4=mysql_fetch_object($req4);
	 $prixA=$data4->prix;	 
	 $prixTItem=$prixA*($qteB*$qteC);
	 $totalTC=$totalTC+$prixTItem;
	 
	 }
     //Cost	 
	 if($statut !="waiting" and $statut !="planned"){
	 
	 $totalItem=0;
     $req2= mysql_query("SELECT * FROM sortie_stock1 where commande= '$PO'");
	 if(mysql_num_rows($req2)>0){
	 while($data2=mysql_fetch_object($req2)){
	 $IDpaquet=$data2->IDpaquet;	 
	 $qte=$data2->qte;	
	 $req3= mysql_query("SELECT * FROM paquet2 where IDpaquet='$IDpaquet'");
	 $data3=mysql_fetch_object($req3);
	 $R=$data3->idRO;	 
	 $article=$data3->IDarticle;
	
	 if($R==""){ //ID reception introuvable
	 $req4= mysql_query("SELECT * FROM article1 where code_article='$article'");
	 $data4=mysql_fetch_object($req4);
	 $prixA=$data4->prix;	 
	 $prixTItem=$prixA*$qte;
	 $totalItem=$totalItem+$prixTItem;
	
	 
	 }else{
	 $req4= mysql_query("SELECT * FROM reception_items where item='$article' and IDreception='$R'");
	 $data4=mysql_fetch_object($req4);
	 $qty=$data4->qty;	 
	 $price=$data4->price;	
	 $prixUItem=$price/$qty;
	 $prixTItem=$prixUItem*$qte;
	 $totalItem=$totalItem+$prixTItem;
	 }
	 }
	 }else{//Pas de sortie stock
	
	 $totalItem=$totalTC;
	 
	 }}else{
	 $totalItem="----";
	 }
	 
	  if($totalItem=="----"){
	  $profit=$prixT-$totalTC;
	 }else{
	 $profit=$prixT-$totalItem;
	 }
	//Affichage
	if($profit >= 0){
	$col="#D8F6CE";
	}else{
	$col="#FD3838";
	}
	if($totalItem=="----"){
	 $P1=$totalTC/$prixT;
	 }else{
	 $P1=$totalItem/$prixT;
	 }
	
	$P2=(1-$P1)*100;
	$P2=round($P2,2);
	
	///
	$aff=0;
	$reqR= mysql_query("SELECT longueur FROM produit1 where code_produit='$produit'");
	$long=mysql_result($reqR,0);
	if($recherche=="cat"){
	
	$reqR= mysql_query("SELECT categorie FROM produit1 where code_produit='$produit'");
	$cat=mysql_result($reqR,0);
	if($cat==$valeur){
	$aff=1;
	}else{
	$aff=0;
	}
	}else if($recherche=="long"){
	
	
	if($long==$valeur){
	$aff=1;
	}else{
	$aff=0;
	}
	}else if($recherche=="item"){
    	
	if($produit==$valeur){
	$aff=1;
	}else{
	$aff=0;
	}
	}else if($recherche=="po"){	
	
	if($PO==$valeur){
	$aff=1;
	}else{
	$aff=0;
	}
	}else{
	$aff=1;
	}
	
	///Partie qui se répéte
	if($aff==1){
	
	 if($statut !="waiting" and $statut !="planned"){
	 $col1="#FAFAFA";
	 }else{
	 $col1="#ECF6CE";
	 }
	 $col2="#FAFAFA";
    echo"<tr ><td  style=\"width:4.1%;height:60px;background-color:".$col2."\" >$i</td>
	<td  style=\"width:10.1%;height:60px;background-color:".$col1."\">$PO</td>
	<td  style=\"width:10.2%;height:60px;background-color:".$col2."\">$dateE</td>
	<td  style=\"width:10.2%;height:60px ;background-color:".$col2."\">$produit</td>
	<td  style=\"width:5.1%;height:60px;background-color:".$col2."\">$long</td>
	<td  style=\"width:9.1%;height:60px ;background-color:".$col2."\">$qteC</td>
	<td  style=\"width:10.1%;height:60px;background-color:#F5ECCE\">$prixT</td>
	<td  style=\"width:10.2%;height:60px;background-color:#F8E0EC\">$totalTC</td>
	<td  style=\"width:10.2%;height:60px ;background-color:#FAB6B6\">$totalItem</td>
	<td  style=\"width:10.1%;height:60px;background-color:".$col."\">$profit</td>
	<td  style=\"width:10.2%;height:60px ;background-color:".$col2."\">$P2 %</td>	";
	//Calcul total 
	$totalProfit=$totalProfit+$profit;
	$totalRevenues=$totalRevenues+$prixT;
	$totalCosts=$totalCosts+$totalItem;
	$i++;
	}
	}
	///////////Fin Partie
	}
	if($totalRevenues != 0){
    $PT1=$totalCosts/$totalRevenues;
	$PT2=(1-$PT1)*100;
	$PT2=round($PT2,2);
	}else{$PT2=0;}
  echo '<tr>
  <td  style=width:30%;height:40px;background-color:#F5ECCE;text-align:right ><b>Total revenues: </b></td>
  <td  style=width:70%;height:40px;background-color:#F5ECCE><b>'.$totalRevenues  .' '.$devise.'</b></td></tr>
  <tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Explicit costs: </b></td>
  <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$totalCosts .' '.$devise.'</b></td></tr>
  <tr><td style=width:30%;height:40px;text-align:right;background-color:#F5A9BC ><b>Gross margin: </b></td><td style=width:70%;height:40px;background-color:#F5A9BC><b>'.$totalProfit .' '.$devise.'</b></td></tr>
  <tr><td style=width:30%;height:40px;text-align:right;background-color:#FAB6B6 ><b>Gross margin %: </b></td><td style=width:70%;height:40px;background-color:#FAB6B6><b> '.$PT2.' %</b></td></tr>
  
  </tbody></table>';
   
  mysql_close();

  ?>