 <?php
include('../connexion/connexionDB.php');
$mat=@$_POST['mat'];
$matNV=@$_POST['matNV'];
$sql="Update personnel_info set etat='actif' , matricule='$matNV' where matricule='$mat'";
if( !mysql_query($sql) ){
die(mysql_error());
}else{
$sql2=mysql_query("Insert into personnel_datee(matricule , dateH,statut) values ('$matNV',NOW(),'E')");
echo "Nooon";
}
?>