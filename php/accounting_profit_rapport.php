<?php
include('../connexion/connexionDB.php');
$OF=@$_POST['OF'];
$dateE=@$_POST['dateE'];
function calcul_theo_coast($article,$dateE){
   
  $req1=mysql_query("SELECT ancien_prix FROM update_prices_item where item='$article' and dateM > '$dateE' and etat ='Y' order by dateM DESC");
  if(mysql_num_rows($req1)>0){
   $prixA=mysql_result($req1,0);
  }else{
   $req2= mysql_query("SELECT prix FROM article1 where code_article='$article'");	 
	  $prixA=mysql_result($req2,0);
  } 

  return $prixA;
}
echo '<table class="table table-fixed " >
<thead style="width:100%">
<tr>
  <th style="width:34.8%;height:40px" ><b>Paquet</b></th>
  <th style="width:14.8%;height:40px"><b>Qty</b></th>
  <th style="width:24.8%;height:40px"><b>Prix facture</b></th>
  <th style="width:24.8%;height:40px"><b>Prix systéme</b></th>
 </tr>
 </thead>
 <tbody>
  ';
  
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
       $prixS= calcul_theo_coast($article,$dateE);
       echo '<tr>
       <td style="width:35%;height:40px">'.$IDpaquet.'</td>
       <td style="width:15%;height:40px">'.$qte.'</td>
       <td style="width:25%;height:40px">'.$prixU.'</td>
       <td style="width:25%;height:40px">'.$prixS.'</td>
       </tr>';
     
     }
     echo '</tbody></table>';
?>