<?php
include('../connexion/connexionDB.php');
$recherche=$_POST['recherche'];
$valeur=@$_POST['valeur'];
$margeD=$_POST['margeD'];
$date1=@$_POST['date1'];
$date2=@$_POST['date2'];
$stat=@$_POST['statut'];
$modeP=@$_POST['modeP'];
$refP=@$_POST['refP'];
if($modeP=='X'){
$modeP=$refP;
 $refP="";
}
$totalE1=0;
$totalT1=0;
$totalD1=0;
$totalE2=0;
$totalT2=0;
$totalD2=0;

if(($recherche=="a") and ($date1=="")and ($date2=="")){
   $req1= "SELECT * FROM supplier_invoice";
    $req2= "SELECT * FROM expense";
}else if(($recherche=="a") and ($date1!="")and ($date2!="")){
   $req1= "SELECT * FROM supplier_invoice where (($margeD >= '$date1') and ($margeD <= '$date2'))";
    $req2= "SELECT * FROM expense where (($margeD >= '$date1') and ($margeD <= '$date2'))";
}else if(($date1=="")and ($date2=="") and ($recherche !="a")){
   if($recherche=="un_expense"){
       $req1="x";
       $req2= "SELECT * FROM expense ";
   }else if($recherche == "catI"){
       $req1= "SELECT * FROM supplier_invoice where $recherche like '%$valeur%'";
         $req2= "SELECT * FROM expense where $recherche like '%$valeur%'";
   }else if($recherche == "IDreception" || $recherche == "IDitem" || $recherche == "IDordre"){
       $req1= "SELECT * FROM supplier_invoice where IDinvoice in (SELECT IDinvoice FROM supplier_invoice_items where  $recherche like '$valeur') order by dateF DESC";
         $req2= "x";
   }else{
       $req1= "SELECT * FROM supplier_invoice where $recherche like '%$valeur%'";
       $req2="x";

   }
}else{
   if($recherche=="un_expense"){
       $req1="x";
         $req2= "SELECT * FROM expense where (($margeD >= '$date1') and ($margeD<= '$date2')) ";
   }else if($recherche == "catI"){
       $req1= "SELECT * FROM supplier_invoice where (($recherche like '%$valeur%') and (($margeD >= '$date1') and ($margeD <= '$date2')))";
       $req2= "SELECT * FROM expense where (($recherche like '%$valeur%') and (($margeD >= '$date1') and ('$margeD' <= '$date2')))";
   }else if($recherche == "IDreception" || $recherche == "IDitem" || $recherche == "IDordre"){
       $req1= "SELECT * FROM supplier_invoice where (($margeD >= '$date1') and ($margeD <= '$date2')) and IDinvoice in (SELECT IDinvoice FROM supplier_invoice_items where  $recherche like '$valeur') order by dateF DESC";
         $req2= "x";
   }else{
       $req2="x";
       $req1= "SELECT * FROM supplier_invoice where (($recherche like '%$valeur%') and (($margeD >= '$date1') and ($margeD <= '$date2')))";
   }
}
//



if($req1 != "x"){
 $r=mysql_query($req1) or die(mysql_error());
 echo '<table  class="table table-fixed results" id="table3">
       <thead style="width:100%">
             <tr>
           <th style="width:11.8%;height:60px;text-align:center">N° facture</th>
           <th style="width:14.8%;height:60px;text-align:center">Fournisseur</th>
            <th style="width:9.8%;height:60px;text-align:center">Date facture</th>
           <th style="width:14.8%;height:60px;text-align:center" >Article</th>
            <th style="width:9.8%;height:60px;text-align:center">N° Ordre </th>
           <th style="width:9.8%;height:60px;text-align:center">Prix unitaire</th>
           <th style="width:7.8%;height:60px;text-align:center">QTY</th>
           <th style="width:9.8%;height:60px;text-align:center">Total article</th>
           <th style="width:9.8%;height:60px;text-align:center">Total</th>

           </tr>
       </thead>
     <tbody id="tbody" style="width:100%">';
 while($a=mysql_fetch_object($r)){
   $inv_n=$a->IDinvoice;
   $supplier =$a->supplier;
   $dateF=$a->dateF;
   $dateP=$a->dateP;
   $prix_total=$a->total;
   //$ship=$a->shipCoast;
   //$tax=$a->tax;
   $typeI=$a->typeI;
  //$catI=$a->catI;
  // $fileI=$a->fileI;
  $devise=$a->currency;
  $statut=$a->status;
  //Vérification par mode de payment
 if($modeP != 'A'){
       $refMP=true;
   $req2='x';//Ne plus afficher les expences
   if($refP !=""){
         $req3= mysql_query("SELECT * FROM invoice_mode_pay where modeP LIKE '$modeP' and reference LIKE '$refP' and num_invoice LIKE '$inv_n'");
     }else{
         $req3= mysql_query("SELECT * FROM invoice_mode_pay where modeP LIKE '$modeP' and num_invoice LIKE '$inv_n'");
       }
     if(mysql_num_rows($req3)>0){
         $refMP=true;
     }else{
         $refMP=false;
     }
   }else{
       $refMP=true;
   }

 //afiichage du code invoice
 $IDinvoice=$inv_n;
 $n=strpos($IDinvoice,"-");
 $IDinvoice=substr($IDinvoice,$n+1);
   //
 if($statut=="unpaid"){
 $col="#FBEFF5";
 }else{
 $col="#E0F8F1";
 }
 if(($stat=="A" || $stat==$statut) && ($modeP=="A" || $refMP==true)){
 //
 if($devise=="EUR"){
 $totalE1=$totalE1+$prix_total;
 }else if($devise=="USD"){
 $totalD1=$totalD1+$prix_total;
 }else if($devise=="TND"){
 $totalT1=$totalT1+$prix_total;
 }
 //
  if($recherche == "IDreception" || $recherche == "IDitem" || $recherche == "IDordre"){
    $reqArt= mysql_query("SELECT * FROM supplier_invoice_items where IDinvoice LIKE '$inv_n' and $recherche='$valeur'");
  }else{
    $reqArt= mysql_query("SELECT * FROM supplier_invoice_items where IDinvoice LIKE '$inv_n'");
  }

  while($dataArt=mysql_fetch_array($reqArt)){
    $qty=$dataArt['qty'];
    $unitP=$dataArt['unit_price'];
    $totalUP=$qty*$unitP;
    $totalUP=round($totalUP,2);
   echo"<tr ><td  style=\"text-align:center ;width:12%;height:70px;background-color:".$col."\">$IDinvoice</td>
 <td  style=\"text-align:center ;width:15%;height:70px;background-color:".$col."\">$supplier</td>
 <td  style=\"text-align:center ;width:10%;height:70px;background-color:".$col."\">$dateF</td>
 <td  style=\"text-align:center ;width:15%;height:70px;background-color:".$col."\">".$dataArt['IDitem']."</td>
 <td  style=\"text-align:center ;width:10%;height:70px;background-color:".$col."\">".$dataArt['IDordre']."</td>
 <td  style=\"text-align:center ;width:10%;height:70px;background-color:".$col."\"><b>$unitP</b></td>
 <td  style=\"text-align:center ;width:8%;height:70px;background-color:".$col."\">$qty</td>
 <td  style=\"text-align:center ;width:10%;height:70px;background-color:".$col."\">$totalUP</td>
 <td style=\"text-align:center ;width:10%;height:70px;background-color:".$col."\">$prix_total  $devise</td></tr>";
}

}
}
   echo '<tr><td colspan=2 style=text-align:right ><b>Total:</b></td><td colspan=10><b>'.$totalE1  .' EUR</b></td></tr>
   <tr><td colspan=2></td><td colspan=10><b>'.$totalT1  .' TND</b></td></tr>
   <tr><td colspan=2></td><td colspan=10><b>'.$totalD1  .' USD</b></td></tr>
   </tbody></table><hr>';
}
 ?>
