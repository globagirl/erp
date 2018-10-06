<?php
include('../connexion/connexionDB.php');
$IDordre=@$_POST['IDordre'];
$dateH=@$_POST['dateH'];
//Mettre a jour la table article_prevision
$i=0;
$req121= mysql_query ("UPDATE article_prevision SET aff='N'");
$req1=mysql_query ("SELECT * FROM ordre_achat_article1 where IDordre='$IDordre'");
while($a=mysql_fetch_object($req1))
{
    $i++;
    $article=$a->IDarticle;
    $req12= mysql_query ("UPDATE article_prevision SET aff='V' where idART='$article'");
}
$req101=mysql_query ("SELECT count(numArt) FROM article_prevision where aff='V'");
$max=mysql_result($req101,0);
$req111=mysql_query ("SELECT min(numArt) FROM article_prevision where aff='V'");
$min=mysql_result($req111,0);
$req01=mysql_query ("SELECT * FROM article_prevision where numART='$min'");
$a=mysql_fetch_object($req01);
$stockART =$a->stockART;
$art =$a->idART;
$num =$a->numART;
//Affichage du tableau 
echo '<thead style="width:96.8%">
            <tr>
               <th style="width:20%;height:40px" class="degraD">';
if($num >$min){
    echo '
			   <input type="button" value="<<" onClick=nextART("DEB");>
			   <input type="button" value="<"  onClick=nextART("-1");>';
}else{
    echo '
			   <input type="button" value="<<" DISABLED>
			   <input type="button" value="<" DISABLED> ';
}
echo '
			   </th>
				<th style="width:60%;height:40px" class="degraD">
				<center>
				<input type="text" id="IDart" value="'.$art.'"size="10" onBlur="prevision_stockItem();" READONLY>
				<b>1/'.$max.'</b>
				</center></th>
				<th style="width:20%;height:40px" class="degraD">';
if($i >1){
    echo '
			   <input type="button" value=">" onClick=nextART("1");>
			   <input type="button" value=">>" onClick=nextART("FIN");>';
}else{
    echo '
			   <input type="button" value=">" DISABLED>
			   <input type="button" value=">>" DISABLED> ';
}

echo '
				</th>			  
            </tr>
			<tr><th style="width:100%;height:40px" class="degraD">
			<center><input type="text" id="STOCKart" value="'.$stockART.'"size="10"READONLY><input type="button" value="+" onClick="addStock()">
			   <input type="button" value="Real" onClick="realStock()"></center></th>
			
			</tr>
			<tr>
               <th style="width:32%;height:30px" class="degraD">IN</th>
				<th style="width:32%;height:30px" class="degraD">OUT</th>
				<th style="width:36%;height:30px" class="degraD">Stock</th>			  
            </tr>
          </thead>
		   <tbody id="tbody2">'; //FIN affichage 
$req4= mysql_query("SELECT * FROM po_prevision ");
while($a4=mysql_fetch_object($req4))
{
    $num=$a4->num;
    $PO=$a4->po;
    $item=$a4->item;
    $dateEX=$a4->dateEX;
    $dateE=$a4->dateE;
    $typeP=$a4->typeP;
    $qteD=$a4->qty;
    $col=$a4->col;
    $etat=$a4->etat;
    $cl=$num."cl";
    if($typeP=='OA'){

        //
        if($item==$art){
            $stockART=$stockART+$qteD;
            $stockART=round($stockART,4);
            if($stockART<0){
                $col2="#FA5858";
            }else{
                $col2=$col;
            }

            echo('<tr id='.$num.'><td class='.$cl.' style="width:32%;background-color:'.$col.';text-align:center">'.$qteD.'</td>
	<td class='.$cl.' style="width:32%;background-color:'.$col.';text-align:center">0</td>
	<td class='.$cl.' style="width:32%;background-color:'.$col2.';text-align:center">'.$stockART.'</td></tr>');
        }else{
            if($stockART<0){
                $col2="#FA5858";
            }else{
                $col2=$col;
            }
            echo('<tr id='.$num.'><td class='.$cl.' style="width:32%;background-color:'.$col.';text-align:center">0</td>
	<td class='.$cl.' style="width:32%;background-color:'.$col.';text-align:center">0</td>
	<td class='.$cl.' style="width:32%;background-color:'.$col2.';text-align:center">'.$stockART.'</td></tr>');
        }
        // PO
    }else{
        if($etat=='P'){
            $req42= mysql_query("SELECT * FROM produit_article1 where IDproduit ='$item' and IDarticle='$art'");
            if(mysql_num_rows($req42)>0){
                $a42=mysql_fetch_object($req42);
                $qteB=$a42->qte;
                $qteS=$qteB*$qteD;
                $stockART=$stockART-$qteS;
                $stockART=round($stockART,4);

                if($stockART<0){
                    $col2="#FA5858";
                }else{
                    $col2=$col;
                }
                echo('<tr id='.$num.'><td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col.'">0</td>
	<td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col.'">'.$qteS.'</td>
	<td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col2.'">'.$stockART.'</td></tr>');

            }else{
                if($stockART<0){
                    $col2="#FA5858";
                }else{
                    $col2=$col;
                }
                echo('<tr id='.$num.'><td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col.'">0</td>
	<td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col.'">0</td>
	<td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col2.'">'.$stockART.'</td></tr>');
            }
        } //Historique
        else if ($etat=='H'){

            $art2=$art.'/';
            $req42= mysql_query("SELECT SUM(qte) FROM sortie_stock1 where commande ='$PO' and IDpaquet LIKE '$art2%'");

            $qteS=mysql_result($req42,0);
            if($qteS==""){
                $qteS=0;
            }
            $stockART=$stockART-$qteS;
            $stockART=round($stockART,4);

            if($stockART<0){
                $col2="#FA5858";
            }else{
                $col2=$col;
            }
            echo('<tr id='.$num.'><td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col.'">0</td>
	<td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col.'">'.$qteS.'</td>
	<td class='.$cl.' style="width:32%;text-align:center ;background-color:'.$col2.'">'.$stockART.'</td></tr>');


        }
    }

}


echo ("</tbody>");


?>