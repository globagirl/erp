<?php
session_start();
include('../connexion/connexionDB.php');
$inv=@$_POST['inv'];
//fichier
$fichier = $_FILES['imgfact'];
for($i=0; $i<count($fichier['name']); $i++) {

    $F=$fichier['name'][$i];
    //verifier existance
    $sqlF=mysql_query("SELECT * from invoice_files where nameF like '%$F'");
    $max1=mysql_num_rows($sqlF);
    $max1++;
    $fichierName=$max1.'-'.$F;
    //
    $fichier1=$fichier['tmp_name'][$i];
    $taille=filesize($fichier['tmp_name'][$i]);
    $typeF=$fichier['type'][$i];
    rename($F,$fichierName);
    $destination='../files/invoices/'.$fichierName;
    if(move_uploaded_file($fichier1,$destination)){
        $sql1=mysql_query("INSERT INTO invoice_files(nameF, typeF, sizeF, upDateF, dataF,IDinvoice) VALUES ('$fichierName','$typeF','$taille',NOW(),'$destination','$inv')");
    }else{
        echo("PLZ Contact the System Manager  !!");
    }
}
mysql_close();
//fin fichier
header('Location: ../pages/consult_invoice2.php');
//echo $inv;
?>