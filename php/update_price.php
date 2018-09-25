<?php
session_start();
include('../connexion/connexionDB.php');
$item=@$_POST['item'];
$cl_four=@$_POST['cl_four'];
$valeur=@$_POST['valeur'];
$price=@$_POST['price'];
$note=@$_POST['note'];
$userID=$_SESSION['userID'];
$nom=$_SESSION['userName'];
if($cl_four=="client"){
    $sq=mysql_query("select price from prices where IDproduit='$item' and marginL='1' and marginH='-1'");
    if (mysql_num_rows($sq)>0){
        $priceA=mysql_result($sq,0);
        if($priceA==$price){
            $etat='N';
        }else{
            $etat='Y';
        }
        $x=rand(1,999);
        $y=rand(8,989);
        $idH='cl'.$y.$x;
        $sql1=mysql_query("UPDATE  prices SET price='$price' where IDproduit='$item' and marginL='1' and marginH='-1'");
        $sql2=mysql_query("INSERT INTO historique_prices(idH,cl_four,item,ancien_prix,nouveau_prix, dateM, operateur,typeH)
						VALUES ('$idH','$valeur','$item','$priceA','$price',NOW(),'$userID','$cl_four')");
        $sql3=mysql_query("INSERT INTO update_prices_product(ID, client, item, ancien_prix, nouveau_prix, dateM, operateur, description,etat) VALUES
('$idH','$valeur','$item','$priceA','$price',NOW(),'$userID','$note','$etat')");
        header('Location: ../pages/update_price.php');
    }else{
        echo "Contaclez l'administrateur systéme SVP !! ";
    }
}else{
    $sq=mysql_query("select prix from article1 where code_article='$item'");
    if (mysql_num_rows($sq)>0){
        $priceA=mysql_result($sq,0);
        if($priceA==$price){
            $etat='N';
        }else{
            $etat='Y';
        }
        $x=rand(1,999);
        $y=rand(8,999);
        $idH='four'.$x.$y;
        $sql1=mysql_query("UPDATE  article1 SET prix='$price' where code_article='$item'");
        $sql2=mysql_query("INSERT INTO historique_prices(idH,cl_four,item,ancien_prix,nouveau_prix, dateM, operateur,typeH)
						VALUES ('$idH','$valeur','$item','$priceA','$price',NOW(),'$userID','$cl_four')");
        $sql3=mysql_query("INSERT INTO update_prices_item(ID, four, item, ancien_prix, nouveau_prix, dateM, operateur, description,etat) VALUES
('$idH','$valeur','$item','$priceA','$price',NOW(),'$userID','$note','$etat')");
        header('Location: ../pages/update_price.php');
    }else{
        echo "Contaclez l'administrateur systéme SVP !! ";
    }
}
?>
