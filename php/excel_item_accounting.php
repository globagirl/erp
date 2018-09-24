<meta charset="utf-8" />
 <?php
 // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=item_accounting.xls");
include('../connexion/connexionDB.php');

$recherche=@$_POST['recherche'];
$valeur=@$_POST['valeur'];
$totalProfit=0;
$totalRevenues=0;
$totalCosts=0;
$note="";
$devise="";


  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr style=text-align:center><th style=text-align:center><b>N°</b></th>
  
  <th style=text-align:center><b>Item ID</b></th>
  <th style=text-align:center><b>Category</b></th>
  <th style=text-align:center><b>Length</b></th> 
  <th style=text-align:center><b>Price</b></th> 
  <th style=text-align:center><b>Explicit costs</b></th>
  <th style=text-align:center><b>Gross margin</b></th>
  <th style=text-align:center><b>Gross margin %</b></th>

  </tr>';
  $i=1;
 
	//selection des commandes
	if($recherche=="long"){
	$req= "SELECT * FROM produit1 where longueur='$valeur'";
	}else if($recherche=="item"){
	$req="SELECT * FROM produit1 where code_produit LIKE '%$valeur%'";
	}else if($recherche=="cat"){
	$req="SELECT * FROM produit1 where categorie='$valeur'";
	}else if($recherche=="a"){
	$req="SELECT * FROM produit1";
	}
	$r=mysql_query($req) or die(mysql_error());
	while($data=mysql_fetch_object($r))
    {
		
	 $produit=$data->code_produit;
	 $cat=$data->categorie;
	 $long=$data->longueur;
	 
     //Al taklifa	 
	 $totalItem=0;	
	 $req3= mysql_query("SELECT DISTINCT IDarticle,qte FROM produit_article1 where IDproduit='$produit'");
	 while($data3=@mysql_fetch_object($req3)){
	 $qteB=$data3->qte;	 
	 $article=$data3->IDarticle;
	
	 $req4= mysql_query("SELECT * FROM article1 where code_article='$article'");
	 $data4=mysql_fetch_object($req4);
	 $prixA=$data4->prix;	 
	 $prixTItem=$prixA*$qteB;
	 $totalItem=$totalItem+$prixTItem;
	  }
	  ///Prix produit
	  	 $reqPrix= mysql_query("SELECT price FROM prices where IDproduit='$produit'");
	     $prixT=@mysql_result($reqPrix,0);
		 
		 if(($prixT != null) and ($totalItem != 0)){
	  //Profit
	 $profit=$prixT-$totalItem;
	//Affichage
	if($profit >= 0){
	$col="#D8F6CE";
	}else{
	$col="#F5A9BC";
	}
	$P1=$totalItem/$prixT;
	$P2=(1-$P1)*100;
	$P2=round($P2,2);
	//
	
	
	///Partie qui se répéte

    echo"<tr ><td  style=\"text-align:center\" >$i</td>

	<td  style=\"text-align:center \">$produit</td>
	<td  style=\"text-align:center \">$cat</td>
	<td  style=\"text-align:center \">$long</td>
	<td  style=\"text-align:center ;background-color:#F5ECCE\">$prixT</td>
	<td  style=\"text-align:center ;background-color:#F8E0EC\">$totalItem</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$profit</td>
    <td  style=\"text-align:center \">$P2 %</td>
	";
	//Calcul total 
	$totalProfit=$totalProfit+$profit;
	$totalRevenues=$totalRevenues+$prixT;
	$totalCosts=$totalCosts+$totalItem;
	$i++;
	}
	}
    
	if($totalRevenues != 0){
    $PT1=$totalCosts/$totalRevenues;
	$PT2=(1-$PT1)*100;
	$PT2=round($PT2,2);
	}else{$PT2=0;}
  echo '<tr><td colspan=3 style=text-align:right;background-color:#F5ECCE ><b>Total revenues : </b></td><td colspan=3 style=background-color:#F5ECCE><b>'.$totalRevenues  .' '.$devise.'</b></td></tr>
  <tr><td colspan=3 style=text-align:right;background-color:#F8E0EC ><b>Explicit costs : </b></td><td colspan=3 style=background-color:#F8E0EC><b>'.$totalCosts .' '.$devise.'</b></td></tr>
  <tr><td colspan=3 style=text-align:right;background-color:#F5A9BC ><b>Gross margin : </b></td><td colspan=3 style=background-color:#F5A9BC><b>'.$totalProfit .' '.$devise.'</b></td></tr>
  <tr><td colspan=3 style=text-align:right;background-color:#FAB6B6 ><b>Gross margin % :</b></td><td colspan=3 style=background-color:#FAB6B6><b> '.$PT2.' %</b></td></tr>
  </thead></table><hr>';
 


  ?>