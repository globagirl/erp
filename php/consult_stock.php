 <?php
include('../connexion/connexionDB.php');
include('../include/functions/consult_stock_functions.php');
$valeur=$_POST['valeur'];
$recherche=$_POST['recherche'];
$statut=$_POST['statut'];
$dateA=@$_POST['dateA'];
//echo $statut;

if($statut=="ALL"){
  if($recherche=="a"){
    $req= "SELECT code_article,description,stock,supplier,unit,catA FROM article1";
 }else{
   $req= "SELECT code_article,description,stock,supplier,unit,catA FROM article1 where $recherche LIKE '$valeur'";
 }
}else if($statut=="N"){
    if($recherche=="a"){
      $req= "SELECT code_article,description,stock,supplier,unit,catA FROM article1 where stock=0";
   }else {
      $req= "SELECT code_article,description,stock,supplier,unit,catA FROM article1 where $recherche like '$valeur' and stock=0";
   }
}else if($statut=="NN"){
    if($recherche=="a"){
       $req= "SELECT code_article,description,stock,supplier,unit,catA FROM article1 where stock >0";
   }else{
       $req= "SELECT code_article,description,stock,supplier,unit,catA FROM article1 where $recherche like '$valeur' and stock>0";
   }
}
  $r=mysql_query($req) or die(mysql_error());
  while($a=mysql_fetch_array($r)){
	      affiche_ligne($a,$dateA);
    }
mysql_close();
  ?>