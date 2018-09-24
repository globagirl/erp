<?php
    include('../connexion/connexionDB.php');
    $dateE = $_POST['dateE'];
    $client = $_POST['client'];
	$sql1=@mysql_query("SELECT IDpalette,statut,nbrCarton FROM palette where dateE='$dateE' and client='$client' order by dateC DESC");
    $NBP=@mysql_num_rows($sql1);
	echo "<option value=\"XX\" onClick=afficheCarton();>Total : ".$NBP."</option>"; 
	while($data1=@mysql_fetch_array($sql1)){
	   $IDpalette=$data1["IDpalette"];
	   echo "<option value=\"".$data1["IDpalette"]."\" onClick=afficheCarton();>
	   ".$data1["IDpalette"]."&nbsp&nbsp&nbsp&nbsp&nbsp".$data1["nbrCarton"]."Cart&nbsp&nbsp&nbsp&nbsp&nbsp"."&nbsp&nbsp&nbsp&nbsp&nbsp".$data1["statut"]."</option>"; 
    }
    mysql_close();
?>