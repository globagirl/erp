<?php 
include('../connexion/connexionDB.php');
$produit=$_POST['produit'];

$sql = mysql_query("SELECT * FROM prices where IDproduit LIKE '$produit'");
$j=0;

while($data1=mysql_fetch_array($sql)){
	
	 $j++;
	 $mL="mL".$j;
     $mH="mH".$j;
     $p="P".$j;
     $D="D".$j;
	 $H=$data1['marginH'];
	if($H=='-1'){
		$H='X';
	}
	  echo("<TR id=".$D."><Th  >From </th><td> <input type=\"text\" size=\"8 \" name=\"".$mL."\" id=\"".$mL."\" value=\"".$data1['marginL']."\"></td>
	<Th >TO </th><td> <input type=\"text\" size=\"8 \" name=\"".$mH."\" id=\"".$mH."\" value=\"".$H."\"></td>
<Th >PRICE".$j." </th colspan=2><td> <input type=\"text\" size=\"8 \" name=\"".$p."\" id=\"".$p."\" value=\"".$data1['price']."\"></td>
     </tr>");
}

 



	?>
	
