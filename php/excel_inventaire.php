 <meta charset="utf-8" />
 <?php
  // The function header by sending raw excel
header("Content-type: application/vnd-ms-excel");
 
// Defines the name of the export file "codelution-export.xls"
header("Content-Disposition: attachment; filename=inventaire.xls");
include('../connexion/connexionDB.php');
$IDinventaire= $_POST['IDinventaire'];
echo '<table class="table table-fixed  results" id="table3">
<thead style="width:100%">
          
			<tr>
               
				<th style="width:24.7%">Code article</th>
				<th style="width:24.5%">Stock réel</th>			  
				<th style="width:24.5%">Stock systéme</th>					  
				<th style="width:24.7%">date entrée</th>			  
						  
		
						  
            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%">';
  $x=0;
	$sql = mysql_query("SELECT * FROM inventaire_items where IDinventaire='$IDinventaire'");
	while($data=@mysql_fetch_array($sql)){
	$x++;   	
	echo('<tr id='.$x.'>
	<td style="width:25%">'.$data['IDarticle'].'</td>
	<td  style="width:25%">'.$data['stockReel'].'</td>
	<td  style="width:25%">'.$data['stockSys'].'</td>
	<td  style="width:25%">'.$data['dateE'].'</td></tr>

	');
	
	
	}
	mysql_close();
?>