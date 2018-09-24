<?php

include('../connexion/connexionDB.php');


    $n_p_o = $_POST['n_p_o'];
    $code_cart = $_POST['code_cart'];
 

	
	
	
$sql = "INSERT INTO emb_carton (num_po, code_carton, date) 
VALUES ('$n_p_o', '$code_cart', CURRENT_TIMESTAMP())";


if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
    header('Location: ../pages/emballage_carton.php?status=fail');
}else{  
     header('Location: ../pages/emballage_carton.php?status=sent');
}  

?>