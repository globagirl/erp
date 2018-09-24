<?php 
include('../connexion/connexionDB.php');
    $reception=$_POST['reception'];
	$j=$_POST['i'];
	
	$article=$_POST['ar'];
	$qty=$_POST['qtr'];
	$paquet=$_POST['paq'];
	$suite=$_POST['suit'];
	
	
	if($paquet==1){
	$i=1;
	$DD="DD".$j;
    $codeP="codeP".$j.$i;
	$batchP="batchP".$j.$i;
    $idpaq=$article."/".$reception."/".$j."-1"; 
    echo "<div id=\"".$DD."\" style=\"background-color:#FBEFFB ; text-align:center\"><hr> <input type=\"text\" size=\"30 \" name=\"".$codeP."\" id=\"".$codeP."\" value=\"".$idpaq."\"/  READONLY> 
	<input  type=\"text\" size=\"15 \" name=\"".$batchP."\" id=\"".$batchP."\" placeholder=\"Batch N°\"><hr></div>";
}
else if($suite==0){
$qtpd=$qty/$paquet;
$DD="DD".$j;
 echo "<div id=\"".$DD."\" style=\"background-color:#FBEFFB ; text-align:center\"><hr>";
for ($i=1;$i<$paquet+1;$i++)
{
    $idpaq=$article."/".$reception."/".$j."-".$i; 
    $codeP="codeP".$j.$i;
	$batchP="batchP".$j.$i;
   
    echo " <input type=\"text\" size=\"30 \" name=\"".$codeP."\" id=\"".$codeP."\" value=\"".$idpaq."\"/  READONLY> 
	<input  type=\"text\" size=\"15 \" name=\"".$batchP."\" id=\"".$batchP."\" placeholder=\"Batch N°\"><br><br>";
}
echo "<hr></div>";
}
else{
$qtpd=($qty-$suite)/($paquet-1);
$DD="DD".$j;
 echo "<div id=\"".$DD."\" style=\"background-color:#FBEFFB ; text-align:center\"><hr>";
for ($i=1;$i<$paquet;$i++){
 $idpaq=$article."/".$reception."/".$j."-".$i;
 $codeP="codeP".$j.$i;
	$batchP="batchP".$j.$i; 
  echo "<input type=\"text\" size=\"30 \" name=\"".$codeP."\" id=\"".$codeP."\" value=\"".$idpaq."\"/  READONLY> 
	 <input  type=\"text\" size=\"15 \" name=\"".$batchP."\" id=\"".$batchP."\" placeholder=\"Batch N°\"><br><br>";	
}
    //$i++;
    $idpaq=$article."/".$reception."/".$j."-".$i; 
    $codeP="codeP".$j.$i;
	$batchP="batchP".$j.$i;
  echo " <input type=\"text\" size=\"30 \" name=\"".$codeP."\" id=\"".$codeP."\" value=\"".$idpaq."\"/  READONLY> 
	<input  type=\"text\" size=\"15 \" name=\"".$batchP."\" id=\"".$batchP."\" placeholder=\"Batch N°\"><hr></div>";	
}

mysql_close();
?>
	
