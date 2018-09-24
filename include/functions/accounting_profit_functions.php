 <?php
 //Affichage ligne
 function afficheLigne($col1,$OF,$PO,$dateE,$produit,$qty,$revenue,$theo_coast,$theo_coast2,$real_coast,$waist,$waistP,$gross,$grossP,$averageC){
    if($waist< 0){
	$col="#D8F6CE";
	}else if($waist> 0){
	$col="#F78181";
	}else{
	$col="#F5ECCE";
	}

     echo"<tr >
	<td  style=\"width:10.1%;height:60px;background-color:".$col1."\">$PO</td>
	<td  style=\"width:10.2%;height:60px;background-color:".$col1."\">$dateE</td>
	<td  style=\"width:10.2%;height:60px ;background-color:".$col1."\">$produit</td>
	<td  style=\"width:6.1%;height:60px ;background-color:".$col1."\">$qty</td>
	<td  style=\"width:8.1%;height:60px;background-color:#F5ECCE\">$revenue</td>
	<td  style=\"width:9.6%;height:60px;background-color:#F8E0EC\"><b>$theo_coast</b> / $theo_coast2</td>	";
 if($OF != "X"){
   	echo "<td  style=\"width:9.2%;height:60px ;background-color:#FAB6B6\" onClick=rapport_sortie('".$OF."','".$dateE."')>$real_coast</td>";
 }else{
  	echo "<td  style=\"width:9.2%;height:60px ;background-color:#FAB6B6\" >$real_coast</td>";
 }

	echo "<td  style=\"width:7.2%;height:60px;background-color:".$col."\">$waist</td>
	<td  style=\"width:8.2%;height:60px;background-color:".$col."\">$waistP %</td>
	<td  style=\"width:8.1%;height:60px;background-color:".$col1."\">$gross</td>
	<td  style=\"width:8.2%;height:60px ;background-color:".$col1."\">$grossP %</td>
    <td  style=\"width:4.6%;height:60px;background-color:".$col1."\">$averageC</td>	";

 }
 /*
//Affichage ligne théorique
function afficheLigneTheo($col1,$OF,$PO,$dateE,$produit,$qty,$revenue,$theo_coast,$theo_coast2,$gross,$grossP,$averageC){
 
     echo"<tr >
	<td  style=\"width:10.1%;height:60px;background-color:".$col1."\">$PO</td>
	<td  style=\"width:10.2%;height:60px;background-color:".$col1."\">$dateE</td>
	<td  style=\"width:10.2%;height:60px ;background-color:".$col1."\">$produit</td>
	<td  style=\"width:6.1%;height:60px ;background-color:".$col1."\">$qty</td>
	<td  style=\"width:8.1%;height:60px;background-color:#F5ECCE\">$revenue</td>
	<td  style=\"width:9.6%;height:60px;background-color:#F8E0EC\"><b>$theo_coast</b> / $theo_coast2</td>

	<td  style=\"width:8.1%;height:60px;background-color:".$col1."\">$gross</td>
	<td  style=\"width:8.2%;height:60px ;background-color:".$col1."\">$grossP %</td>
    <td  style=\"width:4.6%;height:60px;background-color:".$col1."\">$averageC</td>	";

 }*/
 //Calcul revenue
function calcul_revenue($prixU,$qty){
   $result=$prixU*$qty;
   $result=round($result,2);
   return $result;
}
//Calcul coast théorique
function calcul_theo_coast($produit,$qty,$dateE){
     $totalTC=0;
	 $req= mysql_query("SELECT DISTINCT IDarticle,qte FROM produit_article1 where IDproduit='$produit'");
	 while($data=@mysql_fetch_object($req)){
	 $qteB=$data->qte;
	 $article=$data->IDarticle;
 /* $req1=mysql_query("SELECT ancien_prix FROM update_prices_item where item='$article' and dateM > '$dateE' and etat ='Y' order by dateM DESC");
  if(mysql_num_rows($req1)>0){
   $prixA=mysql_result($req1,0);
  }else{*/
   $req2= mysql_query("SELECT prix FROM article1 where code_article='$article'");
	  $prixA=mysql_result($req2,0);
  //}

	 $prixTItem=$prixA*($qteB*$qty);
	 $totalTC=$totalTC+$prixTItem;
	 }
	 $totalTC=round($totalTC,2);
	 return $totalTC;
}
//
//Calcul coast théorique
function calcul_theo_coast2($produit,$qty,$dateE){
     $totalTC=0;
	 $req= mysql_query("SELECT DISTINCT IDarticle,qte FROM produit_article1 where IDproduit='$produit'");
	 while($data=@mysql_fetch_object($req)){
	 $qteB=$data->qte;
	 $article=$data->IDarticle;

   $req2= mysql_query("SELECT prix FROM article1 where code_article='$article'");
	 $prixA=mysql_result($req2,0);

	 $prixTItem=$prixA*($qteB*$qty);
	 $totalTC=$totalTC+$prixTItem;
	 }
	 $totalTC=round($totalTC,2);
	 return $totalTC;
}
//Calcul Real coast
function calcul_real_coast($OF){
     $totalItem=0;
     $req=@mysql_query("SELECT IDpaquet,qte FROM sortie_items  where IDbande IN (SELECT IDsortie FROM bande_sortie where OF='$OF') and rebut ='N'");
	 //if(mysql_num_rows($req)>0){
	    while($data=@mysql_fetch_array($req)){
	      $IDpaquet=$data['IDpaquet'];
	      $qte=$data['qte'];
	      $req1= mysql_query("SELECT idRO,IDarticle FROM paquet2 where IDpaquet='$IDpaquet'");
	      $data1=mysql_fetch_object($req1);
	      $recep=$data1->idRO;
	      $article=$data1->IDarticle;
	      $req2= mysql_query("SELECT unit_price FROM supplier_invoice_items where IDitem='$article' and IDreception='$recep'");
       // $req2= mysql_query("SELECT prix FROM article1 where code_article='$article'");
        $prixU=@mysql_result($req2,0);
        $totalItem=$totalItem+($prixU*$qte);

	    }
	 //}
	 $totalItem=round($totalItem,2);
	 return $totalItem;
}
//Calcul waist
function calcul_waist($theoC,$realC){
  $result=$theoC-$realC;
  $result=round($result,2);
  return $result;
}
//Calcul waist pourcentage
function calcul_waistP($waist,$theoC){
     $result=0;
     if($theoC>0){
	   $result=($waist/$theoC)*100;
	   $result=round($result,2);
	 }
	 return $result;
}
//Calcul gross margin
function calcul_gross_margin($revenue,$real_coast){
     $result=$revenue-$real_coast;
	 $result=round($result,2);
	 return $result;
}
//Calcul gross margin  pourcentage
function calcul_gross_marginP($real_coast,$revenue){
	$result=(1-($real_coast/$revenue))*100;
	$result=round($result,2);
	return $result;

}
//Calcul average per cable
function calcul_averageC($revenue,$qty){
	$result=$revenue/$qty;
	$result=round($result,2);
	return $result;

}
///Calcul tottal longueur
//Calcul coast théorique
function calcul_long($produit,$qty){

	 $reqL= mysql_query("SELECT longueur FROM produit1 where code_produit='$produit'");
  $long=@mysql_result($reqL,0);
  return $long*$qty;

}

 ?>
