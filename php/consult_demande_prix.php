<?php	
   include('../connexion/connexionDB.php');
   $recherche=$_POST['recherche'];
   $valeur=$_POST['valeur'];
   if($recherche != "IDarticle"){
       $req=mysql_query("SELECT * FROM demande_prix where $recherche LIKE '$valeur'");
   }else{
       $req=mysql_query("SELECT * FROM demande_prix where IDdemande IN (SELECT IDdemande FROM demande_prix_article where IDarticle LIKE '$valeur')");
   }   
   while($a=@mysql_fetch_array($req)){
     $IDdemande=$a['IDdemande'];
	 if($recherche != "IDarticle"){
	    $req2= mysql_query("SELECT IDarticle,qte FROM demande_prix_article where IDdemande='$IDdemande'");
	 }else{
	    $req2= mysql_query("SELECT IDarticle,qte FROM demande_prix_article where IDdemande='$IDdemande' and IDarticle LIKE '$valeur'");
	 }
	 while($a1=@mysql_fetch_array($req2)){
 	        echo'<tr><td style="width:10%;height:60px;text-align:center;">'.$IDdemande.'</td>
			<td style="width:23%;height:60px;text-align:center;">'.$a['fournisseur'].'</td>
			<td style="width:12%;height:60px;text-align:center;">'.$a['dateD'].'</td>
			<td style="width:15%;height:60px;text-align:center;">'.$a1['IDarticle'].'</td>
			<td style="width:13%;height:60px;text-align:center;">'.$a1['qte'].'</td>
			<td style="width:10%;height:60px;text-align:center;">'.$a['devise'].'</td>
			<td style="width:10%;height:60px;text-align:center;">'.$a['termeP'].'</td>
			';
			echo "<td style=\"width:7%;height:60px;text-align:center\">
			<img src=\"../image/print.png\" onclick=print_demande('".$IDdemande."'); style=\"cursor:pointer;\" target=\"_blank\" width=\"30\" height=\"30\"  />
			</td>
			</tr>";
    }
	}
mysql_close();
?>