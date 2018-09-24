<?php
session_start();
include('../connexion/connexionDB.php');
    $code_produit = $_POST['code_produit'];
    $produit = $_POST['produit'];
    $desc= $_POST['desc'];
    $long= @$_POST['long'];
    $poids= @$_POST['poids'];
    $cat = $_POST['cat'];
    $prix =@$_POST['prixU'];
    $nbr=@$_POST['nbr'];
    $dev = $_POST['devise'];
    $rev = $_POST['rev'];
    $Drev = $_POST['Drev'];
    $tlots=@$_POST['tlots'];
    $nbr_box =@$_POST['nbr_box'];
    $poids=$poids*$long;
    $poids=round($poids,2);
    $sql = "INSERT INTO produit1(code_produit,produit,longueur,poids,description,revision,draw_rev,categorie,devise,taille_lot,nbr_box,prix)VALUES ('$code_produit','$produit','$long','$poids','$desc','$rev','$Drev','$cat','$dev','$tlots','$nbr_box','$prix')";
    if (!mysql_query($sql)) {
      die('Error: ' . mysql_error());
    }else{
      $i=0;
      while($nbr>$i){
         $i++;
         $ar1="C".$i;
         $q1="Q".$i;
         $ar=@$_POST[$ar1];
         $q=@$_POST[$q1];
         $sql1 = mysql_query("INSERT INTO produit_article1(IDproduit,IDarticle,qte) VALUES ('$code_produit','$ar','$q')");
         
      }
      /*if(isset($_POST['check'])){
	      $_SESSION['PRD']=$code_produit;
	      header('Location: ../pages/ajout_prix_produit.php?status=sent');
      } else{*/
	   $sql = mysql_query("INSERT INTO prices(IDproduit, marginL, marginH, price) VALUES ('$code_produit','1','-1','$prix')");
	   header('Location: ../pages/ajout_produit.php?status=sent');	 
    }  

?>