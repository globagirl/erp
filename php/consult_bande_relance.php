 <?php
    include('../connexion/connexionDB.php');
    $val=$_POST['valeur'];
    $recherche=$_POST['recherche'];
    $statut=$_POST['statut'];
    if($statut=="ALL"){
		if ($recherche=="A"){
            $req= "SELECT * FROM bande_relance  order by IDrelance DESC ";
        }else if($recherche != "PO" && $recherche != "produit"){
            $req= "SELECT * FROM bande_relance where $recherche='$val'  order by OF DESC";
        }else{
		    $req= "SELECT * FROM bande_relance where OF IN (SELECT OF FROM ordre_fabrication1 where $recherche='$val') order by OF DESC";
		}
	}else{
		if ($recherche=="A"){
            $req= "SELECT * FROM bande_relance where statut LIKE '$statut' order by IDrelance DESC ";
        }else if($recherche != "PO" && $recherche != "produit"){
            $req= "SELECT * FROM bande_relance where $recherche='$val' and statut LIKE '$statut' order by OF DESC";
        }else{
		    $req= "SELECT * FROM bande_relance where OF IN (SELECT OF FROM ordre_fabrication1 where $recherche='$val') and statut LIKE '$statut' order by OF DESC";
		}
	}
	$x=0;
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_array($r)){	
        $x++;
		$OF =$a['OF'];
		$stat=$a['statut'];
		if($stat=="A"){
		  $statut="En attente ";
		}else if($stat=="C"){
		  $statut="Confirmé ";
		}else if($stat=="R"){
		  $statut="Refusée ";
		}else if($stat=="T"){
		  $statut="Traité ";
		}else if($stat=="CT"){
		  $statut="Controlé ";
		}
														
		$req1= mysql_query("SELECT PO,produit FROM ordre_fabrication1 where OF='$OF'");	
		$a1=mysql_fetch_array($req1);
		$IDrelance=$a['IDrelance'];
        echo("<tr><td style=\"width:15%;height:40px;text-align:center\" >".$a['IDrelance']."</td>");
		echo ('
		<td style="width:20%;height:40px;text-align:center">'.$a1['PO'].'</td>
		<td style="width:15%;height:40px;text-align:center">'.$a['OF'].'</td>
		<td style="width:20%;height:40px;text-align:center">'.$a1['produit'].'</td>
		<td style="width:10%;height:40px;text-align:center">'.$a['nbr_piece'].'</td>
		<td style="width:10%;height:40px;text-align:center">'.$statut.'</td>');
		echo "<td style=\"width:10%;height:40px;text-align:center\">
		<input type=\"button\" onClick=afficheInfo('".$IDrelance."'); Value=\">>\"></td></tr>";
    }
    mysql_close();


  ?>