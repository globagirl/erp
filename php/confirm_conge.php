<?php
include('../connexion/connexionDB.php');
$IDC=$_POST['IDC'];
$sql=mysql_query("select * from personnel_demande_conge where ID='$IDC'");
$a=mysql_fetch_object($sql);
$mat=$a->matricule;
$nbrH=$a->nbrH;
$typeC=$a->typeC;
$DD=$a->dateD;
$DF=$a->dateF;
$jourJ=strtotime($DF);
$year = strftime("%Y",$jourJ);
$DM=$a->demandeur;
$idC=$mat."/".$DD;

$sql2=mysql_query("UPDATE personnel_demande_conge SET etat='C' where ID='$IDC'");
$sql3=mysql_query("INSERT INTO personnel_conge(idPC,matricule, nbrH, typeC, dateD, dateF, IDdemande) VALUES ('$idC','$mat','$nbrH','$typeC','$DD','$DF','$IDC')");

$req=mysql_query("select conge_acc from personnel_conge_annuel where matricule='$mat' and yearC='$year'");
$cong_acc=mysql_result($req,0);
$tot=$cong_acc+$nbrH;
if($tot > 168){
    echo '0';
}else{
    $sql4="update personnel_conge_annuel SET conge_acc=conge_acc+'$nbrH', conge_res=conge_res-'$nbrH' where matricule='$mat' and yearC='$year'";
    if (!mysql_query($sql4)){
        $x=168-$nbrH;
        $sql6=mysql_query("INSERT INTO personnel_conge_annuel(yearC, matricule, conge_acc, conge_res) VALUES ('$year','$mat','$nbrH','$x')");
    }
    $message="Votre demande de congé a été <b>confirmé </b>";
    $sql5=mysql_query("INSERT INTO notification(emetteur, destinataire, message, statut, dateN) VALUES ('GRH','$DM','$message','N',NOW())");
	echo '1';
    
}
mysql_close();
?>
