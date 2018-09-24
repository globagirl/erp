<?php
include('../connexion/connexionDB.php');
$nbr=0;
$nbr1=0;
$nbr2=0;
$D=$_POST['D'];
$sq1=mysql_query("select * FROM personnel_info WHERE matricule='$D'");
$nbr1=mysql_num_rows($sq1);
$sq2=mysql_query("select * FROM personnel_doubleP WHERE newMat='$D'");
$nbr2=mysql_num_rows($sq2);
$nbr=$nbr1+$nbr2;
if($nbr>0){
echo 1;
}else{
echo 0;
}
mysql_close();
?>