<?php
session_start();
include('../connexion/connexionDB.php');
$dateA = $_POST['dateA'];
$recherche=$_POST['recherche'];
$nbr=$_POST['nbr'];
$i=0;
while($nbr>$i){
    $i++;
    $P="P".$i;
    $M="M".$i;
    $v1=$_POST[$P];
    $montant=$_POST[$M];
    if($recherche != "matricule"){
        $sql2=mysql_query("select matricule from personnel_info where $recherche='$v1'");
        $mat=mysql_result($sql2,0);
    }else{
        $mat=$v1;
    }
    $sql3=mysql_query("select etat from personnel_info where matricule='$mat'");
    $etat=mysql_result($sql3);
    if($etat=="actif")
    {
        $sql = mysql_query("INSERT INTO personnel_avance(matricule, dateA,montant)VALUES ('$mat','$dateA','$montant')");
    }
//    else{
//        echo"<script> alert('NOT ACTIF!'); </script>";
//        header('Location: ../pages/ajout_avance.php?status=Fail');
//    }
}
///////////FIN///////
header('Location: ../pages/ajout_avance.php?status=sent');

?>