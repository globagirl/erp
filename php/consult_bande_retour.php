 <?php
    include('../connexion/connexionDB.php');
    $val=$_POST['valeur'];
    $recherche=$_POST['recherche'];
    $statut=$_POST['statut'];
    if($statut=="ALL"){
		if ($recherche=="A"){
            $req= "SELECT * FROM bande_retour";
        }else if($recherche != "produit"){
            $req= "SELECT * FROM bande_retour where $recherche='$val'";
        }else{
		    $req= "SELECT * FROM bande_retour where PO IN (SELECT POitem FROM commande_items where $recherche='$val')";
		}
	}else{
		if ($recherche=="A"){
            $req= "SELECT * FROM bande_retour where statut LIKE '$statut'";
        }else if($recherche != "produit"){
            $req= "SELECT * FROM bande_retour where $recherche='$val' and statut LIKE '$statut'";
        }else{
		    $req= "SELECT * FROM bande_retour where PO IN (SELECT POitem FROM commande_items where $recherche='$val') and statut LIKE '$statut'";
		}
	}
	$x=0;
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_array($r)){	
           $x++;
		   $PO=$a['PO'];
		   $stat=$a['statut'];
		   $typeR=$a['typeR'];
		   if($stat=="N"){
		   $statut="Non confirmé ";
		   }else if($stat=="C"){
		   $statut="Confirmé ";
		   }
		   $req1= mysql_query("SELECT produit FROM commande_items where POitem='$PO'");	
		   $prod=mysql_result($req1,0);
		   $IDop=$a['operateur1'];
		   $req2= mysql_query("SELECT nom FROM users1 where ID='$IDop'");														$user=mysql_result($req2,0);
		   $IDretour=$a['IDretour'];
		   echo ('<tr>
		   <td style="width:15%;height:40px;text-align:center">'.$user.'</td>
		   <td style="width:15%;height:40px;text-align:center">'.$a['dateR'].'</td>
		   <td style="width:20%;height:40px;text-align:center">'.$a['PO'].'</td>
		   <td style="width:20%;height:40px;text-align:center">'.$prod.'</td>
		   <td style="width:15%;height:40px;text-align:center">'.$statut.'</td>');												echo "<td style=\"width:15%;height:40px;text-align:center\">														<input type=\"button\" onClick=afficheInfoRT('".$IDretour."','".$stat."','".$typeR."'); Value=\">>\"></td></tr>";
    }
    mysql_close();


  ?>