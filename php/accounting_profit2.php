 <?php
include('../connexion/connexionDB.php');
$date1=@$_POST['date1'];
$date2=@$_POST['date2'];
$recherche=@$_POST['recherche'];
$valeur=@$_POST['valeur'];
$R2=@$_POST['R2'];
if($R2=='N'){
    $statut='planned,waiting';
}else if($R2=='P'){
    $statut='in progres,finished,unbilled,closed,incomplete';
}else{
    $statut='incomplete,in progres,finished,unbilled,closed,planned,waiting';
}
if($recherche != "A"){
 $valeur="commande_items.".$valeur;
}
$totalProfit=0;
$totalRevenues=0;
$totalRevenuesTE=0;
$totalRevenuesCS=0;
$totalCosts=0;
$totalQTY=0;  //Total qte
$totalQTYP=0; //total qte produite
$totalQTYTE=0;
$totalQTYCS=0;
$totalWaist=0;
$totalWaistP=0;
$devise="";

echo'<div class="table-responsive" id="divRel">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#TYCO2" data-toggle="tab">CommeScope</a></li>
	  <li><a href="#TE3" data-toggle="tab">TYCO</a></li>
    <li><a href="#CScope" data-toggle="tab">C.SCOPE</a></li>
 </ul>
 <div class="tab-content">

<div class="tab-pane fade in active" id="TYCO2">
<br><br>
  <table class="table table-fixed table-bordered results" id="table3">
<thead style="width:100%">
<tr>

  <th style="width:10%;height:60px" class="degraD2"><b>Purchase order N°</b></th>
  <th style="width:10%;height:60px" class="degraD2"><b>Shipping date</b></th>
  <th style="width:9.5%;height:60px" class="degraD2"><b>Item ID</b></th>  
  <th style="width:5.9%;height:60px" class="degraD2"><b>Qty</b></th>
  <th style="width:5.9%;height:60px" class="degraD2"><b>Produced qty</b></th>
  <th style="width:8%;height:60px" class="degraD2"><b>Revenue</b></th>
  <th style="width:9%;height:60px" class="degraD2"><b>Theoretical costs</b></th>
  <th style="width:9%;height:60px" class="degraD2"><b>Real costs</b></th>
  <th style="width:7%;height:60px" class="degraD2"><b>Waist </b></th>
  <th style="width:7%;height:60px" class="degraD2"><b>Waist %</b></th>
  <th style="width:7%;height:60px" class="degraD2"><b>Gross margin</b></th>
  <th style="width:7%;height:60px" class="degraD2"><b>Gross margin %</b></th>
  </tr></thead><tbody id="tbody2" style="width:100%">'; 
    if($recherche == "A"){
	    //$reqSup= mysql_query("SELECT   commande_items.POitem,commande_items.PO,commande_items.produit,commande_items.qty,commande_items.prixU,commande2.date_exped FROM commande_items INNER JOIN commande2  ON (commande2.PO = commande_items.PO) WHERE (commande2.date_exped >= '$date1') and (commande2.date_exped <= '$date2')");
		$reqSup= mysql_query("SELECT POitem,produit,qty,prixU,dateExp FROM commande_items  WHERE  (dateExp >= '$date1') and (dateExp <= '$date2')");
	}else{
	    $reqSup= mysql_query("SELECT commande_items.POitem,commande_items.PO,commande_items.produit,commande_items.qty,commande_items.prixU,commande2.date_exped FROM commande_items,commande2 where commande2.PO=commande_items.PO and commande2.date_exped >= '$date1' and commande2.date_exped<= '$date2' and $recherche='$valeur'");
	}
//Sortie du magazin 
    $i=1;
    while($a=@mysql_fetch_object($reqSup)){
	    $PO=$a->POitem;	
		$dateE=$a->dateExp;
		$devise='EUR';
		$qteC=$a->qty;        		
		$produit=$a->produit;
		$prixU=$a->prixU;	
		$totalQTY=$totalQTY+$qteC;  //Total qte 
		$prixT=$prixU*$qteC;  //prix total de la qte su commande	
		$req=@mysql_query("SELECT sum(qte) FROM ordre_fabrication1 where PO='$PO'");
		$qteP=@mysql_result($req,0);		
		if($qteP>0){
		    $totalQTYP=$totalQTYP+$qteP ; //total qte produite
            $prixTP=$prixU*$qteP; //prix total de la qte produite
       	}		
	    $totalTCP=0;//theoretical cost for produced qty
	    $totalTC=0;//theoretical cost for produced qty
		$req1= mysql_query("SELECT DISTINCT IDarticle,qte FROM produit_article1 where IDproduit='$produit'");
		while($data1=@mysql_fetch_object($req1)){
	        $qteB=$data1->qte;
		    $article=$data1->IDarticle;
			$req2= mysql_query("SELECT prix FROM article1 where code_article='$article'");
			$prixA=mysql_result($req2,0);
			if($qteP>0){//qte produced
				$prixTPItem=$prixA*($qteB*$qteP);
				$totalTCP=$totalTCP+$prixTPItem;	
            }	
            //toute la qte
            $prixTItem=$prixA*($qteB*$qteC);
		    $totalTC=$totalTC+$prixTItem;			
	    }	
            //Cost	
		if($qteP>0){
			$totalItem=0;
			$req3= mysql_query("SELECT sortie_items.IDpaquet,sortie_items.qte,sortie_items.qteR FROM sortie_items , bande_sortie where (bande_sortie.PO='$PO') and (sortie_items.IDbande=bande_sortie.IDsortie)");
			if(mysql_num_rows($req3)>0){
			    while($data3=mysql_fetch_array($req3)){
				    $IDpaquet=$data3['IDpaquet'];
					$qte=$data3['qte'];
					$qteR=$data3['qteR'];
					$qte=$qte-$qteR;
					$req4=mysql_query("SELECT prixU FROM supplier_invoice_items where IDreception=(select idRO from paquet2 where IDpaquet='$IDpaquet')");
					$prixA=@mysql_result($req4,0);	
					if($prixA== NULL){ //ID reception introuvable
	                    $req5= mysql_query("SELECT prix FROM article1 where code_article=(select IDarticle from paquet2 where IDpaquet='$IDpaquet')");			
			            $prixA=mysql_result($req5,0);
						$prixTItem=$prixA*$qte;
						$totalItem=$totalItem+$prixTItem; 
		            }else{
	                    //$prixA=mysql_result($req4,0);
						$prixTItem=$prixA*$qte;
						$totalItem=$totalItem+$prixTItem;
	                }
	            }
	        }else{//Pas de sortie stock
	            $totalItem="X";
				$col1="#FF8000";
	        }
	    }
	    $profit=$prixT-$totalTC; //théorique 
	    $profitP=$prixTP-$totalTC; //profit réel
	    //Affichage
		$P1=$totalTC/$prixT;
		$P2=(1-$P1)*100;
		$P2=round($P2,2);
	
	if($totalItem=="----"){
	 $W2=0;
	 $W1=0;
	 }else{
	 $W1=$totalItem-$totalTC;
	 $W1=round($W1,2);
	 $W2=$W1/$totalTC;
	 $W2=$W2*100;
	 $W2=round($W2,2);
	 }
	
	if($W1< 0){
	$col="#D8F6CE";
	}else if($W1> 0){
	$col="#F78181";
	}else{
	$col="#F5ECCE";
	}
	
	///Partie qui se répéte
	
	
	
	 $col1="#FAFAFA";
	
	 $col2="#FAFAFA";
    echo"<tr >
	<td  style=\"width:10.1%;height:60px;background-color:".$col1."\">$PO</td>
	<td  style=\"width:10.2%;height:60px;background-color:".$col2."\">$dateE</td>
	<td  style=\"width:9.7%;height:60px ;background-color:".$col2."\">$produit</td>	
	<td  style=\"width:6%;height:60px ;background-color:".$col2."\">$qteC</td>
	<td  style=\"width:6%;height:60px ;background-color:".$col2."\">$qteP</td>
	<td  style=\"width:8.1%;height:60px;background-color:#F5ECCE\">$prixT</td>	
	<td  style=\"width:9.6%;height:60px;background-color:#F8E0EC\">$totalTC</td>	
	<td  style=\"width:9.2%;height:60px ;background-color:#FAB6B6\">$totalItem</td>
	<td  style=\"width:7.2%;height:60px;background-color:".$col."\">$W1</td>
	<td  style=\"width:7.2%;height:60px;background-color:".$col."\">$W2 %</td>
	<td  style=\"width:7.1%;height:60px;background-color:".$col2."\">$profit</td>
	<td  style=\"width:7.2%;height:60px ;background-color:".$col2."\">$P2 %</td>	";
	//Calcul total 
	$totalQTY=$totalQTY+$qteC;
	$totalWaist=$totalWaist+$W1;
	$totalWaistP=$totalWaistP+$W2;
	$totalProfit=$totalProfit+$profit;
	$totalRevenues=$totalRevenues+$prixT;
	$totalCosts=$totalCosts+$totalTC;
	$i++;
	}
	

//TOTAL
    //Pourcentage de perte 
	$totalWaistP=($totalWaist/$totalRevenues)*100;
	//
	if($totalRevenues != 0){
    $PT1=$totalCosts/$totalRevenues;
	$PT2=(1-$PT1)*100;
	$PT2=round($PT2,2);
	}else{$PT2=0;}
	$marginCable=$totalProfit/$totalQTY;
	$marginCable=round($marginCable,2);
	//Format affichage nombre
	$totalQTY = number_format($totalQTY, 2, ',', ' ');
	$totalWaist = number_format($totalWaist, 2, ',', ' ');
	$totalProfit = number_format($totalProfit, 2, ',', ' ');
	$totalRevenues = number_format($totalRevenues, 2, ',', ' ');
	$totalCosts = number_format($totalCosts, 2, ',', ' ');
	
	
	//$totalWaistP=$totalWaistP/$i;
	$totalWaistP=round($totalWaistP,2);
	
  echo '
  
  <tr>
  
  <td style=width:25%;height:40px;text-align:right;background-color:#EFEFFB ><b>Total QTY: </b></td>
  <td style=width:25%;height:40px;background-color:#EFEFFB><b>'.$totalQTY .' </b></td>
  <td style=width:25%;height:40px;text-align:right;background-color:#EFEFFB ><b>Produced QTY: </b></td>
  <td style=width:25%;height:40px;background-color:#EFEFFB><b>'.$totalQTYP .' </b></td>  
  </tr>
  <tr>
  <td style=width:25%;height:40px;text-align:right;background-color:#EFEFFB ><b>Produced QTY: </b></td>
  <td style=width:25%;height:40px;background-color:#EFEFFB><b>'.$totalQTY .' </b></td>
  <td style=width:25%;height:40px;text-align:right;background-color:#EFEFFB ><b>Revenues: </b></td>
  <td style=width:25%;height:40px;background-color:#EFEFFB><b>'.$totalQTY .''.$devise.' </b></td>  
  </tr>
  <tr>
  <td  style=width:30%;height:40px;background-color:#F5ECCE;text-align:right ><b>Total revenues: </b></td>
  <td  style=width:70%;height:40px;background-color:#F5ECCE><b>'.$totalRevenues  .' '.$devise.'</b></td></tr>
  <tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Component cost: </b></td>
  <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$totalCosts .' '.$devise.'</b></td></tr>
  <tr><td style=width:30%;height:40px;text-align:right;background-color:#E0F2F7 ><b>Gross margin: </b></td><td style=width:70%;height:40px;background-color:#E0F2F7><b>'.$totalProfit .' '.$devise.'</b></td></tr>
  <tr><td style=width:30%;height:40px;text-align:right;background-color:#FAB6B6 ><b>Gross margin %: </b></td><td style=width:70%;height:40px;background-color:#FAB6B6><b> '.$PT2.' %</b></td></tr>
  <tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Average margin/cable: </b></td>
  <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$marginCable .' EUR</b></td></tr>
    <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Waisted cost: </b></td>
  <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$totalWaist .' '.$devise.'</b></td></tr>
  <tr><td style=width:30%;height:40px;text-align:right;background-color:#F5A9BC ><b>Waisted cost (%): </b></td><td style=width:70%;height:40px;background-color:#F5A9BC><b>'.$totalWaistP .' %</b></td></tr>
  </tbody></table></div>';
//FIN ALL	
	

//FIN TYCO2

//DEBUT TE3
echo'<div class="tab-pane" id="TE3">
<br><br>
  <table class="table table-fixed table-bordered results">
<thead style="width:100%">
<tr>

   <th style="width:19.8%;height:60px" class="degraD2"><b>Purchase order N°</b></th>
  <th style="width:19.8%;height:60px" class="degraD2"><b>Shipping date</b></th>
  <th style="width:19.6%;height:60px" class="degraD2"><b>Item ID</b></th>
  <th style="width:9.7%;height:60px" class="degraD2"><b>Lgth</b></th>
  <th style="width:14.7%;height:60px" class="degraD2"><b>Qty</b></th>
  <th style="width:14.8%;height:60px" class="degraD2"><b>Revenue</b></th>
  </tr></thead><tbody id="tbody2" style="width:100%">';
 
  
  $req= mysql_query("SELECT * FROM commande2 where date_exped >= '$date1' and date_exped<= '$date2' and client ='TE 3'");
$i=1;
  while($a=@mysql_fetch_object($req)){
	$PO=$a->PO;	 
	$dateE=$a->date_exped;	
	$devise='EUR';
	//selection des commandes
	
	$req1= mysql_query("SELECT * FROM commande_items where PO='$PO'");
	
	while($data=mysql_fetch_object($req1))
    {	 
     $PO=$data->PO;	 
     $qteC=$data->qty;	 
	 $prixT=$data->prixT;	
	 $produit=$data->produit;
	 $statut=$data->statut;	
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
	 $col1="#ECF6CE";	 
	 $col2="#FAFAFA";
    echo"<tr >
	<td  style=\"width:20%;height:60px;background-color:".$col1."\">$PO</td>
	<td  style=\"width:20%;height:60px;background-color:".$col2."\">$dateE</td>
	<td  style=\"width:20%;height:60px ;background-color:".$col2."\">$produit</td>
	<td  style=\"width:10%;height:60px;background-color:".$col2."\">$long</td>
	<td  style=\"width:15%;height:60px ;background-color:".$col2."\">$qteC</td>
	<td  style=\"width:15%;height:60px;background-color:#F5ECCE\">$prixT</td>
		";
	//Calcul total 
	$totalQTYTE=$totalQTYTE+$qteC;

	$totalRevenuesTE=$totalRevenuesTE+$prixT;
	
	$i++;
	}
	}
	///////////Fin Partie
	}
	
	//Format affichage nombre
	$totalQTYTE = number_format($totalQTYTE, 2, ',', ' ');
	$totalRevenuesTE = number_format($totalRevenuesTE, 2, ',', ' ');	
    echo '<tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#EFEFFB ><b>Total QTY: </b></td>
  <td style=width:70%;height:40px;background-color:#EFEFFB><b>'.$totalQTYTE .' </b></td></tr>
  <tr>
  <td  style=width:30%;height:40px;background-color:#F5ECCE;text-align:right ><b>Total revenues: </b></td>
  <td  style=width:70%;height:40px;background-color:#F5ECCE><b>'.$totalRevenuesTE  .' '.$devise.'</b></td></tr>
  
  </tbody></table></div>';
  
  //DEBUT CScope
echo'<div class="tab-pane"  id="CScope">
<br><br>
  <table class="table table-fixed table-bordered results">
<thead style="width:100%">
<tr>

  <th style="width:19.8%;height:60px" class="degraD2"><b>Purchase order N°</b></th>
  <th style="width:19.8%;height:60px" class="degraD2"><b>Shipping date</b></th>
  <th style="width:19.6%;height:60px" class="degraD2"><b>Item ID</b></th>
  <th style="width:9.7%;height:60px" class="degraD2"><b>Lgth</b></th>
  <th style="width:14.7%;height:60px" class="degraD2"><b>Qty</b></th>
  <th style="width:14.8%;height:60px" class="degraD2"><b>Revenue</b></th>
  </tr></thead><tbody id="tbody2" style="width:100%">';
  
  $req= mysql_query("SELECT * FROM commande2 where date_exped >= '$date1' and date_exped<= '$date2' and client = 'C.SCOPE'");
  $i=1;
  while($a=@mysql_fetch_object($req)){
	$PO=$a->PO;	 
	$dateE=$a->date_exped;	
	$devise='EUR';
	//selection des commandes
	
	$req1= mysql_query("SELECT * FROM commande_items where PO='$PO'");
	
	while($data=mysql_fetch_object($req1))
    {	 
     $PO=$data->PO;	 
     $qteC=$data->qty;	 
	 $prixT=$data->prixT;	
	 $produit=$data->produit;
	 $statut=$data->statut;	
	///
	$aff=0;

	if($recherche=="cat"){	
	$reqR= mysql_query("SELECT categorie FROM produit1 where code_produit='$produit'");
	$cat=mysql_result($reqR,0);
	if($cat==$valeur){
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
	 $col1="#ECF6CE";	 
	 $col2="#FAFAFA";
    echo"<tr >
	<td  style=\"width:20%;height:60px;background-color:".$col1."\">$PO</td>
	<td  style=\"width:20%;height:60px;background-color:".$col2."\">$dateE</td>
	<td  style=\"width:20%;height:60px ;background-color:".$col2."\">$produit</td>
	<td  style=\"width:10%;height:60px;background-color:".$col2."\">-----</td>
	<td  style=\"width:15%;height:60px ;background-color:".$col2."\">$qteC</td>
	<td  style=\"width:15%;height:60px;background-color:#F5ECCE\">$prixT</td>
		";
	//Calcul total 
	$totalQTYCS=$totalQTYCS+$qteC;

	$totalRevenuesCS=$totalRevenuesCS+$prixT;
	
	$i++;
	}
	}
	///////////Fin Partie
	}
	
	//Format affichage nombre
	$totalQTYCS = number_format($totalQTYCS, 2, ',', ' ');
	$totalRevenuesCS = number_format($totalRevenuesCS, 2, ',', ' ');	
  echo '
  <tr>
  <td style=width:30%;height:40px;text-align:right;background-color:#EFEFFB ><b>Total QTY: </b></td>
  <td style=width:70%;height:40px;background-color:#EFEFFB><b>'.$totalQTYCS .' </b></td></tr>
  <tr>
  <td  style=width:30%;height:40px;background-color:#F5ECCE;text-align:right ><b>Total revenues: </b></td>
  <td  style=width:70%;height:40px;background-color:#F5ECCE><b>'.$totalRevenuesCS.' GBP</b></td></tr>
  
  </tbody></table></div></div></div>';
	
	mysql_close();  
  ?>