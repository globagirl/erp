<?php
include('../connexion/connexionDB.php');
$sql=mysql_query("select * from personnel_info");
while($a=mysql_fetch_array($sql)){
    $mat=$a['matricule'];
	$sql1=@mysql_query("select sum(nbrH) from personnel_conge where matricule='$mat' and dateF LIKE '2017-%'");
	$nbrH=mysql_result($sql1,0);
	$res=168-$nbrH;
	$sql2=mysql_query("INSERT INTO personnel_conge_annuel(yearC, matricule, conge_acc, conge_res) VALUES ('2017','$mat','$nbrH','$res')");
	

}

?>