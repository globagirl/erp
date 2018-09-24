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



if($req1 != "x"){
  $r=mysql_query($req1) or die(mysql_error());
  echo '<table  class="table table-fixed results" id="table3">
				<thead style="width:100%">
			        <tr>
						<th style="width:11.8%;height:60px;text-align:center">N° facture</th>
						<th style="width:14.8%;height:60px;text-align:center">Fournisseur</th>
						<th style="width:9.8%;height:60px;text-align:center" >Type</th>
						<th style="width:17.8%;height:60px;text-align:center">Categorie</th>
						<th style="width:9.8%;height:60px;text-align:center">Date facture</th>
						<th style="width:9.8%;height:60px;text-align:center">Date payment</th>
						<th style="width:9.8%;height:60px;text-align:center">Total</th>
						<th style="width:9.8%;height:60px;text-align:center"></th>
						<th style="width:4.8%;height:60px;text-align:center"></th>
				    </tr>
				</thead>
			<tbody id="tbody" style="width:100%">';
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
    echo"<tr ><td  style=\"text-align:center ;width:12%;height:70px;background-color:".$col."\">$IDinvoice</td>
	<td  style=\"text-align:center ;width:15%;height:70px;background-color:".$col."\">$supplier</td>
	<td  style=\"text-align:center ;width:10%;height:70px;background-color:".$col."\">$typeI</td>
	<td  style=\"text-align:center ;width:18%;height:70px;background-color:".$col."\">$catI</td>
	<td  style=\"text-align:center ;width:10%;height:70px;background-color:".$col."\">$dateF</td>
	<td  style=\"text-align:center ;width:10%;height:70px;background-color:".$col."\">$dateP</td>
	<td style=\"text-align:center ;width:10%;height:70px;background-color:".$col."\">$prix_total  $devise</td>";

	$sqlF=mysql_query("SELECT * from invoice_files where IDinvoice='$inv_n'");
	echo"<td style=\"text-align:center ;width:10%;height:70px;background-color:".$col."\">";
	while($data=mysql_fetch_array($sqlF)){
	    echo"<a href=\"../files/invoices/".$data['nameF']."\" target=\"_blank\"><img src=\"../image/viewFile2.png\" alt=\"view\" width=\"30\" height=\"25\"></a>";
	}
	echo"</td>";
	echo '<td style="width:5%;height:70px;">
            <li class="dropdown pull-left" style="list-style-type: none;" data-placement="left">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" >
                         <i class="fa fa-cogs"></i>
                    </a>';
	echo "<ul class=\"dropdown-menu dropdown-messages\">
              <li><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" onClick=consult_info('".$inv_n."');><i class=\"fa fa-align-left\"></i> Information géneral</a></li>
			  <li class=\"divider\"></li>
			  <li>  <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" onClick=ajout_fichier('".$inv_n."');><i class=\"fa fa-image\"></i> Ajouter fichier</a></li>
			  <li class=\"divider\"></li>
			  <li>  <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" onClick=update_facture('".$inv_n."');><i class=\"fa fa-edit\"></i> Modifier</a></li>
			  <li class=\"divider\"></li>
             ";
	if($typeI == "Purchase"){
	echo "
                <li> <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" onClick=consult_items('".$inv_n."');><i class=\"fa fa-list-ul\"></i>Consulter Items</a>
                </li><li class=\"divider\"></li>
          ";

	}else{
	echo "
              <li class=\"disabled\"> <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" ><i class=\"fa fa-list-ul\"></i>Consulter Items</a>
              </li><li class=\"divider\"></li>
     ";
	}
	if($statut == "paid"){
	echo "
                <li> <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" onClick=update_facture_pay('".$inv_n."');><i class=\"fa fa-euro\"></i> Mode payment</a>
                </li>
          </ul></li></td></tr>";

	}else{
	echo "
              <li class=\"disabled\"> <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" ><i class=\"fa fa-euro\"></i> Mode payment</a>
              </li>
     </ul></li></td></tr>";
	}


	}//Fin si
	}//fin while


    echo '<tr><td colspan=2 style=text-align:right ><b>Total:</b></td><td colspan=10><b>'.$totalE1  .' EUR</b></td></tr>
    <tr><td colspan=2></td><td colspan=10><b>'.$totalT1  .' TND</b></td></tr>
    <tr><td colspan=2></td><td colspan=10><b>'.$totalD1  .' USD</b></td></tr>
    </tbody></table><hr>';
}
/*else{*/
if($req2!= "x"){

  $r1=mysql_query($req2) or die(mysql_error());
  $V=0;
  echo'<table  class="table table-fixed results" id="table3">
				<thead style="width:100%">
			        <tr>
						<th style="width:9.8%;height:60px;text-align:center">Expense N°</th>
						<th style="width:34.8%;height:60px;text-align:center">Description</th>
						<th style="width:14.8%;height:60px;text-align:center" >Type</th>
						<th style="width:9.8%;height:60px;text-align:center">Date entrée</th>
						<th style="width:9.8%;height:60px;text-align:center">Date payment</th>
						<th style="width:9.8%;height:60px;text-align:center">Montant</th>
						<th style="width:9.8%;height:60px;text-align:center"></th>

				    </tr>
				</thead>
			<tbody id="tbody" style="width:100%">';
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

    echo"<tr><td style=\"text-align:center;width:10%;height:60px;\">$inv_n</td>
	<td style=\"text-align:center;width:35%;height:60px;\">$desc</td>
	<td style=\"text-align:center\;width:15%;height:60px;\">$catI</td>
	<td style=\"text-align:center\;width:10%;height:60px;\">$dateE</td>
	<td style=\"text-align:center;width:10%;height:60px;\">$dateP</td>
	<td style=\"text-align:center;width:10%;height:60px;\">$prix_total  $devise</td>";

	echo"<td style=\"text-align:center\">";
	if($fileE != ""){
	echo"<a href=\"../files/expenseFiles/".$fileE."\" target=\"_blank\"><img src=\"../image/viewFile2.png\" alt=\"view\" width=\"35\" height=\"30\">";
	}
	echo"</a></td></tr>";
	}

  echo '<tr><td colspan=2 style=text-align:right><b>Total:</b></td><td colspan=5><b>'.$totalT2  .' TND</b></td></tr>

  <tr><td colspan=2></td><td colspan=5><b>'.$totalE2  .' EUR</b></td></tr>
  <tr><td colspan=2></td><td colspan=5><b>'.$totalD2  .' USD</b></td></tr>
  </table>';
}
  ?>
