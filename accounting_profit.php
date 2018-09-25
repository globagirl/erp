<?php
    include('../connexion/connexionDB.php');
    $date1=@$_POST['date1'];
    $date2=@$_POST['date2'];
    $recherche=@$_POST['recherche'];
    $valeur=@$_POST['valeur'];
    $R2=@$_POST['R2'];
    $totalProfit=0;
    $totalRevenues=0;
    $totalRevenuesTE=0;
    $totalRevenuesCS=0;
    $totalCosts=0;
    $totalQTY=0;
    $totalQTYTE=0;
    $totalQTYCS=0;
    $totalWaist=0;
    $totalWaistP=0;
    $totalCabL=0;
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
            <th style="width:10%;height:60px" class="degraD2"><b>Item ID</b></th>
            <th style="width:6%;height:60px" class="degraD2"><b>Qty</b></th>
            <th style="width:8%;height:60px" class="degraD2"><b>Revenue</b></th>
            <th style="width:9.5%;height:60px" class="degraD2"><b>Theoretical costs</b></th>
            <th style="width:9%;height:60px" class="degraD2"><b>Real costs</b></th>
            <th style="width:7%;height:60px" class="degraD2"><b>Waist </b></th>
            <th style="width:8%;height:60px" class="degraD2"><b>Waist %</b></th>
            <th style="width:8%;height:60px" class="degraD2"><b>Gross margin</b></th>
            <th style="width:8%;height:60px" class="degraD2"><b>Gross margin %</b></th>
            <th style="width:4.5%;height:60px" class="degraD2"><b>Average</b></th>
        </tr>
        </thead>
        <tbody id="tbody2" style="width:100%">';
    if($R2=="shipped"){
        $req= mysql_query("SELECT * FROM fact1 where date_E >= '$date1' and date_E<= '$date2' and (client='1004' or client='1003') ");
        $i=1;
        while($a=@mysql_fetch_object($req)){
            $numFact=$a->num_fact;
            $dateE=$a->date_E;
            $devise='EUR';
            $req1= mysql_query("SELECT * FROM fact_items where idF='$numFact'");
            $a1=@mysql_fetch_object($req1);
            $PO=$a1->PO;
            $OF=$a1->OF;
            $qteC=$a1->qty;
            $produit=$a1->produit;
            $prixU=$a1->prixU;
            $prixT=$a1->prixT;
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
            $totalItem=0;
            $req2= mysql_query("SELECT * FROM sortie_stock1 where OF= '$OF'");
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
                $col1="#FF8000";
                }
            $profit=$prixT-$totalTC;
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
                    //if($produit==$valeur){
                    if(strpos($produit,$valeur)  !== false){
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
                $totalCabL=$totalCabL + ($long*$qteC);
                $col1="#FAFAFA";
                $col2="#FAFAFA";
                $XX=$profit/$qteC;
                $XX=round($XX,2);
                echo"<tr >
                    <td  style=\"width:10.1%;height:60px;background-color:".$col1."\">$PO</td>
                    <td  style=\"width:10.2%;height:60px;background-color:".$col2."\">$dateE</td>
                    <td  style=\"width:10.2%;height:60px ;background-color:".$col2."\">$produit</td>
                    <td  style=\"width:6.1%;height:60px ;background-color:".$col2."\">$qteC</td>
                    <td  style=\"width:8.1%;height:60px;background-color:#F5ECCE\">$prixT</td>	
                    <td  style=\"width:9.6%;height:60px;background-color:#F8E0EC\">$totalTC</td>	
                    <td  style=\"width:9.2%;height:60px ;background-color:#FAB6B6\">$totalItem</td>
                    <td  style=\"width:7.2%;height:60px;background-color:".$col."\">$W1</td>
                    <td  style=\"width:8.2%;height:60px;background-color:".$col."\">$W2 %</td>
                    <td  style=\"width:8.1%;height:60px;background-color:".$col2."\">$profit</td>
                    <td  style=\"width:8.2%;height:60px ;background-color:".$col2."\">$P2 %</td>
                    <td  style=\"width:4.6%;height:60px;background-color:".$col2."\">$XX</td>	";
                //Calcul total
                $totalQTY=$totalQTY+$qteC;
                $totalWaist=$totalWaist+$W1;
                $totalWaistP=$totalWaistP+$W2;
                $totalProfit=$totalProfit+$profit;
                $totalRevenues=$totalRevenues+$prixT;
                $totalCosts=$totalCosts+$totalTC;
                $i++;
                }
            ///////////Fin Partie
        }
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
        $avgCabL= $totalCabL/$totalQTY;
        $avgCabL=round($avgCabL,2);
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
            <td style=width:30%;height:40px;text-align:right;background-color:#EFEFFB ><b>Total QTY: </b></td>
            <td style=width:70%;height:40px;background-color:#EFEFFB><b>'.$totalQTY .' </b></td></tr>
            <tr>
            <td  style=width:30%;height:40px;background-color:#F5ECCE;text-align:right ><b>Total revenues: </b></td>
            <td  style=width:70%;height:40px;background-color:#F5ECCE><b>'.$totalRevenues  .' '.$devise.'</b></td></tr>
            <tr>
            <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Component cost: </b></td>
            <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$totalCosts .' '.$devise.'</b></td></tr>
            <tr><td style=width:30%;height:40px;text-align:right;background-color:#E0F2F7 ><b>Gross margin: </b></td><td style=width:70%;height:40px;background-color:#E0F2F7><b>'.$totalProfit .' '.$devise.'</b></td></tr>
            <tr><td style=width:30%;height:40px;text-align:right;background-color:#FAB6B6 ><b>Gross margin %: </b></td><td style=width:70%;height:40px;background-color:#FAB6B6><b> '.$PT2.' %</b></td></tr>
            <tr>
            <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Average matgin/Cable: </b></td>
            <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$marginCable .'%</b></td></tr>
            <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Average cable length: </b></td>
            <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$avgCabL .' M</b></td></tr>
            <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Waisted cost: </b></td>
            <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$totalWaist .' '.$devise.'</b></td></tr>
            <tr><td style=width:30%;height:40px;text-align:right;background-color:#F5A9BC ><b>Waisted cost (%): </b></td><td style=width:70%;height:40px;background-color:#F5A9BC><b>'.$totalWaistP .' %</b></td></tr>
            </tbody></table></div>';
        //FIN SHIPPED
    }else if($R2=="shippedNot"){
    $reqSup= mysql_query("SELECT * FROM ordre_fabrication1 where date_exped_conf >= '$date1' and date_exped_conf<= '$date2' and statut !='planned' and statut !='closed'");
    //Sortie du magazin
    $i=1;
    while($a2=@mysql_fetch_object($reqSup)){
    $PO=$a2->PO;
    $OF=$a2->OF;
    $dateE=$a2->date_exped_conf;
    $devise='EUR';
    $qteC=$a2->qte;
    $produit=$a2->produit;
    //selection des commandes
    $req1= mysql_query("SELECT prixU FROM commande_items where PO='$PO'");
    $prixU=mysql_result($req1,0);
    $prixT=$prixU*$qteC;
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
    $totalItem=0;
    $req2= mysql_query("SELECT * FROM sortie_stock1 where OF= '$OF'");
    if(mysql_num_rows($req2)>0){
        while($data2=mysql_fetch_object($req2)){
            $IDpaquet=$data2->IDpaquet;
            $qte=$data2->qte;
            $req3= mysql_query("SELECT * FROM paquet2 where IDpaquet='$IDpaquet'");
            $data3=mysql_fetch_object($req3);
            $R=$data3->idRO;
            $article=$data3->IDarticle;
            if(($R=="") || ($R== NULL)){ //ID reception introuvable
                $req4= mysql_query("SELECT * FROM article1 where code_article='$article'");
                $data4=mysql_fetch_object($req4);
                $prixA=$data4->prix;
                $prixTItem=$prixA*$qte;
                $totalItem=$totalItem+$prixTItem;
                }else{
                    $req4= mysql_query("SELECT * FROM reception_items where item LIKE '$article' and IDreception LIKE '$R'");
                    $data4=mysql_fetch_object($req4);
                    $qty=$data4->qty;
                    $price=$data4->price;
                    $prixUItem=$price/$qty;
                    $prixTItem=$prixUItem*$qte;
                    $totalItem=$totalItem+$prixTItem;
                    }
        }
    }else{
        //Pas de sortie stock
        $totalItem=$totalTC;
        $col1="#FF8000";
        }
    $profit=$prixT-$totalTC;
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
            //if($produit==$valeur){
                    if(strpos($produit,$valeur)  !== false){
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
    $XX=$profit/$qteC;
    $XX=round($XX,2);
    ///Partie qui se répéte
    if($aff==1){
        $totalCabL=$totalCabL + ($long*$qteC);
        $col1="#FAFAFA";
        $col2="#FAFAFA";
        echo"<tr >
            <td  style=\"width:10.1%;height:60px;background-color:".$col1."\">$PO</td>
            <td  style=\"width:10.2%;height:60px;background-color:".$col2."\">$dateE</td>
            <td  style=\"width:10.2%;height:60px ;background-color:".$col2."\">$produit</td>
            
            <td  style=\"width:6.1%;height:60px ;background-color:".$col2."\">$qteC</td>
            <td  style=\"width:8.1%;height:60px;background-color:#F5ECCE\">$prixT</td>
            
            <td  style=\"width:9.6%;height:60px;background-color:#F8E0EC\">$totalTC</td>
            
            <td  style=\"width:9.2%;height:60px ;background-color:#FAB6B6\">$totalItem</td>
            <td  style=\"width:7.2%;height:60px;background-color:".$col."\">$W1</td>
            <td  style=\"width:8.2%;height:60px;background-color:".$col."\">$W2 %</td>
            <td  style=\"width:8.1%;height:60px;background-color:".$col2."\">$profit</td>
            <td  style=\"width:8.2%;height:60px ;background-color:".$col2."\">$P2 %</td>
            <td  style=\"width:4.6%;height:60px;background-color:".$col2."\">$XX</td>	";
        //Calcul total
        $totalQTY=$totalQTY+$qteC;
        $totalWaist=$totalWaist+$W1;
        $totalWaistP=$totalWaistP+$W2;
        $totalProfit=$totalProfit+$profit;
        $totalRevenues=$totalRevenues+$prixT;
        $totalCosts=$totalCosts+$totalTC;
        $i++;
    }
    //Fin Partie
    }
    //
    $req= mysql_query("SELECT * FROM commande2 where date_exped >= '$date1' and date_exped<= '$date2' and (client='1004' or client='1003')");
    while($a=@mysql_fetch_object($req)){
    $PO=$a->PO;
    $dateE=$a->date_exped;
    $devise='EUR';
    //selection des commandes
    $req1= mysql_query("SELECT * FROM commande_items where PO='$PO' and (statut ='waiting' or statut ='planned' or statut ='incomplete')");
    while($data=mysql_fetch_object($req1))
    {
    $PO=$data->PO;
    $qteC=$data->qty;
    $prixT=$data->prixT;
    $produit=$data->produit;
    $statut=$data->statut;
    if($statut=="incomplete"){
    $reqInc=mysql_query("SELECT sum(qte) FROM ordre_fabrication1 where PO='$PO' and statut != 'planned'");
    $qteMoin=mysql_result($reqInc,0);
    $qteC=$qteC-$qteMoin;
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
    $totalItem="----";
    $profit=$prixT-$totalTC;
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
    //
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
    //if($produit==$valeur){
    if(strpos($produit,$valeur)  !== false){
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
    $XX=$profit/$qteC;
    $XX=round($XX,2);
    ///Partie qui se répéte
    if($aff==1){
    $totalCabL=$totalCabL + ($long*$qteC);
    $col1="#ECF6CE";
    $col2="#FAFAFA";
    echo"<tr >
    <td  style=\"width:10.1%;height:60px;background-color:".$col1."\">$PO</td>
    <td  style=\"width:10.2%;height:60px;background-color:".$col2."\">$dateE</td>
    <td  style=\"width:10.2%;height:60px ;background-color:".$col2."\">$produit</td>
    
    <td  style=\"width:6.1%;height:60px ;background-color:".$col2."\">$qteC</td>
    <td  style=\"width:8.1%;height:60px;background-color:#F5ECCE\">$prixT</td>
    
    <td  style=\"width:9.6%;height:60px;background-color:#F8E0EC\">$totalTC</td>
    
    <td  style=\"width:9.2%;height:60px ;background-color:#FAB6B6\">$totalItem</td>
    <td  style=\"width:7.2%;height:60px;background-color:".$col."\">$W1</td>
    <td  style=\"width:8.2%;height:60px;background-color:".$col."\">$W2 %</td>
    <td  style=\"width:8.1%;height:60px;background-color:".$col2."\">$profit</td>
    <td  style=\"width:8.2%;height:60px ;background-color:".$col2."\">$P2 %</td>
    <td  style=\"width:4.6%;height:60px;background-color:".$col2."\">$XX</td>	";
    //Calcul total
    $totalQTY=$totalQTY+$qteC;
    $totalWaist=$totalWaist+$W1;
    $totalWaistP=$totalWaistP+$W2;
    $totalProfit=$totalProfit+$profit;
    $totalRevenues=$totalRevenues+$prixT;
    $totalCosts=$totalCosts+$totalTC;
    $i++;
    }
    }
    ///////////Fin Partie
    }

    //Pourcentage de perte
    $totalWaistP=($totalWaist/$totalRevenues)*100;
    //
    if($totalRevenues != 0){
    $PT1=$totalCosts/$totalRevenues;
    $PT2=(1-$PT1)*100;
    $PT2=round($PT2,2);
    }else{$PT2=0;}
    $avgCabL= $totalCabL/$totalQTY;
    $avgCabL=round($avgCabL,2);
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
    <td style=width:30%;height:40px;text-align:right;background-color:#EFEFFB ><b>Total QTY: </b></td>
    <td style=width:70%;height:40px;background-color:#EFEFFB><b>'.$totalQTY .' </b></td></tr>
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
    <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Average cable length: </b></td>
    <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$avgCabL .' M</b></td></tr>
    <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Waisted cost: </b></td>
    <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$totalWaist .' '.$devise.'</b></td></tr>
    <tr><td style=width:30%;height:40px;text-align:right;background-color:#F5A9BC ><b>Waisted cost (%): </b></td><td style=width:70%;height:40px;background-color:#F5A9BC><b>'.$totalWaistP .' %</b></td></tr>
    </tbody></table></div>';


    //FIN NOT shipped yet
    }else{

    //ALL
    $req= mysql_query("SELECT * FROM commande2 where date_exped >= '$date1' and date_exped<= '$date2' and (client='1004' or client='1003')");
    $reqSup= mysql_query("SELECT * FROM ordre_fabrication1 where date_exped_conf >= '$date1' and date_exped_conf<= '$date2' and statut !='planned'");
    //SHIPPED FOR ALL
    $i=1;
    while($a2=@mysql_fetch_object($reqSup)){
    $PO=$a2->PO;
    $reqC= mysql_query("SELECT client FROM commande2 where PO='$PO'");
    $cl=mysql_result($reqC,0);
    if($cl=='1004' || $cl=='1003'){
    $OF=$a2->OF;
    $dateE=$a2->date_exped_conf;
    $devise='EUR';
    $qteC=$a2->qte;
    $produit=$a2->produit;
    //selection des commandes

    $req1= mysql_query("SELECT prixU FROM commande_items where PO='$PO'");
    $prixU=mysql_result($req1,0);
    $prixT=$prixU*$qteC;

    //theoretical cost
    $totalTC=0;
    $req3= mysql_query("SELECT DISTINCT IDarticle,qte FROM produit_article1 where IDproduit='$produit'");
    while($data3=@mysql_fetch_object($req3)){
    $qteB=$data3->qte;
    $article=$data3->IDarticle;

    $req4= mysql_query("SELECT prix FROM article1 where code_article='$article'");
    //$data4=mysql_fetch_object($req4);
    $prixA=mysql_result($req4,0);
    $prixTItem=$prixA*($qteB*$qteC);
    $totalTC=$totalTC+$prixTItem;

    }
    //Cost

    $totalItem=0;
    $req2= mysql_query("SELECT * FROM sortie_stock1 where OF= '$OF'");
    if(mysql_num_rows($req2)>0){
    while($data2=mysql_fetch_object($req2)){
    $IDpaquet=$data2->IDpaquet;
    $qte=$data2->qte;
    $req3= mysql_query("SELECT * FROM paquet2 where IDpaquet='$IDpaquet'");
    $data3=mysql_fetch_object($req3);
    $R=$data3->idRO;
    $article=$data3->IDarticle;

    //if(($R=="") || ($R== NULL)){ //ID reception introuvable
    $req4= mysql_query("SELECT * FROM article1 where code_article='$article'");
    $data4=mysql_fetch_object($req4);
    $prixA=$data4->prix;
    $prixTItem=$prixA*$qte;
    $totalItem=$totalItem+$prixTItem;
    /*}else{
    $req41=mysql_query("SELECT unit_price FROM supplier_invoice_items where IDitem='$article' and IDreception='$R'");
    //$data41=mysql_fetch_array($req41);

    if(mysql_num_rows($req41) > 0){
    $prixUItem=mysql_result($req41,0);
    $prixTItem=$prixUItem*$qte;
    $totalItem=$totalItem+$prixTItem;

    }else{
    $req4= mysql_query("SELECT * FROM article1 where code_article='$article'");
    $data4=mysql_fetch_object($req4);
    $prixA=$data4->prix;
    $prixTItem=$prixA*$qte;
    $totalItem=$totalItem+$prixTItem;
    }
    }*/
    }
    }else{//Pas de sortie stock

    //$totalItem=$totalTC;
    $totalItem=0;
    $col1="#FF8000";
    }

    $profit=$prixT-$totalTC;

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

    //if($produit==$valeur){
    if(strpos($produit,$valeur)  !== false){
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
    $XX=$profit/$qteC;
    $XX=round($XX,2);
    ///Partie qui se répéte
    if($aff==1){
    $totalCabL=$totalCabL + ($long*$qteC);

    $col1="#FAFAFA";

    $col2="#FAFAFA";
    echo"<tr >
    <td  style=\"width:10.1%;height:60px;background-color:".$col1."\">$PO</td>
    <td  style=\"width:10.2%;height:60px;background-color:".$col2."\">$dateE</td>
    <td  style=\"width:10.2%;height:60px ;background-color:".$col2."\">$produit</td>
    
    <td  style=\"width:6.1%;height:60px ;background-color:".$col2."\">$qteC</td>
    <td  style=\"width:8.1%;height:60px;background-color:#F5ECCE\">$prixT</td>
    
    <td  style=\"width:9.6%;height:60px;background-color:#F8E0EC\">$totalTC</td>
    
    <td  style=\"width:9.2%;height:60px ;background-color:#FAB6B6\">$totalItem</td>
    <td  style=\"width:7.2%;height:60px;background-color:".$col."\">$W1</td>
    <td  style=\"width:8.2%;height:60px;background-color:".$col."\">$W2 %</td>
    <td  style=\"width:8.1%;height:60px;background-color:".$col2."\">$profit</td>
    <td  style=\"width:8.2%;height:60px ;background-color:".$col2."\">$P2 %</td>
    <td  style=\"width:4.6%;height:60px;background-color:".$col2."\">$XX</td>	";
    //Calcul total
    $totalQTY=$totalQTY+$qteC;
    $totalWaist=$totalWaist+$W1;
    $totalWaistP=$totalWaistP+$W2;
    $totalProfit=$totalProfit+$profit;
    $totalRevenues=$totalRevenues+$prixT;
    $totalCosts=$totalCosts+$totalTC;
    $i++;
    }
    }
    ///////////Fin Partie
    }

    //NOT SHIPPED YET FOR ALL

    while($a=@mysql_fetch_object($req)){
    $PO=$a->PO;
    $dateE=$a->date_exped;
    $devise='EUR';
    //selection des commandes

    $req1= mysql_query("SELECT * FROM commande_items where PO='$PO' and (statut ='waiting' or statut ='planned' or statut ='incomplete')");

    while($data=mysql_fetch_object($req1)){
    $PO=$data->PO;
    $qteC=$data->qty;
    $prixT=$data->prixT;
    $produit=$data->produit;
    $statut=$data->statut;

    if($statut=="incomplete"){
    $reqInc=mysql_query("SELECT sum(qte) FROM ordre_fabrication1 where PO='$PO' and statut != 'planned'");
    $qteMoin=mysql_result($reqInc,0);
    $qteC=$qteC-$qteMoin;
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

    $totalItem="----";


    $profit=$prixT-$totalTC;

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

    //if($produit==$valeur){
    if(strpos($produit,$valeur)  !== false){
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
    $XX=$profit/$qteC;
    $XX=round($XX,2);
    ///Partie qui se répéte
    if($aff==1){
    $totalCabL=$totalCabL + ($long*$qteC);
    $col1="#ECF6CE";
    $col2="#FAFAFA";
    echo"<tr >
    <td  style=\"width:10.1%;height:60px;background-color:".$col1."\">$PO</td>
    <td  style=\"width:10.2%;height:60px;background-color:".$col2."\">$dateE</td>
    <td  style=\"width:10.2%;height:60px ;background-color:".$col2."\">$produit</td>
    
    <td  style=\"width:6.1%;height:60px ;background-color:".$col2."\">$qteC</td>
    <td  style=\"width:8.1%;height:60px;background-color:#F5ECCE\">$prixT</td>
    
    <td  style=\"width:9.6%;height:60px;background-color:#F8E0EC\">$totalTC</td>
    
    <td  style=\"width:9.2%;height:60px ;background-color:#FAB6B6\">$totalItem</td>
    <td  style=\"width:7.2%;height:60px;background-color:".$col."\">$W1</td>
    <td  style=\"width:8.2%;height:60px;background-color:".$col."\">$W2 %</td>
    <td  style=\"width:8.1%;height:60px;background-color:".$col2."\">$profit</td>
    <td  style=\"width:8.2%;height:60px ;background-color:".$col2."\">$P2 %</td>	
    <td  style=\"width:4.6%;height:60px;background-color:".$col2."\">$XX</td>";
    //Calcul total
    $totalQTY=$totalQTY+$qteC;
    $totalWaist=$totalWaist+$W1;
    $totalWaistP=$totalWaistP+$W2;
    $totalProfit=$totalProfit+$profit;
    $totalRevenues=$totalRevenues+$prixT;
    $totalCosts=$totalCosts+$totalTC;
    $i++;
    }
    }
    ///////////Fin Partie
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
    $avgCabL= $totalCabL/$totalQTY;
    $avgCabL=round($avgCabL,2);
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
    <td style=width:30%;height:40px;text-align:right;background-color:#EFEFFB ><b>Total QTY: </b></td>
    <td style=width:70%;height:40px;background-color:#EFEFFB><b>'.$totalQTY .' </b></td></tr>
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
    <tr>
    <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Average cable length: </b></td>
    <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$avgCabL .' M</b></td></tr>
    <td style=width:30%;height:40px;text-align:right;background-color:#F8E0EC ><b>Waisted cost: </b></td>
    <td style=width:70%;height:40px;background-color:#F8E0EC><b>'.$totalWaist .' '.$devise.'</b></td></tr>
    <tr><td style=width:30%;height:40px;text-align:right;background-color:#F5A9BC ><b>Waisted cost (%): </b></td><td style=width:70%;height:40px;background-color:#F5A9BC><b>'.$totalWaistP .' %</b></td></tr>
    </tbody></table></div>';
    //FIN ALL
    }

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

    //if($produit==$valeur){
    if(strpos($produit,$valeur)  !== false){
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
    </tbody>
    </table></div></div></div>';
    mysql_close();
?>