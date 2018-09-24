<?php
    include('../connexion/connexionDB.php');
	$PO=$_POST['PO'];
	$nbr=@$_POST['nbr'];
	$nbr++;
	$sqlAuto=mysql_query("select statut from commande_items where POitem='$PO'");
	$statAuto=mysql_result($sqlAuto,0);
	if($statAuto=="auto"){
        $sql=mysql_query("select * from commande_items where POitem='$PO'");
        $data2=mysql_fetch_array($sql);
        $TR=$data2['POitem'];
		/////////////////
		$O="OF".$nbr;
		$P="PO".$nbr;
		$B="BOX".$nbr;
		$POG=$data2['PO'];
		$sqlG=mysql_query("select * from commande2 where PO='$POG'");
		$dataG=mysql_fetch_array($sqlG);
		echo("<tr id=".$TR."><td>".$data2['PO']."</td><td>".$data2['POitem']."<input type=\"text\" name=\"".$P."\" value=\"".$data2['POitem']."\"  size=2 HIDDEN></td>
		<td> <input type=\"text\" name=\"".$O."\"  size=2 HIDDEN></td>
		<td>".$data2['produit']."</td><td>".$dataG['date_exped']."</td><td>".$data2['qty']."</td>
		<td> <input type=\"text\" name=\"".$B."\" value=\"1\" size=5></td>
		<td><input type=\"button\" id=\"bigbutton\" value=\"X\" onclick=\"deleteZ('".$TR."');\"></td></tr>");

    }else{
        $sq=mysql_query("select * from ordre_fabrication1 where PO='$PO' and statut='finished'");
		$nb=mysql_num_rows($sq);
		if($nb>0){
            while($data=mysql_fetch_array($sq)) {
                $sql=mysql_query("select * from commande_items where POitem='$PO'");
				$data2=mysql_fetch_array($sql);
				$TR=$data['OF'];
				///////////Definir NBR BOX 
				$produit=$data['produit'];
				$sql8 = mysql_query("SELECT * FROM produit1 where code_produit='$produit'");
				$data3=mysql_fetch_array($sql8);
				$nbP=$data3['nbr_box'];
				$TLot=$data3['taille_lot'];
				$qte=$data['qte'];
				if($nbP==0){
                    $box=1;
                }else if($nbP>$qte){
                    $box=1;

                }else{
                    $box=$qte/$nbP;
				}
                /////////////////
				$O="OF".$nbr;
				$B="BOX".$nbr;
				echo("<tr id=".$TR."><td>".$data2['PO']."</td><td>".$data2['POitem']."</td>
				<td>".$data['OF']." <input type=\"text\" name=\"".$O."\" value=\"".$data['OF']."\" size=2 HIDDEN></td>
				<td>".$data['produit']."</td><td>".$data['date_exped_conf']."</td><td>".$data['qte']."</td>
				<td> <input type=\"text\" name=\"".$B."\" value=\"".$box."\" size=5></td>
				<td><input type=\"button\" id=\"bigbutton\" value=\"X\" onclick=\"deleteZ('".$TR."');\"></td></tr>");
            }
		}
    }
?>