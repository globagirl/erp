<?php 
include('../connexion/connexionDB.php');
$produit=$_POST['produit'];

$i=0;
$sql = "SELECT * FROM produit1 where code_produit LIKE '%$produit%'";

$res = mysql_query($sql) or exit(mysql_error());
$data=mysql_fetch_array($res);
$prod=$data['code_produit'];

	
	
  	echo " <table><tr><th>Code Produit</th><td colspan=3>   <input type=\"text\" size=\"20 \" name=\"code_produit\" id=\"code_produit\" value=\"".$data['code_produit']."\"></td></tr>
	<tr><th>Produit</th><td colspan=3><input type=\"text\" size=\"20 \" name=\"produit\" id=\"produit\" value=\"".$data['produit']."\"></td></tr> 
	<tr><th>Description</th><td colspan=3><textarea  cols=\"26  \"  rows=\"4\" name=\"desc\" id=\"desc\">".$data['description']."</textarea></td></tr> 
	<tr><th>Catégorie</th><td>   <input type=\"text\" size=\"8\" name=\"cat\" id=\"cat\" value=\"".$data['categorie']."\"></td>
	<th>Poids</th><td>   <input type=\"text\" size=\"4 \" name=\"poids\" id=\"poids\" value=\"".$data['poids']."\"></td>
	</tr>
	<tr>
	<th>Matriel Revision</th><td>   <input type=\"text\" size=\"4 \" name=\"rev\" id=\"rev\" value=\"".$data['revision']."\"></td>
	<th>Drawing Revision </th><td>   <input type=\"text\" size=\"4 \" name=\"Drev\" id=\"Drev\" value=\"".$data['draw_rev']."\"></td>
	</tr>
	<tr><th>Prix</th><td>   <input type=\"text\" size=\"8\" name=\"prix\" id=\"prix\">
	 <input type= \"checkbox\" name=\"check\" id=\"check\" onclick=\"afficheCase();\" value=\"oui\"><i>Inconstant </i>
	</td>
	<th>Devise</th><td>   <input type=\"text\" size=\"4 \" name=\"devise\" id=\"devise\" value=\"".$data['devise']."\"></td>
	</tr> 
	<tr><td></td><td colspan=3> Longueur : <input type=\"text\" size=\"8\" name=\"long\" placeholder=\"Longueur\" id=\"long\" value=\"".$data['longueur']."\" onBlur=\"verifierL();\"> 
	Taille du lot : <input type=\"text\" size=\"8\" name=\"tlot\" id=\"tlot\" placeholder=\"Taille du lot\" value=\"".$data['taille_lot']."\">  nombre par box : <input type=\"text\" size=\"8 \" name=\"nbrB\" id=\"nbrB\" placeholder=\"Nombre par box\" value=\"".$data['nbr_box']."\"></td>
	</td>
	</tr> 
	<tr><th colspan=6>
	</th></tr><tr><td style=\" background-color:#F2E0F7 ;text-align:center\"> <b>Article</b> </td>
	<td colspan=4 style=\" background-color:#F2EOO7 ;text-align:left\"> <b>Quantité </b></td></tr>";	
	
	$sql2 = "SELECT * FROM produit_article1 where IDproduit ='$prod'";
	
	$res2 = mysql_query($sql2) or exit(mysql_error());
    while($data2=mysql_fetch_array($res2)) {
		$i++;
		$ar="ar".$i;
	    $qte="qte".$i;
		echo "<tr><td style=\" background-color:#F2E0F7 ;text-align:center\"><b>".$data2['IDarticle']."</b>
		<input type=\"text\" size=\"2\" name=\"".$ar."\" id=\"".$ar."\" value=\"".$data2['IDarticle']."\" HIDDEN></td>
        <td colspan=4>   <input type=\"text\" size=\"5 \" name=\"".$qte."\" id=\"".$qte."\" value=\"".$data2['qte']."\"></td>
	    </tr>";
	
	
}
echo"<tr><td><input type=\"text\" size=\"8\" name=\"nbrA\" id=\"nbrA\" value=\"".$i."\" /HIDDEN></td>
<td>  <input type=\"submit\" id=\"submitbutton\" value=\"Dupliquer\" /> </td></tr></table>";

	mysql_close();
	
	
	?>
	
