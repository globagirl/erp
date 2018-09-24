<?php 
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$IDproduit=$_POST['code_produit']; //definir le produit
$produit=$_POST['produit']; //definir le produit
$desc=$_POST['desc']; //definir la description
$cat=$_POST['cat']; //definir la categorie
$rev=$_POST['rev']; //definir revision
$prix=$_POST['prix'];//definir le prix
$devise=$_POST['devise']; //definir la devise
$tlot=$_POST['tlot']; //definir la taille du lot
$nbrB=$_POST['nbrB']; //definir nbr box
$long=$_POST['long']; //definir la longeur
$nbr=$_POST['nbrA'];
$poids=$_POST['poids'];
$Drev=$_POST['Drev'];
$poids=$poids*$long;
$poids=round($poids,2);
$sql= "INSERT INTO produit1(code_produit,produit,longueur,poids,description,categorie,devise,taille_lot,nbr_box,revision,draw_rev,prix) 
VALUES ('$IDproduit','$produit','$long','$poids','$desc','$cat','$devise','$tlot','$nbrB','$rev','$Drev','$prix')";
	 if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
   echo("../pages/dupliquer_produit.php");
}else{ 
$i=0;
while($nbr>$i){
	$i++;
	$artN="ar".$i;
	$qteN="qte".$i;
    $art=$_POST[$artN];//definir l'article		
    $qte=$_POST[$qteN]; //definir la qte
    $sql1=mysql_query("INSERT INTO produit_article1(IDproduit,IDarticle,qte) VALUES ('$IDproduit','$art','$qte')");
	
}
if(isset($_POST['check'])){
	$_SESSION['PRD']=$code_produit;
	header('Location: ../pages/ajout_prix_produit.php?status=sent');
}
else{
	$sql = mysql_query("INSERT INTO prices(IDproduit, marginL, marginH, price) VALUES ('$IDproduit','1','-1','$prix')");
	
	   
	header('Location: ../pages/dupliquer_produit.php?status=sent');
}
 
}  


?>