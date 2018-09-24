 <?php
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=commandes.xls");
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
  echo ' <table  class="table table-fixed table-bordered results" id="table3">
												    <thead style="width:100%">       
			                                        <tr>													
													<th style="width:14.8%;height:60px" class="degraD">PO</th>
													<th style="width:14.8%;height:60px" class="degraD">Product</th>
													<th style="width:9.8%;height:60px" class="degraD">QTY</th>                     
													<th style="width:11.9%;height:60px" class="degraD">Prix unitaire</th>
													<th style="width:11.9%;height:60px" class="degraD">Total</th>
													<th style="width:11.9%;height:60px" class="degraD">Date expedition</th>
													<th style="width:11.9%;height:60px" class="degraD">Client</th>
													<th style="width:9.9%;height:60px" class="degraD">Statut</th>			  
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">'
												;
  $r1=mysql_query($req) or die(mysql_error());
  while($data=mysql_fetch_array($r1)){
      affiche_ligne($data);
     
	
    }

 echo '</tbody></table>';
    mysql_close();

  ?>