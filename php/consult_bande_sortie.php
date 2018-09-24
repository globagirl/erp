 <?php
    include('../connexion/connexionDB.php');
    $val=$_POST['valeur'];
    $recherche=$_POST['recherche'];
    $statut=$_POST['statut'];
    if($statut=="ALL"){
		if ($recherche=="A"){
            $req= "SELECT * FROM bande_sortie";
        }else if ($recherche != "produit" && $recherche != "IDpaquet"){
            $req= "SELECT * FROM bande_sortie  where $recherche='$val'";
        }else if($recherche == "produit"){
		    $req= "SELECT * FROM bande_sortie where PO IN (SELECT POitem FROM commande_items where $recherche='$val')";
		}else{
		    $req= "SELECT bande_sortie.IDsortie,bande_sortie.PO,bande_sortie.OF,bande_sortie.dateS,bande_sortie.statut  FROM bande_sortie , sortie_items  where  sortie_items.IDpaquet LIKE '$val%' and sortie_items.IDbande=bande_sortie.IDsortie";
		}
	}else{
		if ($recherche=="A"){
            $req= "SELECT * FROM bande_sortie where statut='$statut'";
        }else if(($recherche != "produit")&& ($recherche != "IDpaquet")){
            $req= "SELECT * FROM bande_sortie where $recherche='$val' and statut='$statut'";
        }else if($recherche != "produit"){
		    $req= "SELECT * FROM bande_sortie where PO IN (SELECT POitem FROM commande_items where $recherche='$val') and statut='$statut'";
		}else{
		    $req= "SELECT bande_sortie.IDsortie,bande_sortie.PO,bande_sortie.OF,bande_sortie.dateS,bande_sortie.statut  FROM bande_sortie , sortie_items  where  sortie_items.IDpaquet LIKE '$val%' and sortie_items.IDbande=bande_sortie.IDsortie and bande_sortie.statut='$statut'";
		}
	}
	$x=0;
    $r=mysql_query($req) or die(mysql_error());
        while($a=mysql_fetch_array($r)){	
           $x++;
		   $PO=$a['PO'];
		   $stat=$a['statut'];
		   if($stat=="N"){
		      $statut="Non confirmé ";
		   }else if($stat=="C"){
		      $statut="Confirmé ";
		   }
		   $r1= mysql_query("SELECT produit FROM commande_items where POitem='$PO'");	
		   $prod=mysql_result($r1,0);
		   $IDbande=$a['IDsortie'];														
			echo ('<tr>
			<td style="width:15%;height:40px;text-align:center">'.$a['PO'].'</td>
			<td style="width:15%;height:40px;text-align:center">'.$a['OF'].'</td>
			<td style="width:20%;height:40px;text-align:center">'.$prod.'</td>
			<td style="width:20%;height:40px;text-align:center">'.$a['dateS'].'</td>
			<td style="width:15%;height:40px;text-align:center">'.$statut.'</td>');
			echo "<td style=\"width:15%;height:40px;text-align:center\">														<input type=\"button\" onClick=afficheInfoS('".$IDbande."'); Value=\">>\"></td></tr>";
		}
    
    mysql_close();


  ?>