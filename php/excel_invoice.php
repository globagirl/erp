<meta charset="utf-8" />
<?php
   // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");

// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=facture.xls");
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
        $req1= "SELECT * FROM supplier_invoice where IDinvoice in (SELECT IDinvoice FROM supplier_invoice_items where  $recherche like '$valeur')";
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
        $req1= "SELECT * FROM supplier_invoice where (($margeD >= '$date1') and ($margeD <= '$date2')) and IDinvoice in (SELECT IDinvoice FROM supplier_invoice_items where  $recherche like '$valeur')";
		      $req2= "x";
    }else{
        $req2="x";
        $req1= "SELECT * FROM supplier_invoice where (($recherche like '%$valeur%') and (($margeD >= '$date1') and ($margeD <= '$date2')))";
    }
}
//
//



if($req1 != "x"){
  $r=mysql_query($req1) or die(mysql_error());
  echo'<table  id="myTable">
  <tr style=text-align:center><th style=text-align:center><b>Invoice N°</b></th>
  <th style=text-align:center><b>Supplier</b></th>
  <th style=text-align:center><b>Invoice type</b></th>
  <th style=text-align:center><b>Invoice category</b></th>
  <th style=text-align:center><b>Invoice date</b></th>
  <th style=text-align:center><b>Date dernier pay</b></th>
  <th style=text-align:center><b>Total</b></th>
  <th style=text-align:center><b>Devise</b></th>
  <th style=text-align:center><b>Cours TND</b></th>
  <th style=text-align:center><b>Montant TND</b></th>
  <th style=text-align:center><b>Mode payement</b></th>
  <th style=text-align:center><b>Reference</b></th>
  <th style=text-align:center><b>Compte</b></th>
  <th style=text-align:center><b>Banque</b></th>
  <th style=text-align:center><b>Date payment</b></th>
  </tr>';
  while($a=mysql_fetch_object($r)){
  $inv_n=$a->IDinvoice;
  $supplier =$a->supplier;
	$dateF=$a->dateF;
	$dateP=$a->dateP;
	$prix_total=$a->total;
	$ship=$a->shipCoast;
	$tax=$a->tax;
	$typeI=$a->typeI;
	$catI=$a->catI;
	$fileI=$a->fileI;
	$devise=$a->currency;
	$coursTND=$a->coursTND;
	$statut=$a->status;
	//Vérification par mode de payment
  if($modeP == "compte"){
    $refMP=true;
    $req2='x';//Ne plus afficher les expences
    $req3= mysql_query("SELECT * FROM invoice_mode_pay where compte LIKE '$refP' and num_invoice LIKE '$inv_n'");

      if(mysql_num_rows($req3)>0){
          $refMP=true;
      }else{
          $refMP=false;
      }

  }else if($modeP != 'A'){
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
		$req3= mysql_query("SELECT * FROM invoice_mode_pay where  num_invoice LIKE '$inv_n'");

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
	if($coursTND != 0){
      $montTND=$coursTND*$prix_total;
	}else{
	  $montTND=$prix_total;
	}
	//
    echo"<tr ><td  style=\"text-align:center ;background-color:".$col."\">$IDinvoice</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$supplier</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$typeI</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$catI</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$dateF</td>
	<td  style=\"text-align:center ;background-color:".$col."\">$dateP</td>
	<td style=\"text-align:center ;background-color:".$col."\">$prix_total</td>
	<td style=\"text-align:center ;background-color:".$col."\">$devise</td>
	<td style=\"text-align:center ;background-color:".$col."\">$montTND</td>
	<td style=\"text-align:center ;background-color:".$col."\">$coursTND</td>";
	$j=0;
	while($data3=mysql_fetch_array($req3)){
	    $compte=$data3["compte"];
		$NUMbanque="---";
	    $banque="---";
		if($compte != ""){
		    $req4=mysql_query("SELECT * FROM compte_banque where  REFcompte LIKE '$compte'");
		    $data4=mysql_fetch_array($req4);
			$NUMbanque=$data4["NUMcompte"];
			$banque=$data4["banque"];
		}
	    $j++;
	    if($j>1){
		    echo "<tr><td colspan=10 style=\"text-align:center ;background-color:".$col."\"></td>";
		}
		echo "<td  style=\"text-align:center ;background-color:".$col."\">".$data3["modeP"]."</td>
		<td  style=\"text-align:center ;background-color:".$col."\">".$data3["reference"]."</td>
		<td  style=\"text-align:center ;background-color:".$col."\">".$NUMbanque."</td>
		<td  style=\"text-align:center ;background-color:".$col."\">".$banque."</td>
		<td  style=\"text-align:center ;background-color:".$col."\">".$data3["dateP"]."</td></tr>

		";
	}

	}//Fin si
	}//fin while


    echo '<tr><td colspan=2 style=text-align:right ><b>Total:</b></td><td colspan=10><b>'.$totalE1  .' EUR</b></td></tr>
    <tr><td colspan=2></td><td colspan=10><b>'.$totalT1  .' TND</b></td></tr>
    <tr><td colspan=2></td><td colspan=10><b>'.$totalD1  .' USD</b></td></tr>
    </thead></table><hr>';
}
if($req2!= "x"){


  $r1=mysql_query($req2) or die(mysql_error());
  $V=0;
  echo'<table><thead>
  <tr style="background-color:#CEF6EC">
  <th style=text-align:center><b>Expense N°</b></th>
  <th style=text-align:center><b>Description</b></th>
  <th style=text-align:center><b>Expense type</b></th>
  <th style=text-align:center><b>Entry date</b></th>
  <th style=text-align:center><b>Payment date</b></th>
  <th style=text-align:center><b>Amount</b></th>
  <th style=text-align:center><b>Devise</b></th>

  </tr>';
  while($a1=mysql_fetch_object($r1))
    {



    $inv_n=$a1->IDexpense;
	$dateE=$a1->dateE;
	$dateP=$a1->dateP;
	$prix_total=$a1->amount;
	$fileE=$a1->fileE;
	$catI=$a1->catI;
	$devise=$a1->currency;
	$desc=$a1->description;



	if($devise=="EUR"){
	$totalE2=$totalE2+$prix_total;
	}else if($devise=="USD"){
	$totalD2=$totalD2+$prix_total;
	}else if($devise=="TND"){
	$totalT2=$totalT2+$prix_total;
	}

    echo"<tr><td style=\"text-align:center\">$inv_n</td>
	<td style=\"text-align:center\">$desc</td>
	<td style=\"text-align:center\">$catI</td>
	<td style=\"text-align:center\">$dateE</td>
	<td style=\"text-align:center\">$dateP</td>
	<td style=\"text-align:center\">$prix_total </td>
	<td style=\"text-align:center\"> $devise</td></tr>";

	}

  echo '<tr><td colspan=2 style=text-align:right><b>Total:</b></td><td colspan=5><b>'.$totalT2  .' TND</b></td></tr>

  <tr><td colspan=2></td><td colspan=5><b>'.$totalE2  .' EUR</b></td></tr>
  <tr><td colspan=2></td><td colspan=5><b>'.$totalD2  .' USD</b></td></tr>
  </table>';
}
  ?>
