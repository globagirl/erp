<?php
session_start();
include('../connexion/connexionDB.php');
$desc = $_POST['desc'];
$dateD = $_POST['dateD'];
$dateF = $_POST['dateF'];
$typePH = $_POST['typePH'];
$sqlX=mysql_query("INSERT INTO public_holiday(description,dateD,dateF,typePH)VALUES ('$desc','$dateD','$dateF','$typePH')");
if($typePH=="CP"){
    $sql=mysql_query("select matricule,nom from personnel_info where etat='actif'");
    while($data=mysql_fetch_object($sql)){
        $matricule=$data->matricule;
        $sql1=mysql_query("INSERT INTO personnel_conge(matricule,nbrH,typeC,dateD,dateF)VALUES ('$matricule','8','Ferié non payé','$dateD','$dateF')");
        $sql2=mysql_query("update personnel_info SET conge_acc=conge_acc+'8', conge_res=conge_res-'8' where matricule='$matricule'");
    }
}
header('Location: ../pages/public_holidays.php');
?>