 <?php
    include('../connexion/connexionDB.php');
    $compte=$_POST['compte'];
    $req1= "SELECT * FROM transaction_compte WHERE  compte='$compte'  and etat NOT LIKE 'AT' order by IDtrans ASC ";
    $req2= "SELECT * FROM transaction_compte WHERE  compte='$compte' and etat = 'AT' order by IDtrans ASC ";
	echo '<div class="col-md-12 well">
	<div class="col-md-5" style="text-align:right">
	          <input type="text" class="search form-control"  placeholder="Search " onkeyup="mySearch()">
	      </div>
	      <div class="col-md-7" style="text-align:right">
	            <div class="form-group">
					<div class="radio-inline">
					    <label><input type="radio" name="etat" id="E1" value="ALL" checked onClick="mySearch2()">ALL</label>
					</div>
					<div class="radio-inline">
                        <label><input type="radio" name="etat" id="E2" value="AT" onClick="mySearch2()">En attente</label>
					</div>
					<div class="radio-inline ">
                        <label><input type="radio" name="etat" id="E3" value="AN" onClick="mySearch2()">Annulé </label>
					</div>
                </div>

			</div>

		</div>';
	echo '<table  class="table table-fixed results" id="table3">
				<thead style="width:100%">
			        <tr>
						<th style="width:10.8%;height:60px;text-align:center">Date</th>
						<th style="width:6.8%;height:60px;text-align:center">Mode</th>
						<th style="width:11.8%;height:60px;text-align:center" >Reference</th>
						<th style="width:22.8%;height:60px;text-align:center">Description</th>
						<th style="width:11.8%;height:60px;text-align:center">Debit</th>
						<th style="width:11.8%;height:60px;text-align:center">Crédit</th>
						<th style="width:11.8%;height:60px;text-align:center">Compte</th>
						<th style="width:9.8%;height:60px;text-align:center"></th>
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
		<td  style="width:11%;height:70px;text-align:center"><font color='.$col.'>'.$a['dateT'].'</font></td>
		<td  style="width:7%;height:70px;text-align:center"><font color='.$col.'><b>'.$a['modeT'].'</b></font></td>');
		echo "<td style=\"width:12%;height:70px;text-align:center\"  onclick=\"updateTrans('".$ID."');\">
		<span onclick=\"updateTransRef('".$ID."');\">
		<font color=".$col.">".$a['ref']."</font></span></td>";
		echo ('<td style="width:24%;height:70px;text-align:center"><font color='.$col.'>'.$a['catT'].' : '.$a['description'].'</font></td>');
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
		echo '<td style="width:10%;height:70px;">
            <li class="dropdown" style="list-style-type: none;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                         <i class="fa fa-cogs"></i>
                    </a>';

		    echo '
			<ul class="dropdown-menu dropdown-user">
                        <li  class="disabled">  <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-map-marker"></i> Annuler
                        </a></li>
						<li class="divider"></li>
                        <li  class="disabled" ><a class="dropdown-toggle" data-toggle="dropdown" href="#"> <i class="fa fa-check"></i> Passer</a>
                        </li>
                        <li class="divider"></li>';

						echo "
						 <li class=\"divider\"></li>
                        <li> <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" onClick=transDelete('".$ID."');><i class=\"fa fa-times\"></i> Supprimer</a>
                        </li>
                    </ul></li></td></tr>";



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
		<td  style="width:11%;height:70px;text-align:center"><font color='.$col.'>'.$a2['dateT'].'</font></td>
		<td  style="width:7%;height:70px;text-align:center"><font color='.$col.'><b>'.$a2['modeT'].'</b></font></td>');
		echo "<td style=\"width:12%;height:70px;text-align:center\">
		<span onclick=\"updateTransRef('".$ID."');\">
		<font color=".$col.">".$a2['ref']."</font></span></td>";
		echo('<td style="width:24%;height:70px;text-align:center"><font color='.$col.'>'.$a2['catT'].' : '.$a2['description'].'</font></td>');

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
		echo '<td style="width:10%;height:70px;">
            <li class="dropdown" style="list-style-type: none;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                         <i class="fa fa-cogs"></i>
                    </a>';

            echo "
			<ul class=\"dropdown-menu dropdown-user\">
                        <li>  <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" onClick=transAnnule('".$ID."');><i class=\"fa fa-map-marker\"></i> Annuler
                        </a></li>
						<li class=\"divider\"></li>
                        <li  ><a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" onClick=transPass('".$ID."');> <i class=\"fa fa-check\"></i> Passer</a>
                        </li>
                       ";

       				echo "
						 <li class=\"divider\"></li>
                        <li> <a class=\"dropdown-toggle\" data-toggle=\"dropdown\" href=\"#\" onClick=transDelete('".$ID."');><i class=\"fa fa-times\"></i> Supprimer</a>
                        </li>
                    </ul></li></td></tr>";



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
