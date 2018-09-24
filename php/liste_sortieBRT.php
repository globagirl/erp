<?php
include('../connexion/connexionDB.php');
$PO=$_POST['PO'];
$typeR=$_POST['typeR'];
$sql = mysql_query("SELECT OF,produit FROM ordre_fabrication1 where PO='$PO'");
$x=0;
while($data=mysql_fetch_array($sql)){
    $OF=$data['OF'];
    $produit=$data['produit'];
	
	echo '<hr>
   <div class="form-group form-inline">
     <label>OF : </label>
     <input type="text"  class="form-control" value='.$OF.' READONLY> 
     
     <label>Produit : </label>
     <input type="text" class="form-control" value='.$produit.' READONLY> 
     </div>
     
     
	<hr>';
  if($typeR=="P"){
	$sql1 = mysql_query("SELECT * FROM sortie_items where IDbande=(SELECT IDsortie from bande_sortie where OF='$OF')");
	while($data1=mysql_fetch_array($sql1)){
        $x++;
		$IDsortie=$data1['IDsortie'];
		$IDpaquet=$data1['IDpaquet'];
		$qte=$data1['qte'];
		$qteR=$data1['qteR'];
		$paq="paq".$x;
		$qteX="qte".$x;
		$qteR="qteR".$x;
		$chek="chek".$x;
		$idSI="idSI".$x;
		echo "<div class=\"well form-inline\">		         
				<input type=\"text\" class=\"form-control\" name=".$paq." id=".$paq." value=".$IDpaquet." readonly> 
				<input type=\"text\" class=\"form-control\" name=".$qteX." id=".$qteX." value=".$qte." readonly>		
				<input type=\"checkbox\" class=\"form-control\" name=".$chek." id=".$chek." onClick=affiche_zone('".$x."') > 
				<input type=\"text\" name=".$qteR." id=".$qteR." placeholder=\"QTY\" class=\"form-control\" readonly > 	
				<input type=\"text\" name=".$idSI." id=".$idSI." value=".$IDsortie." class=\"form-control\"  size=\"4\" style=\"visibility:hidden\">
				</div>";
    }
  }else{
	$sql1 = mysql_query("SELECT DISTINCT(IDarticle) FROM produit_article1 where IDproduit='$produit'");
	while($data1=mysql_fetch_array($sql1)){
        $x++;
		$IDarticle=$data1['IDarticle'];		
		
		$art="art".$x;		
		$qteR="qteR".$x;
		$chek="chek".$x;
		
		echo "<div class=\"well form-inline\">		         
				<input type=\"text\" class=\"form-control\" name=".$art." id=".$art." value=".$IDarticle." readonly> 
						
				<input type=\"checkbox\" class=\"form-control\" name=".$chek." id=".$chek." onClick=affiche_zone('".$x."') > 
				<input type=\"text\" name=".$qteR." id=".$qteR." placeholder=\"QTY\" class=\"form-control\" readonly > 	
				
				</div>";
    }
 }
}
echo '<div class="well"><input type="button" onClick="verifier();" class="btn btn-primary" Value="Envoyer >>">
<input type="text"  name="nbr" id="nbr" value='.$x.' style="visibility:hidden"> </div>';
/*
}else{
   echo '1';
}*/
mysql_close();
?>