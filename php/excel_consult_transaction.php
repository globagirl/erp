 <meta charset="utf-8" />
 <?php
      // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");

// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=transaction_compte.xls");
    include('../connexion/connexionDB.php');
    $compte=$_POST['compte'];
    $req1= "SELECT * FROM transaction_compte WHERE  compte='$compte'  and etat NOT LIKE 'AT' order by IDtrans ASC ";
    $req2= "SELECT * FROM transaction_compte WHERE  compte='$compte' and etat = 'AT' order by IDtrans ASC ";

	echo '<table  class="table table-fixed results" id="table3">
				<thead style="width:100%">
			        <tr>
						<th style="text-align:center">Date</th>
						<th style="text-align:center">Mode</th>
						<th style="text-align:center" >Reference</th>
						<th style="text-align:center">Description</th>
						<th style="text-align:center">Debit</th>
						<th style="text-align:center">Crédit</th>
						<th style="text-align:center">Compte</th>

				    </tr>
				</thead>
			<tbody id="tbody" style="width:100%">';

    $r1=mysql_query($req1) or die(mysql_error());
    $r2=mysql_query($req2) or die(mysql_error());
    $req1=mysql_query("SELECT soldeI,soldeR,REFcompte FROM compte_banque WHERE  REFcompte='$compte'");
	$data=mysql_fetch_array($req1);
	$solde=$data['soldeI'];
	//$soldeR=$data['soldeR'];
	$soldeR=$solde;
	$x=0;
    while($a=mysql_fetch_array($r1)){
	    $x++;
        $typeT=$a['typeT'];
		$ID=$a['IDtrans'];
        $etat=$a['etat'];
		$montant=$a['montant'];
		$col="black";
		if($etat=="AN"){
			$montant=0;
        }
        if($typeT=="RT" && $etat != "AN"){

			$soldeR=$soldeR-$montant;
			$soldeR=round($soldeR,2);

            $solde=$solde-$montant;
			$solde=round($solde,2);
        }else if($etat != "AN"){
            $solde=$solde+$montant;
			$solde=round($solde,2);
			//Solde réel
			$soldeR=$soldeR+$montant;
			$soldeR=round($soldeR,2);

        }

	    echo ('<tr class="'.$x.' '.$etat.'">
		<td  style="text-align:center"><font color='.$col.'>'.$a['dateT'].'</font></td>
		<td  style="text-align:center"><font color='.$col.'><b>'.$a['modeT'].'</b></font></td>
		<td style="text-align:center"><font color='.$col.'>'.$a['ref'].'</font></td>
		<td style="text-align:center"><font color='.$col.'>'.$a['catT'].' : '.$a['description'].'</font></td>');
        if($typeT=='RT'){
		    echo "<td style=\"text-align:center\"><span onclick=\"updateTrans('".$ID."');\"><font color=".$col."><b>-</b>".$montant."</font></span></td><td style=\"width:12%;height:60px;text-align:center\">--</td>";
        }else{
		    echo "<td style=\"text-align:center\">--</td><td style=\"width:12%;height:60px;text-align:center\"><span onclick=\"updateTrans('".$ID."');\"><font color=".$col."><b>+</b>".$montant." </font></span></td>";
        }
		if($solde>0){
		    echo '<td style="text-align:center"><font color='.$col.'>'.$solde.'</font></td>';
        }else{
		    echo '<td style="text-align:center"><font color="red">'.$solde.'</font></td>';
        }
		echo "</tr>";



    }
	//Les en attente
	 while($a2=mysql_fetch_array($r2)){
	    $x++;
        $typeT=$a2['typeT'];
		$ID=$a2['IDtrans'];
        $etat=$a2['etat'];
		$montant=$a2['montant'];
		$col="red";

        if($typeT=="RT" && $etat != "AN"){

            $solde=$solde-$montant;
			$solde=round($solde,2);
        }else if($etat != "AN"){
            $solde=$solde+$montant;
			$solde=round($solde,2);

        }

	    echo ('<tr class="'.$x.' '.$etat.'">
		<td  style="width:11%;height:65px;text-align:center"><font color='.$col.'>'.$a2['dateT'].'</font></td>
		<td  style="width:7%;height:65px;text-align:center"><font color='.$col.'><b>'.$a2['modeT'].'</b></font></td>
		<td style="width:12%;height:65px;text-align:center"><font color='.$col.'>'.$a2['ref'].'</font></td>
		<td style="width:24%;height:65px;text-align:center"><font color='.$col.'>'.$a2['catT'].' : '.$a2['description'].'</font></td>');

		if($typeT=='RT'){
		    echo "<td style=\"width:12%;height:70px;text-align:center\"><span onclick=\"updateTrans('".$ID."');\"><font color=".$col."><b>-</b>".$montant."</font></span></td><td style=\"width:12%;height:60px;text-align:center\">--</td>";
        }else{
		    echo "<td style=\"width:12%;height:70px;text-align:center\">--</td><td style=\"width:12%;height:60px;text-align:center\"><span onclick=\"updateTrans('".$ID."');\"><font color=".$col."><b>+</b>".$montant." </font></span></td>";
        }

		if($solde>0){
		    echo '<td style="width:12%;height:70px;text-align:center"><font color='.$col.'>'.$solde.'</font></td>';
        }else{
		    echo '<td style="width:12%;height:70px;text-align:center"><font color="red">'.$solde.'</font></td>';
        }
		echo "</tr>";



    }
	//
  echo '<tr><td style=\"width:30%;height:60px;text-align:center\">
  <input type="button"  class="btn btn-danger" onClick="redir_ajout_trans()" value="Ajout transaction">
  </td>
       <td style="width:10%;height:60px;text-align:center"> </td>

       <td style="width:10%;height:60px;text-align:center"> </td>
       <td style="width:10%;height:60px;text-align:center"> </td>
       <td style="width:10%;height:60px;text-align:center"> </td>
       <td style="width:30%;height:60px;text-align:center"><b>Solde réel : '.$soldeR.'</b></td></tr>
       </tbody></table>';

mysql_close();
  ?>