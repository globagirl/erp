<?php
/**
 * Created by PhpStorm.
 * User: Khawla
 * Date: 26/09/2018
 * Time: 14:31
 */
session_start();
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$PO=@$_POST['PO'];
$date=@$_POST['date'];

$fichier = $_FILES['imgFact'];
if(isset($_POST['add'])) {
        $F = $fichier['name'][$i];
        //verifier existance
        $sqlF = mysql_query("SELECT * from invoice_files where nameF like '%$F'");
        $max1 = mysql_num_rows($sqlF);
        $max1++;
        $fichierName = $max1 . '-' . $F;
        //
        $fichier1 = $fichier['tmp_name'][$i];
        $taille = filesize($fichier['tmp_name'][$i]);
        $typeF = $fichier['type'][$i];
        rename($F, $fichierName);
        $destination = '../files/invoices/' . $fichierName;
        if (move_uploaded_file($fichier1, $destination)) {
            $sql1 = mysql_query("INSERT INTO file_final_check (nameF, typeF, sizeF,DateS, dataF,PO) VALUES ('$fichierName','$typeF','$taille',$date,'$destination','$PO')");
        } else {
            echo("PLZ contact the system manager !!");
        }
}
?>