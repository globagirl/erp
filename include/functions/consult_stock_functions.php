<?php
function stock_ant($article,$dateA,$stock){
    $s1= mysql_query("SELECT sum(qte) FROM sortie_items where IDpaquet like '$article/%' and IDbande IN( SELECT IDsortie FROM bande_sortie where dateC > '$dateA')");
		       $total_sortie=@mysql_result($s1,0);
               $s2= mysql_query("SELECT sum(qteR) FROM sortie_items where IDpaquet like '$article/%' and IDretour IN( SELECT IDretour FROM bande_retour where dateC > '$dateA')");
		       $total_retour=@mysql_result($s2,0);
		       $s3= mysql_query("SELECT sum(qty) FROM reception_items where IDarticle='$article' and IDreception IN( SELECT IDreception FROM reception where dateES > '$dateA')");
		       $total_reception=@mysql_result($s3,0);
		       $stockA=($stock+$total_sortie)-($total_retour+$total_reception);
		       $stockA=round($stockA,2);
               return $stockA;
}
function affiche_ligne($a,$dateA){
    $article=$a['code_article'];
    $stock=$a['stock'];
    $catA=$a['catA'];
    $stockA=$stock;
    $somme="--";
      if($catA=="Production"){
         $reqS= mysql_query("SELECT sum(qte_res) FROM paquet2 where IDarticle='$article' or IDarticle LIKE '$article'"); 
	        $somme=@mysql_result($reqS,0);
	        $somme=round($somme,2);
    }
    if($dateA != ""){
	      $dateJ=date("Y-m-d");	      
	      if($dateA<$dateJ){	           
	        $stockA=stock_ant($article,$dateA,$stock);
	     }
	}
    echo ('<tr>	<td style="width:15%;height:60px;text-align:center">'.$a['code_article'].'</td>
			    <td style="width:20%;height:60px;text-align:center">'.$a['description'].'</td>												
				<td style="width:15%;height:60px;text-align:center">'.$a['supplier'].'</td>
				<td style="width:15%;height:60px;text-align:center">'.$a['stock'].'</td>
				<td style="width:15%;height:60px;text-align:center">'.$stockA.'</td>
				<td style="width:15%;height:60px;text-align:center">'.$somme.'</td>
				<td style="width:15%;height:60px;text-align:center">'.$a['stock_rebut'].'</td>
				');
				echo "<td style=\"width:5%;height:60px;text-align:center\">
				<input type=\"button\" onClick=affichePaquet('".$article."'); Value=\">>\"></td></tr>";
    
}
function affiche_ligne_excel($a,$dateA){
    $article=$a['code_article'];
    $stock=$a['stock'];
    $catA=$a['catA'];
    $stockA=$stock;
    $somme="--";
      if($catA=="Production"){
         $reqS= mysql_query("SELECT sum(qte_res) FROM paquet2 where IDarticle='$article' or IDarticle LIKE '$article'"); 
	        $somme=@mysql_result($reqS,0);
	        $somme=round($somme,2);
    }
    if($dateA != ""){
	      $dateJ=date("Y-m-d");	      
	      if($dateA<$dateJ){
	           $s1= mysql_query("SELECT sum(qte) FROM sortie_items where IDpaquet like '$article/%' and IDbande IN( SELECT IDsortie FROM bande_sortie where dateC > '$dateA')");
		       $total_sortie=@mysql_result($s1,0);
               $s2= mysql_query("SELECT sum(qteR) FROM sortie_items where IDpaquet like '$article/%' and IDretour IN( SELECT IDretour FROM bande_retour where dateC > '$dateA')");
		       $total_retour=@mysql_result($s2,0);
		       $s3= mysql_query("SELECT sum(qty) FROM reception_items where IDarticle='$article' and IDreception IN( SELECT IDreception FROM reception where dateES > '$dateA')");
		       $total_reception=@mysql_result($s3,0);
		       $stockA=($stock+$total_sortie)-($total_retour+$total_reception);
		       $stockA=round($stockA,2);
	   
	     }
	}
    $prixU=$a['prix'];
    $stock=$a['stock'];
    $val=$prixU * $stock;
    $val=round($val,2);
    $valA=$prixU * $stockA;
    $valA=round($valA,2);
    echo ('<tr>	<td style="width:15%;height:60px;text-align:center">'.$a['code_article'].'</td>
			    <td style="width:15%;height:60px;text-align:center">'.$a['description'].'</td>												
				<td style="width:15%;height:60px;text-align:center">'.$a['supplier'].'</td>
				<td style="width:15%;height:60px;text-align:center">'.$a['stock'].'</td>
                <td style="width:15%;height:60px;text-align:center">'.$val.'</td>
				<td style="width:15%;height:60px;text-align:center">'.$stockA.'</td>
                <td style="width:15%;height:60px;text-align:center">'.$valA.'</td>
        </tr>');
				
    
}
?>
