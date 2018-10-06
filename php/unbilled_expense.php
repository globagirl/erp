<?php
session_start();
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$category = $_POST['category'];
$desc= $_POST['desc'];
$dateE = $_POST['dateE'];
$amount= $_POST['amount'];
$currency = $_POST['currency'];
if(!file_exists($_FILES['expF']['tmp_name'])){
    $sql = "INSERT INTO expense(catI, description, dateE,dateP, amount, currency) VALUES ('$category','$desc',NOW(),'$dateE','$amount','$currency')";
    if (!mysql_query($sql)) {
        die('Error: ' . mysql_error());
        header('Location: ../pages/unbilled_expense.php?status=fail');
    }else{
        //historique
        $msg= " has added a new expense";
        $HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','unbilled_expense','$desc',NOW())");
        //
        header('Location: ../pages/unbilled_expense.php?status=sent');
    }
}else{
//Traitement du fichier
    $fichier = basename($_FILES['expF']['name']);
    $fichier1=$_FILES['expF']['tmp_name'];
    //verifier existance
    $sqlF=mysql_query("SELECT * from invoice_files where nameF like '%$fichier'");
    $max1=mysql_num_rows($sqlF);
    $max1++;
    $fichierName=$max1.'-'.$fichier;
    //
    $taille = filesize($_FILES['expF']['tmp_name']);
    $extensions = array('.png', '.gif', '.jpg', '.jpeg');
    $extension = strrchr($_FILES['expF']['name'], '.');
    $typeF=$_FILES['expF']['type'];
    rename($fichier,$fichierName);
    $destination='../files/expenseFiles/'.$fichierName;
    if(move_uploaded_file($fichier1,$destination)){
        $sql1=mysql_query("INSERT INTO expense_files(nameF, typeF, sizeF, upDateF, dataF) VALUES ('$fichierName','$typeF','$taille',NOW(),'$destination')");
        $sql = "INSERT INTO expense(catI, description, dateE,dateP, amount, currency, fileE) VALUES ('$category','$desc',NOW(),'$dateE','$amount','$currency','$fichierName')";
        if (!mysql_query($sql)) {
            die('Error: ' . mysql_error());
            header('Location: ../pages/unbilled_expense.php?status=fail');
        }else{
            //historique
            $msg= "  a ajouté un nouveau expense ";
            $HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','unbilled_expense','$desc',NOW())");
            //
            header('Location: ../pages/unbilled_expense.php?status=sent');
        }
    }else{
        echo("PLZ Contact the System Manager !!");
    }
}
?>