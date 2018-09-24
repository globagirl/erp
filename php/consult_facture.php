<?php
include('../connexion/connexionDB.php');
$valeur=$_POST['valeur'];
$recherche=$_POST['recherche'];
$recherche2=$_POST['recherche2'];
$statut=$_POST['statut'];
$dateD=@$_POST['dateD'];
$dateF=@$_POST['dateF'];

if ($recherche=="a"){
    $req= "SELECT num_fact,client,tot_val,devise,date_E,statut FROM fact1 where statut ='$statut' order by num_fact DESC  ";
}else if (($recherche == "client") or ($recherche == "date_E")or ($recherche == "num_fact")) {
    if($statut=="A"){
       if($dateD != "" && $dateF != ""){
          $req= "SELECT num_fact,client,tot_val,devise,date_E,statut FROM fact1 where $recherche LIKE '$valeur' and $recherche2 >= '$dateD' and $recherche2 <= '$dateF' order by num_fact DESC";
       }else{
         $req= "SELECT num_fact,client,tot_val,devise,date_E,statut FROM fact1 where $recherche LIKE '$valeur' order by num_fact DESC";
       }

	   }else{
       if($dateD != "" && $dateF != ""){
         $req= "SELECT num_fact,client,tot_val,devise,date_E,statut FROM fact1 where statut ='$statut' and  $recherche='$valeur' and $recherche2 >= '$dateD' and $recherche2 <= '$dateF' order by num_fact DESC";
       }else{
         $req= "SELECT num_fact,client,tot_val,devise,date_E,statut FROM fact1 where statut ='$statut' and  $recherche='$valeur' order by num_fact DESC";
       }

	   }
}else{
    $req1= mysql_query("SELECT DISTINCT idF FROM fact_items where $recherche LIKE '%$valeur%' order by idF DESC");
	   $req= "x";
}


if($req=="x"){
 while($data=mysql_fetch_object($req1)){
    $F=$data->idF;
    if($statut=="A"){

      $req= "SELECT num_fact,client,tot_val,devise,date_E,statut FROM fact1 where num_fact='$F'";
    }else{
      $req= "SELECT num_fact,client,tot_val,devise,date_E,statut FROM fact1 where num_fact='$F' and statut ='$statut'";
    }
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_object($r)){
      $num = $a->num_fact;
      $client = $a->client;
      $stat = $a->statut;
      $t = $a->tot_val;
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
      while($a1=mysql_fetch_object($req2)){
       $prd=$a1->produit;
       $po=$a1->PO;
       $qtu=$a1->qty;
       $prixU=$a1->prixU;
       echo'<tr><td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$num.'</td>
       <td style="width:12%;height:60px;text-align:center;background-color:'.$col.'">'.$clt.'</td>
       <td style="width:12%;height:60px;text-align:center;background-color:'.$col.'">'.$dateE.'</td>
       <td style="width:13%;height:60px;text-align:center;background-color:'.$col.'">'.$po.'</td>
       <td style="width:13%;height:60px;text-align:center;background-color:'.$col.'">'.$prd.'</td>
       <td style="width:8%;height:60px;text-align:center;background-color:'.$col.'">'.$qtu.'</td>
       <td style="width:8%;height:60px;text-align:center;background-color:'.$col.'">'.$prixU.'</td>
       <td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$t.' '.$devise.'</td>
       <td style="width:7%;height:60px;text-align:center;background-color:'.$col.'">'.$stat.'</td>';
       echo "<td style=\"height:60px;text-align:center;\"><img src=\"../image/print.png\" target=\"_blank\" onclick=print_facture('".$num."'); style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td>
		     </tr>";
      }
	   }
 }
}else{
  $r=mysql_query($req) or die(mysql_error());
  while($a=mysql_fetch_object($r)){
    $num = $a->num_fact;
    $client = $a->client;
	$t = $a->tot_val;
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
    //Prix systéme
    $sq=mysql_query("select price from prices where IDproduit='$prd' and marginL='1' and marginH='-1'");
    $prixNv=@mysql_result($sq,0);
    $totalNv=$prixNv*$qtu;
    $totalNv=round($totalNv,3);
     echo'<tr><td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$num.'</td>
     <td style="width:12%;height:60px;text-align:center;background-color:'.$col.'">'.$clt.'</td>
     <td style="width:12%;height:60px;text-align:center;background-color:'.$col.'">'.$dateE.'</td>
     <td style="width:13%;height:60px;text-align:center;background-color:'.$col.'">'.$po.'</td>
     <td style="width:13%;height:60px;text-align:center;background-color:'.$col.'">'.$prd.'</td>
     <td style="width:8%;height:60px;text-align:center;background-color:'.$col.'">'.$qtu.'</td>
     <td style="width:8%;height:60px;text-align:center;background-color:'.$col.'">'.$prixU.'</td>
     <td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$t.' '.$devise.'</td>
     <td style="width:7%;height:60px;text-align:center;background-color:'.$col.'">'.$stat.'</td>';
     echo "<td style=\"height:60px;text-align:center;\"><img src=\"../image/print.png\" target=\"_blank\" onclick=print_facture('".$num."'); style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td>
       </tr>";
    }
    }
	}
  echo '</table>';
  mysql_close();
  ?>
