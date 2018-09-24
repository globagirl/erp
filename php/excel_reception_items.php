 <?php
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=reception_items.xls");
include('../connexion/connexionDB.php');

 $valeur=$_POST['search'];






  echo'<table  id="myTable" class="tablesorter" cellspacing="0" cellpadding="0"><thead><tr><td>Reeption ID</td><td>Ordre ID</td><td>Item</td>
<td>Date reception</td><td>Qty</td><td> BOX</td>
  
  </tr>';
  
 
    $req= mysql_query("SELECT * FROM reception  order by dateR DESC");

   while($a=@mysql_fetch_object($req))
    {

    $IDreception =$a->IDreception;    
	$dateR=$a->dateR;
	
	
	
	$req1= mysql_query("SELECT * FROM reception_items where IDreception='$IDreception'");
	while($data=@mysql_fetch_array($req1)){
	$IDorder=$data['IDorder'];
	$item=$data['item'];
	$qte=$data['qty'];
	$box=$data['box'];
	$val=$IDorder.$IDreception.$dateR.$qte.$item.$box;
	$pos =strpos($val,$valeur);
	//echo $val.'<br>';
	if($pos !== false){
	echo('<tr>
	<td >'.$IDreception.'</td>
	<td >'.$IDorder.'</td>
	<td>'.$item.'</td>
	<td>'.$dateR.'</td>
	<td>'.$data['qty'].'</td>
	<td>'.$data['box'].'</td>
    </tr>
	');
	}
	}
	
	}	
  
  echo '</thead></table>';

//echo($val);

  ?>