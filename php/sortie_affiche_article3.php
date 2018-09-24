<?php
include('../connexion/connexionDB.php');
$recherche=$_POST['recherche'];
$valeur=$_POST['valeur'];
$typeS=$_POST['typeS'];
if($typeS=="P"){
    //$statut="planned";
    $sq=mysql_query("select * from ordre_fabrication1 where $recherche='$valeur' and (statut='planned'or statut='in progres')");
}else{
    //$statut="in progres";
    $sq=mysql_query("select * from ordre_fabrication1 where $recherche='$valeur' and statut='in progres'");
    
}

//$sq=mysql_query("select * from ordre_fabrication1 where PO='$PO'");
if(mysql_num_rows($sq)>0){
    $data1=mysql_fetch_array($sq);
	$produit=$data1['produit'];
	$qte=$data1['qte'];
	$OF=$data1['OF'];
	$PO=$data1['PO'];
    $statut=$data1['statut'];
	$i=0;
////////////////////////
if($statut == "in progres"){
    echo(" <div class=\"alert alert-danger\">Vous avez  déja effectué une sortie pour cette commande </div>");
}
 echo"<div class=\"well\"> 
 <div class=\"form-group form-inline\"> 
     <label>PO : </label>
	 <input type=\"text\" class=\"form-control\" value=\"".$PO."\" id=\"PO\" name= \"PO\" /READONLY>
 </div>
 <div class=\"form-group form-inline\"> 
     <label>OF : </label>
	 <input type=\"text\" class=\"form-control\" value=\"".$OF."\" id=\"OF\" name= \"OF\" /READONLY>
 </div>
 <div class=\"form-group form-inline\"> 
     <label>Produit: </label>
	 <input type=\"text\" class=\"form-control\" value=\"".$produit."\" id=\"PRD\" name= \"PRD\" /READONLY>
 </div>";
 
//Vérification des produits non TE 
$sqlV=mysql_query("SELECT etat FROM fin_alert where produit='$produit'");
if(@mysql_num_rows($sqlV)>0){
    $etat=mysql_result($sqlV,0);
	if($etat=="F"){
        echo(" <div class=\"alert alert-danger\">Il est strictement interdit d'utiliser un cable avec un logo TE </div>");
    }else{
        echo("<div class=\"alert alert-warning\">Vous pouvez encore utiliser un cable avec un logo TE jusqu'a la fin du mois janvier</div");
    }
}

//Fin verification
//Affichage
echo '<table  class="table" >		
		<tbody id="tbody2" style="width:100%">';
if($typeS=="P"){
    $sql = "SELECT * FROM produit_article1 where IDproduit='$produit'";
    $res = mysql_query($sql) or exit(mysql_error());    
    while($data=mysql_fetch_array($res)) {
	    $i++;
		$b1=$data["qte"];
		$besoin=$b1*$qte;
		$art=$data["IDarticle"];
		$sql2=mysql_query("select stock,unit,code_article from article1 where code_article='$art'");
		$data2=mysql_fetch_array($sql2);
		$stock=$data2["stock"];
		$unit=$data2["unit"];
		echo'<tr>
		<td style="width:25%;height:40px">Article '.$i.' : </td>
		<td style="width:25%;height:40px"> '.$art.'  </td>
		<td style="width:25%;height:40px"> <b>'.$besoin.' '.$unit.' </b> </td>
		<td style="width:25%;height:40px"> '.$stock.' '.$unit.'  </td>
		</tr>';
    }
}else{
    $sql = "SELECT IDrelance,IDitem,qty FROM bande_relance_items where IDrelance=(SELECT IDrelance FROM bande_relance where OF='$OF' and statut='C')";
    $res = mysql_query($sql) or exit(mysql_error());    
    while($data=mysql_fetch_array($res)) {
	    $i++;		
		$art=$data["IDitem"];
		$sql2=mysql_query("select stock,unit,code_article from article1 where code_article='$art'");
		$data2=mysql_fetch_array($sql2);
		$stock=$data2["stock"];
		$unit=$data2["unit"];
		echo'<tr>
		<td style="width:25%;height:40px">Article '.$i.' : </td>
		<td style="width:25%;height:40px"> '.$art.'  </td>
		<td style="width:25%;height:40px"> <b>'.$data["qty"].' '.$unit.' </b> </td>
		<td style="width:25%;height:40px"> '.$stock.' '.$unit.'  </td>
		</tr>';
    }
}
	echo '</table></div>';
	//Gestion des paquets
	echo "<div id=\"paq1\" class=\"col-md-8 well\">
	<div class=\"form-group form-inline\">     
	 <select id=\"A1\" name=\"A1\"  onChange=affichelisteP('A1','P1');  class=\"form-control\"  >
	   <option value=\"1\">---Selectionnez</option>
	 </select>
	 <select id=\"P1\" name=\"P1\"  onChange=stockP('P1','S1','1'); class=\"form-control\"  >
	     <option value=\"1\">---Selectionnez</option>
	 </select>
	<input type=\"text\" id=\"S1\" name=\"S1\" class=\"form-control\" size=\"8\" READONLY> 
	<input type=\"text\"  id=\"Q1\" name=\"Q1\"  class=\"form-control\" size=\"8\" placeholder=\"QTY\">
 </div>
 </div>
 <div  class=\"col-md-4 well \">
 <input type=\"text\" id=\"nbr\" name=\"nbr\" size=\"4\" value=\"1\" HIDDEN>
 <input type=\"button\"  value=\"+\" onclick=\"add()\" class=\"btn btn-primary\"/>
  <input type=\"button\"  value=\"-\" onclick=\"deleteZ()\" class=\"btn btn-primary\"/>
  <input type=\"button\"  value=\"Envoyer >> \" onclick=\"verifier();\" class=\"btn btn-danger pull-right\"/>
 </div>";
}else{
    echo "0"; 
}
mysql_close();
?>
