 <?php
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");

// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=articles.xls");
include('../connexion/connexionDB.php');

 $valeur=$_POST['search'];






  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><tr>

				<th style="width:17.7%;height:60px" class="degraD2">Code article</th>
				<th style="width:19.5%;height:60px" class="degraD2">Description</th>
				<th style="width:21.5%;height:60px" class="degraD2">Fournisseur</th>
				<th style="width:9.7%;height:60px" class="degraD2">Prix unitaire</th>
				<th style="width:14.9%;height:60px" class="degraD2">Stock</th>
				<th style="width:14.9%;height:60px" class="degraD2">Valeur</th>

            </tr></tr>';

 $req= mysql_query("SELECT * FROM article1");
   $nbrL=mysql_num_rows($req);
   while($data=@mysql_fetch_array($req))
    {

    $article=$data['code_article'];
    $desc=$data['description'];
    $sup=$data['supplier'];
	$prixU=$data['prix'];
	$stock=$data['stock'];
	$devise=$data['devise'];
	$unit=$data['unit'];
	$V=$prixU*$stock;

	//UPPER CASE A Ajouter
	$val=$article.$desc.$sup.$prixU.$stock.$V.$unit.$devise;
	$pos = strpos($val, $valeur);
	if($pos != false){
	echo('<tr>
	<td style="width:18%;height:60px;text-align:center ;background-color:#EFFBF2" class="tdTab">'.$data['code_article'].'</td>
	<td  style="width:20%;height:60px;text-align:center">'.$data['description'].'</td>
	<td  style="width:22%;height:60px;text-align:center">'.$data['supplier'].'</td>
	<td style="width:10%;height:60px;text-align:center;background-color:#F5ECCE">'.$data['prix'].'</td>
	<td style="width:15%;height:60px;text-align:center;background-color:#F8E6E0">'.$data['stock'].' '.$data['unit'].'</td>
	<td style="width:15%;height:60px;text-align:center;background-color:#F8E6E0">'.$V.' '.$data['devise'].'</td>

	');
	}
	}



  echo '</table>';

//echo($val);

  ?>
