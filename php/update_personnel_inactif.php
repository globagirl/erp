 <?php
include('../connexion/connexionDB.php');
$mat=$_POST['mat'];
$sql1=mysql_query("SELECT typeS FROM personnel_info  where matricule='$mat'");
$typeS=mysql_result($sql1,0);
if($typeS=="V"){
$sql2=mysql_query("SELECT * FROM personnel_info  where matricule='$mat%' and etat='inactif'");
$nbr=mysql_num_rows($sql2);
$nbr++;
$matNV=$mat.'-S'.$nbr;
}else{
$matNV=$mat;
}
//$sql3=mysql_query("UPDATE personnel_info SET matricule='$matNV' where matricule='$mat'");
$sql=mysql_query("UPDATE personnel_info SET etat='inactif',matricule='$matNV' where matricule='$mat'");
if(!$sql){
die(mysql_error());
}else{
$sql21=mysql_query("INSERT into personnel_datee(matricule ,dateH,statut) values ('$matNV',NOW(),'S')");
$sql22=mysql_query("UPDATE personnel_contrat SET etat='rompu' where matricule='$matNV' and etat='en cours'");
echo $matNV ;
}
?>