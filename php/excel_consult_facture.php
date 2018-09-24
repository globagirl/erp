<meta charset="utf-8" />
 <?php

  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");

// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=factures.xls");
include('../connexion/connexionDB.php');
$valeur=$_POST['valeur'];
$recherche=$_POST['recherche'];
$recherche2=$_POST['recherche2'];
$statut=$_POST['statut'];
$dateD=@$_POST['dateD'];
$dateF=@$_POST['dateF'];
$totVal=0;
if ($recherche=="a"){
    $req= "SELECT num_fact,client,tot_val,devise,date_E,statut FROM fact1 where statut ='$statut' order by num_fact DESC  ";
}else if (($recherche == "client") or ($recherche == "date_E")or ($recherche == "num_fact")) {
    if($statut=="A"){
       if($dateD != "" && $dateF != ""){
          $req= "SELECT num_fact,client,tot_val,devise,date_E,date_pay,statut FROM fact1 where $recherche LIKE '$valeur' and $recherche2 >= '$dateD' and $recherche2 <= '$dateF' order by num_fact DESC";
       }else{
         $req= "SELECT num_fact,client,tot_val,devise,date_E,date_pay,statut FROM fact1 where $recherche LIKE '$valeur' order by num_fact DESC";
       }

	   }else{
       if($dateD != "" && $dateF != ""){
         $req= "SELECT num_fact,client,tot_val,devise,date_E,date_pay,statut FROM fact1 where statut ='$statut' and  $recherche='$valeur' and $recherche2 >= '$dateD' and $recherche2 <= '$dateF' order by num_fact DESC";
       }else{
         $req= "SELECT num_fact,client,tot_val,devise,date_E,date_pay,statut FROM fact1 where statut ='$statut' and  $recherche='$valeur' order by num_fact DESC";
       }

	   }
}else{
    $req1= mysql_query("SELECT DISTINCT idF FROM fact_items where $recherche LIKE '%$valeur%' order by idF DESC");
	   $req= "x";
}


echo '<table  class="table table-fixed table-bordered results" id="table3">
												    <thead style="width:100%">
			                                        <tr>
													<th style="width:9.8%;height:60px" class="degraD">N° facture</th>

													<th style="width:12.8%;height:60px" class="degraD">Client</th>
													<th style="width:11.8%;height:60px" class="degraD">Date expédition</th>
				                                    <th style="width:14.8%;height:60px" class="degraD">PO</th>
													<th style="width:12.9%;height:60px" class="degraD">Produit</th>
													<th style="width:9.9%;height:60px" class="degraD">Qty</th>
														<th style="width:9.9%;height:60px" class="degraD">Prix Unitaire</th>
														<th style="width:9.9%;height:60px" class="degraD">Nouveau Prix</th>
													<th style="width:9.9%;height:60px" class="degraD">Total</th>
													<th style="width:9.9%;height:60px" class="degraD">Nouveau Total</th>
													<th style="width:9.9%;height:60px" class="degraD">Statut</th>

			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">';
if($req=="x"){
 while($data=mysql_fetch_object($req1)){
 $F=$data->idF;
 if($statut=="A"){
    $req= "SELECT num_fact,client,tot_val,devise,date_E,date_pay,statut FROM fact1 where num_fact='$F'";
 }else{
    $req= "SELECT num_fact,client,tot_val,devise,date_E,date_pay,statut FROM fact1 where num_fact='$F' and statut ='$statut'";
 }
 $r=mysql_query($req) or die(mysql_error());

  while($a=mysql_fetch_object($r)){
    $num = $a->num_fact;
    $client = $a->client;
		$stat = $a->statut;
		$dateP= $a->date_pay;
	$t = $a->tot_val;
  $t2=str_replace(".",",",$t);
	$devise = $a->devise;
	$dateE= $a->date_E;
	$req11= mysql_query("SELECT nomClient FROM client1 where name_client='$client'");
	$clt=mysql_result($req11,0);
	if($stat=="unpaid"){
	$col="#F6CECE";
	}else{
	$col="#E0F8F1";
	}
	$req2= mysql_query("SELECT produit,PO,qty,prixU FROM fact_items where idF='$num'");
	while($a1=mysql_fetch_object($req2))
    {
	$prd=$a1->produit;
	$po=$a1->PO;
	$qtu=$a1->qty;
  $prixU=$a1->prixU;
 $totVal=$totVal+$t;

 //Prix systéme
 $sq=mysql_query("select price from prices where IDproduit='$prd' and marginL='1' and marginH='-1'");
 $prixNv=@mysql_result($sq,0);
 $totalNv=$prixNv*$qtu;
 $totalNv=round($totalNv,3);
 $totalNv=str_replace(".",",",$totalNv);
        echo'<tr><td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$num.'</td>

		<td style="width:13%;height:60px;text-align:center;background-color:'.$col.'">'.$clt.'</td>
		<td style="width:12%;height:60px;text-align:center;background-color:'.$col.'">'.$dateE.'</td>
		<td style="width:15%;height:60px;text-align:center;background-color:'.$col.'">'.$po.'</td>
		<td style="width:13%;height:60px;text-align:center;background-color:'.$col.'">'.$prd.'</td>
		<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$qtu.'</td>
		<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$prixU.'</td>
		<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$prixNv.'</td>
		<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$t2.'</td>
		<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$totalNv.'</td>
		<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$dateP.'</td>
		<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$stat.'</td>';

    }
	}
 }
}else{
  $r=mysql_query($req) or die(mysql_error());
  while($a=mysql_fetch_object($r)){
    $num = $a->num_fact;
		$client = $a->client;
		$dateP= $a->date_pay;
	  $t = $a->tot_val;
  $t2=str_replace(".",",",$t);
	$devise = $a->devise;
	$dateE= $a->date_E;
	$stat = $a->statut;
	$req11= mysql_query("SELECT nomClient FROM client1 where name_client='$client'");
	$clt=mysql_result($req11,0);
	if($stat=="unpaid"){
	$col="#F6CECE";
	}else{
	$col="#E0F8F1";
	}
	$req2= mysql_query("SELECT produit,PO,qty,prixU FROM fact_items where idF='$num'");
	while($a1=mysql_fetch_object($req2))
    {
	$prd=$a1->produit;
	$po=$a1->PO;
	$qtu=$a1->qty;
   $prixU=$a1->prixU;
		$totVal=$totVal+$t;
		//Prix systéme
 $sq=mysql_query("select price from prices where IDproduit='$prd' and marginL='1' and marginH='-1'");
 $prixNv=@mysql_result($sq,0);
 $totalNv=$prixNv*$qtu;
 $totalNv=round($totalNv,3);
 $totalNv=str_replace(".",",",$totalNv);
    echo'<tr><td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$num.'</td>

			<td style="width:13%;height:60px;text-align:center;background-color:'.$col.'">'.$clt.'</td>
			<td style="width:12%;height:60px;text-align:center;background-color:'.$col.'">'.$dateE.'</td>
			<td style="width:15%;height:60px;text-align:center;background-color:'.$col.'">'.$po.'</td>
			<td style="width:13%;height:60px;text-align:center;background-color:'.$col.'">'.$prd.'</td>
			<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$qtu.'</td>
			<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$prixU.'</td>
			<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$prixNv.'</td>
			<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$t2.'</td>
			<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$totalNv.'</td>
			<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$dateP.'</td>
			<td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$stat.'</td>';

    }
    }
	}
  echo '<tr><td>Total valeur</td><td>'.$totVal.'</td></tr></tbody></table>';
  mysql_close();
  ?>
