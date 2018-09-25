<?php
include('../connexion/connexionDB.php');
$date1=@$_POST['date1'];
$date2=@$_POST['date2'];
$recherche=@$_POST['recherche'];
$valeur=@$_POST['valeur'];
$totalProfit=0;
$totalRevenues=0;
$totalCosts=0;
$totalQty=0;
$note="";
$devise="";
$req= "SELECT * FROM commande2 where date_exped >= '$date1' and date_exped<= '$date2'";
$r=mysql_query($req) or die(mysql_error());
echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr style=text-align:center><th style=text-align:center><b>N°</b></th>
      <th style=text-align:center><b>Purchase order N°</b></th>
      <th style=text-align:center><b>Shipping date</b></th>
      <th style=text-align:center><b>Item ID</b></th>
      <th style=text-align:center><b>Length</b></th>
      <th style=text-align:center><b>Qty</b></th>
      <th style=text-align:center><b>Revenue</b></th>
      <th style=text-align:center><b>Explicit costs</b></th>
      <th style=text-align:center><b>Gross margin</b></th>
      <th style=text-align:center><b>Gross margin %</b></th>
      </tr>';
$i=1;
while($a=@mysql_fetch_object($r)){
    $PO=$a->PO;
    $dateE=$a->date_exped;
    $devise=$a->devise;
    //selection des commandes
    $req1= mysql_query("SELECT * FROM commande_items where PO='$PO' and statut !='closed'");
    while($data=mysql_fetch_object($req1))
    {
        $POitem=$data->POitem;
        $prixT=$data->prixT;
        $produit=$data->produit;
        $qte=$data->qty;
        //Al taklifa
        $totalItem=0;
        $req3= mysql_query("SELECT DISTINCT IDarticle,qte FROM produit_article1 where IDproduit='$produit'");
        while($data3=@mysql_fetch_object($req3)){
            $qteB=$data3->qte;
            $article=$data3->IDarticle;
            $req4= mysql_query("SELECT * FROM article1 where code_article='$article'");
            $data4=mysql_fetch_object($req4);
            $prixA=$data4->prix;
            $prixTItem=$prixA*($qte*$qteB);
            $totalItem=$totalItem+$prixTItem;
        }
        $profit=$prixT-$totalItem;
        //Affichage
        $reqR= mysql_query("SELECT longueur FROM produit1 where code_produit='$produit'");
        $long=mysql_result($reqR,0);
        if($profit >= 0){
            $col="#D8F6CE";
        }else{
            $col="#F5A9BC";
        }
        $P1=$totalItem/$prixT;
        $P2=(1-$P1)*100;
        $P2=round($P2,2);
        //
        $aff=0;
        if($recherche=="cat"){
            $note="";
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
            echo"<tr ><td  style=\"text-align:center\" >$i</td>
                <td  style=\"text-align:center \">$PO</td>
                <td  style=\"text-align:center \">$dateE</td>
                <td  style=\"text-align:center \">$produit</td>
                <td  style=\"text-align:center \">$long</td>
                <td  style=\"text-align:center \">$qte</td>
                <td  style=\"text-align:center ;background-color:#F5ECCE\">$prixT</td>
                <td  style=\"text-align:center ;background-color:#F8E0EC\">$totalItem</td>
                <td  style=\"text-align:center ;background-color:".$col."\">$profit</td>
                <td  style=\"text-align:center \">$P2 %</td>";
            //Calcul total
            $totalProfit=$totalProfit+$profit;
            $totalRevenues=$totalRevenues+$prixT;
            $totalCosts=$totalCosts+$totalItem;
            $totalQty=$totalQty+$qte;
            $i++;
        }
    }
}
if($totalRevenues != 0){
    $PT1=$totalCosts/$totalRevenues;
    $PT2=(1-$PT1)*100;
    $PT2=round($PT2,2);
}else{$PT2=0;}
echo '<tr><td colspan=3 style=text-align:right;background-color:#E6E0F8 ><b>Total Qty : </b></td><td colspan=3 style=background-color:#E6E0F8><b>'.$totalQty  .'</b></td></tr>
  <tr><td colspan=3 style=text-align:right;background-color:#F5ECCE ><b>Total revenues : </b></td><td colspan=3 style=background-color:#F5ECCE><b>'.$totalRevenues  .' '.$devise.'</b></td></tr>
  <tr><td colspan=3 style=text-align:right;background-color:#F8E0EC ><b>Explicit costs : </b></td><td colspan=3 style=background-color:#F8E0EC><b>'.$totalCosts .' '.$devise.'</b></td></tr>
  <tr><td colspan=3 style=text-align:right;background-color:#F5A9BC ><b>Gross margin : </b></td><td colspan=3 style=background-color:#F5A9BC><b>'.$totalProfit .' '.$devise.'</b></td></tr>
  <tr><td colspan=3 style=text-align:right;background-color:#FAB6B6 ><b>Gross margin % :</b></td><td colspan=3 style=background-color:#FAB6B6><b> '.$PT2.' %</b></td></tr>
  </thead></table><hr>';
?>