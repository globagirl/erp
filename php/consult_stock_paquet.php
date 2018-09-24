<?php
include('../connexion/connexionDB.php');
$article=$_POST['article'];
echo('<div class="table-responsive" id="divRel">
											    <table  class="table table-fixed results" id="table1">
															<thead>
															<tr>
															<th colspan=3 style="width:100%;height:40px;text-align:center" >Article: '.$article.'</th>
															</tr>
															</thead><tbody>');

$sql = mysql_query("SELECT IDpaquet,qte_res,batch FROM paquet2 where IDarticle='$article' and qte_res>0 ");
 while($data=mysql_fetch_array($sql)){
	echo("<tr><td style=\"width:40%;height:40px;text-align:center\"> ".$data['IDpaquet']."</td>
<td style=\"width:30%;height:40px;text-align:center\">".$data['qte_res']."</td>
<td style=\"width:30%;height:40px;text-align:center\">".$data['batch']." </td>

</tr>"); 
 }
echo("</tbody></table>");	

mysql_close();

?>
