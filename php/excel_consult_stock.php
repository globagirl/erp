<meta charset="utf-8" />
 <?php
 
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=stock.xls");
include('../connexion/connexionDB.php');
include('../include/functions/consult_stock_functions.php');
$valeur=$_POST['valeur'];
$recherche=$_POST['recherche'];
$statut=$_POST['statut'];
$dateA=@$_POST['dateA'];
$dateJ=date('Y-m-d');
//
echo '<table  class="table table-fixed table-bordered results" id="table3">
												    <thead style="width:100%">       
			                                        <tr>
													<th style="width:14.8%;height:60px" class="degraD">Article</th>
													<th style="width:14.8%;height:60px" class="degraD">Description</th>
             <th style="width:14.8%;height:60px" class="degraD">Supplier </th>	
													<th style="width:14.8%;height:60px" class="degraD">Stock '.$dateJ.'</th>
             <th style="width:14.8%;height:60px" class="degraD">Stock value</th>
													<th style="width:14.8%;height:60px" class="degraD">Stock '.$dateA.'</th>
										   <th style="width:14.8%;height:60px" class="degraD">Stock value </th>	
												</tr>
												</thead>
													<tbody id="tbody2" style="width:100%">';
//echo $statut;

if($statut=="ALL"){
  if($recherche=="a"){
    $req= "SELECT * FROM article1";
 }else{
   $req= "SELECT * FROM article1 where $recherche LIKE '$valeur'";
 }
}else if($statut=="N"){
    if($recherche=="a"){
      $req= "SELECT * FROM article1 where stock=0";
   }else {
      $req= "SELECT * FROM article1 where $recherche like '$valeur' and stock=0";
   }
}else if($statut=="NN"){
    if($recherche=="a"){
       $req= "SELECT * FROM article1 where stock >0";
   }else{
       $req= "SELECT * FROM article1 where $recherche like '$valeur' and stock>0";
   }
}
  $r=mysql_query($req) or die(mysql_error());
  while($a=mysql_fetch_array($r)){
	      affiche_ligne_excel($a,$dateA);
    }
echo '</tbody></table>';
mysql_close();
  ?>