<?php
    include('../connexion/connexionDB.php');
    $dateE= $_POST['dateE'];   
    $client= $_POST['client'];
   
    $newDateE=date("Ymd", strtotime($dateE));
    $sql=@mysql_query("SELECT IDpalette,dateE FROM palette where IDpalette LIKE '$newDateE%'");	
	$nb=@mysql_num_rows($sql);
	$nb++;
	$x=0;
	$a=rand(65,90);
	$a=chr($a);
	$b=rand(65,90);
	$b=chr($b);
	$c=rand(65,90);
	$c=chr($c);
	$IDpalette=$newDateE.$a.$b.$c.$nb;
	$sql2=mysql_query("INSERT INTO palette(IDpalette, totalQte, nbrCarton, poids, dateE,dateC, Client, typeP, statut) VALUES ('$IDpalette','$x','$x','$x','$dateE',NOW(),'$client','3S','In progres')");
	//echo $newDateE;
    mysql_close();
?>