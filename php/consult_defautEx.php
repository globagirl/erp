<?php
  include('../connexion/connexionDB.php');
  $dateE =$_POST["dateE"];
  $req = mysql_query ("SELECT * FROM ordre_fabrication1 WHERE date_exped_conf='$dateE'");
  echo '<br><br>
  <div class="table-responsive col-lg-12" id="divRel">
  <table class="table table-fixed results" >
  <thead style="width:100%"> 
	<tr>
    <th style="width:19.8%;height:60px;text-align:center">OF</th>
	<th style="width:24.8%;height:60px;text-align:center">PO</th>
	<th style="width:19.8%;height:60px;text-align:center">QTY</th>			  
	<th style="width:19.8%;height:60px;text-align:center">Total defaut</th>
	<th style="width:14.8%;height:60px;text-align:center">Statut</th>
	</tr>
  </thead>
  <tbody id="tbody2" style="width:100%">';
  while($row=@mysql_fetch_array($req)){
  $OF=$row['OF'];
  $req2 = mysql_query ("SELECT sum(nbr_defaut) FROM plan1 WHERE OF='$OF'");
  $nbr=@mysql_result($req2,0);
  echo('<tr>
    <td style="width:20%;height:40px;text-align:center" >'.$OF.'</td>
	<td  style="width:25%;height:40px;text-align:center">'.$row['PO'].'</td>
	<td  style="width:20%;height:40px;text-align:center">'.$row['qte'].'</td>
	<td style="width:20%;height:40px;text-align:center">'.$nbr.'</td>
	<td style="width:15%;height:40px;text-align:center">'.$row['statut'].'</td>
	</tr>');
  
	}
 
	echo('</tbody></table>');
  
  ?>