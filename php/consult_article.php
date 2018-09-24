 <?php
include('../connexion/connexionDB.php');

$valeur=$_POST['valeur'];

$pos1="|";
$n=strpos($valeur,$pos1);
$recherche=substr($valeur,0,$n); //definir recherche par ? 
$l=strlen($valeur);
$valeur=substr($valeur,$n+1,$l); //mettre a jour la chaine

$val=$valeur; //definir valeur






if($recherche=="a"){
$req= "SELECT * FROM article1";
}
 else if($recherche=="article"){
$req= "SELECT * FROM article1 where code_article='$val'";
}
else if($recherche=="typeA"){
$req= "SELECT * FROM article1 where  typeA='$val'";
}




  $r=mysql_query($req) or die(mysql_error());

  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>Article</td><td>Type</td><td>Description</td>
  <td>Unité</td>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
	
	
	
    $article =$a->code_article;
    $typeA =$a->typeA;
	$desc=$a->description;
	
	$unit=$a->unit;
	
	
	
    echo"<tr><td>$article</td><td>$typeA</td><td>$desc</td><td>$unit</td>
	</tr>";
    }
  echo '</thead></table>';
  mysql_close();

  ?>