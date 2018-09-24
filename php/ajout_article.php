<?php
include('../connexion/connexionDB.php');
    $code_article = $_POST['code_article'];
    $desc = $_POST['desc'];
	$stock = 0;
	$unit = $_POST['unit'];
	$four = $_POST['four'];
	$prix = $_POST['prix'];	
	if(isset($_POST['typeA'])){
	$typeA =$_POST['typeA'];
	}else{
	$typeA = "Consumable";
	}
    $catA = @$_POST['catA'];	
	$devise = $_POST['dev'];	
$sql = "INSERT INTO article1 (code_article,typeA, description,supplier, stock, stock_min,prix,devise,unit,catA)
VALUES ('$code_article','$typeA', '$desc','$four', 0, 0,'$prix','$devise','$unit','$catA')";
if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/ajout_article.php?status=fail');
}else{  
     header('Location: ../pages/ajout_article.php?status=sent');
}
?>