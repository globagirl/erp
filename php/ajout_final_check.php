<?php
/**
 * Created by PhpStorm.
 * User: Khawla
 * Date: 26/09/2018
 * Time: 14:31
 */
session_start();
$IDoperateur=$_SESSION['userID'];
require'../connexion/connexionDB.php';
$PO=@$_POST['PO'];
$date=@$_POST['date'];
$fichier = $_FILES['imgFact'];
if(isset($_POST['add'])) {
    for ($i = 0; $i < count($fichier['nameF']); $i++) {
        $F = $fichier['name'][$i];
        //verifier existance
        $req = $con->prepare("SELECT * from file_final_check where nameF like '%$F'");
        $req->execute();
        $max1 = $req->rowCount();
        $max1++;
        $fichierName = $max1 . '-' . $F;
        //
        $fichier1 = $fichier['tmp_name'][$i];
        $taille = filesize($fichier['tmp_name'][$i]);
        $typeF = $fichier['type'][$i];
        rename($F, $fichierName);
        $destination = '../files/finalCheck/' . $fichierName;
        if (move_uploaded_file($fichier1, $destination)) {
            $request = "INSERT INTO file_final_check (nameF, typeF, sizeF,DateS, dataF,PO) VALUES ('$fichierName','$typeF','$taille',$date,'$destination','$PO')";
            $stmt = $con->prepare($request);
            $test = $stmt->execute();
            if ($test) {
                header('Location: ../pages/add_final_check.php?status=sent');
            }
        } else {
            header('Location: ../pages/add_final_check.php?status=fail');
        }
    }
}
?>