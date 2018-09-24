 <meta charset="utf-8" />
 
 <?php
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");

// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=stock.xls");
include('../connexion/connexionDB.php');

$valeur=@$_POST['valeur'];
$recherche=@$_POST['recherche'];
$statut=@$_POST['statut'];





if($statut=="a"){
if($recherche=="a"){
$req= "SELECT * FROM article1";
}
 else{
$req= "SELECT * FROM article1 where $recherche like '$valeur'";
}

}
 else if($statut=="StockN"){
if($recherche=="a"){
$req= "SELECT * FROM article1 where stock=0";
}
 else {
$req= "SELECT * FROM article1 where $recherche like '$valeur' and stock=0";
}

}
 else if($statut=="StockNN"){
if($recherche=="a"){
$req= "SELECT * FROM article1 where stock >0";
}
 else{
$req= "SELECT * FROM article1 where $recherche like '$valeur' and stock>0";
}

 }



  $r=mysql_query($req) or die(mysql_error());

  echo'<table border="1px">
  <tr><td>Article</td><td>Type</td><td>Description</td>
  <td>Stock</td>
  </tr>';
  while($a=mysql_fetch_object($r))
    {
	
	
	
    $article =$a->code_article;
    $typeA =$a->typeA;
	$desc=$a->description;
	$stock=$a->stock;
	$unit=$a->unit;
	
	
	
    echo"<tr><td>$article</td><td>$typeA</td><td>$desc</td><td>$stock  $unit</td></tr>";
    }
  echo '</table>';

//echo($val);

  ?>