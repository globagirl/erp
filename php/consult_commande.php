 <?php
include('../connexion/connexionDB.php');
include('../include/functions/consult_commande_functions.php');
 $valeur=$_POST['valeur'];
 $recherche=$_POST['recherche'];
 $dateE1=@$_POST['dateE1'];
 $dateE2=@$_POST['dateE2'];
 if($dateE1 == ""){ 
    if ($recherche != "client") {
       $req= "SELECT * FROM commande_items where $recherche LIKE '$valeur' order by dateExp desc";
    }else{
       $req= "SELECT * FROM commande_items where PO IN (SELECT PO from commande2 where $recherche LIKE '$valeur') order by dateExp desc";
    }
  
 }else{
    if($dateE2 == ""){     
     $dateE2=$dateE1;
    }
    if ($recherche != "client") {
       $req= "SELECT * FROM commande_items where $recherche LIKE '$valeur' and dateExp >= '$dateE1' and dateExp <= '$dateE2' order by dateExp desc";
    }else{
       $req= "SELECT * FROM commande_items where (PO IN (SELECT PO from commande2 where $recherche LIKE '$valeur')) and (dateExp >= '$dateE1') and (dateExp <= '$dateE2') order by dateExp desc";
    }
 } 

  $r1=mysql_query($req) or die(mysql_error());
  while($data=mysql_fetch_array($r1)){
      affiche_ligne($data);
     
	
    }

 
    mysql_close();

  ?>