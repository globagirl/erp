<?php 
include('../connexion/connexionDB.php');
$reception=$_POST['reception'];
$i=1;
$sql = "SELECT * FROM paquet2 where idRO='$reception'";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
	
	$paq="paq"+$i;
	$batch="batch"+$i;
  	echo "Code paquet <input type=\"text\" size=\"20 \" name=\"".$paq."\" value=\"".$data['IDpaquet']."\"/  READONLY> 
	Batch <input  type=\"text\" size=\"20\" name=\"".$batch."\" value=\"".$data['batch']."\">
	<hr>";
	$i=$i+1;
}
	?>
	
