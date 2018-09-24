<?php
    include('../connexion/connexionDB.php');
    $recherche = $_POST['recherche'];
    $valeur = $_POST['valeur'];
	$client= $_POST['client'];
    $dateE = $_POST['dateE'];
	$sql=@mysql_query("SELECT DISTINCT IDpalette FROM carton_palette where $recherche LIKE '%$valeur%' and IDpalette IN(SELECT IDpalette FROM palette where dateE='$dateE' and client='$client') ");
	$NBP=@mysql_num_rows($sql);
	echo "<option value=\"XX\" onClick=afficheCarton();>Total : ".$NBP."</option>"; 
	while($data=mysql_fetch_array($sql)){
	$IDpalette=$data['IDpalette'];
	$sql1=@mysql_query("SELECT IDpalette,statut,nbrCarton FROM palette where dateE='$dateE' and client='$client' and IDpalette='$IDpalette' order by dateC DESC");
	$data1=@mysql_fetch_array($sql1);
	//while($data1=@mysql_fetch_array($sql1)){
	   //$IDpalette=$data1["IDpalette"];
	echo "<option value=\"".$IDpalette."\" onClick=afficheCarton();>
	   ".$IDpalette."&nbsp&nbsp&nbsp&nbsp&nbsp".$data1["nbrCarton"]."Cart&nbsp&nbsp&nbsp&nbsp&nbsp"."&nbsp&nbsp&nbsp&nbsp&nbsp".$data1["statut"]."</option>"; 
    //}	
			  
    }
    mysql_close();
?>