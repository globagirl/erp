<?php
include('../connexion/connexionDB.php');
$IDproduit=@$_POST['IDproduit'];
//Déterminer les nomenclature d'un produit 
$req1=mysql_query ("SELECT * FROM produit_article1 where IDproduit='$IDproduit'");
$i=0;
$artPRD=array();
while($a=@mysql_fetch_object($req1)){
    $article =$a->IDarticle;
    $i++;
    $artPRD[1][$i]=$article;
}
echo '<thead><tr>';
//Affichage TR ID article
for ($nbr =1; $nbr <= $i; $nbr++){
    $art =$artPRD[1][$nbr];
    echo '<th style="width:270px;height:40px"  class="col-md-3">
				<center>'.$art.'</center></th>';
}
echo '</tr><tr>';
//Affichage TR STOCK
for ($nbr =1; $nbr <= $i; $nbr++){
    $art =$artPRD[1][$nbr];
    $req01=mysql_query ("SELECT * FROM article_prevision where idART='$art'");
    $a01=mysql_fetch_object($req01);

    $stockART =$a01->stockART;
    $artPRD[2][$nbr]=$stockART;
    $num =$a01->numART;
    echo '<th style="height:40px;width:270px"  class="col-md-3"><center><input type="text"  value="'.$stockART.'"size="10"READONLY><input type="button" value="+" onClick="addStock()"><input type="button" value="Reset" onClick="resetStock()"></center></th>';
}
echo '</tr><tr>';
//Affichage TR IN/OUT/STOCK
for ($nbr =1; $nbr <= $i; $nbr++){
    echo '<th style="height:30px;width:90px" class="col-md-1">IN</th>
				<th style="height:30px;width:90px" class="col-md-1">OUT</th>
				<th style="height:30px;width:90px" class="col-md-1">Stock</th>';
} //
echo '   </tr></thead><tbody>';
$reqD1= mysql_query("SELECT max(date_exped) FROM commande2 ");
$reqD2= mysql_query("SELECT  max(date_demand_starz) FROM ordre_achat2 ");
$dateMaxC=mysql_result($reqD1,0);
$dateMaxO=mysql_result($reqD2,0);
if($dateMaxC > $dateMaxO){
    $dateMax=$dateMaxC;
}else{
    $dateMax=$dateMaxO;
}
$dateJ=date('Y-m-d');
while($dateMax >= $dateJ){
    //Les ordres d'achat
    $req4= mysql_query("SELECT * FROM ordre_achat2 where date_demand_starz='$dateJ' and statut='waiting'");
    while($a4=mysql_fetch_object($req4))
    {
        $IDordre=$a4->IDordre;
        $date_crt=$a4->date_creation;
        $date_demand=$a4->date_demand_starz;
        $fournisseur=$a4->fournisseur;

        if($fournisseur=="TYCO ELECTRONIC LOGI"){
            for ($nbr =1; $nbr <= $i; $nbr++){
                $art =$artPRD[1][$nbr];
                $stockART =$artPRD[2][$nbr];
                echo('<tr>');
                $req42= mysql_query("SELECT * FROM ordre_achat_article1 where IDordre ='$IDordre' and IDarticle='$art'");
                if(mysql_num_rows($req42)>0){
                    $a42=mysql_fetch_object($req42);
                    $qteD=$a42->qte_demande;
                    $stockART=$stockART+$qteD;
                    $artPRD[2][$nbr]= $stockART;
                    echo('<td style="background-color:#F6CECE;text-align:center;width:90px" class="col-md-1">'.$qteD.'</td>
	<td style="background-color:#F6CECE;text-align:center;width:90px" class="col-md-1">0</td>
	<td style="background-color:#F6CECE;text-align:center;width:90px" class="col-md-1">'.$stockART.'</td>');
                }
                else{
                    echo('<td style="background-color:#FBF5EF;text-align:center;90px" class="col-md-1">0</td>
	<td style="background-color:#FBF5EF;text-align:center;width:90px" class="col-md-1">0</td>
	<td style="background-color:#FBF5EF;text-align:center;width:90px" class="col-md-1">'.$stockART.'</td>');
                }
                echo('</tr>');
            }
        }
    }
    //Les commande
    $req2= mysql_query("SELECT * FROM commande2 where date_exped='$dateJ'");
    while($a2=mysql_fetch_object($req2))
    {
        $PO=$a2->PO;
        $date_ent=$a2->date_ent_cmd;
        $date_exped=$a2->date_exped;
        $req3= mysql_query("SELECT * FROM commande_items where PO='$PO'");
        $data=mysql_fetch_array($req3);
        $prd=$data['produit'];
        $qty=$data['qty'];
        for ($nbr =1; $nbr <= $i; $nbr++){
            $art =$artPRD[1][$nbr];
            $stockART =$artPRD[2][$nbr];
            echo('<tr>');
            $req42= mysql_query("SELECT * FROM produit_article1 where IDproduit ='$prd' and IDarticle='$art'");
            if(mysql_num_rows($req42)>0){
                $a42=mysql_fetch_object($req42);
                $qteB=$a42->qte;
                $qteS=$qteB*$qty;
                $stockART=$stockART-$qteS;
                $artPRD[2][$nbr]= $stockART;
                if($stockART<0){
                    $col="#F7819F";
                }else{
                    $col="#81BEF7";
                }
                echo('<td  style="text-align:center ;background-color:'.$col.';width:90px" class="col-md-1">0</td>
	<td style="text-align:center ;background-color:'.$col.';width:90px" class="col-md-1">'.$qteS.'</td>
	<td style="width:32%;text-align:center ;background-color:'.$col.';width:90px" class="col-md-1">'.$stockART.'</td>');

            }else{
                if($stockART<0){
                    $col="#F7819F";
                }else{
                    $col="#E0F8F1";
                }
                echo('<td style="text-align:center ;background-color:'.$col.';width:90px" class="col-md-1">0</td>
	<td style="text-align:center ;background-color:'.$col.';width:90px" class="col-md-1">0</td>
	<td style="text-align:center ;background-color:'.$col.';width:90px" class="col-md-1">'.$stockART.'</td>');
            }
            echo('</tr>');
        }
    }
    $dateJ = strtotime($dateJ."+ 1 day");
    $dateJ= date('Y-m-d', $dateJ);
}
echo ("</tbody>");
?>