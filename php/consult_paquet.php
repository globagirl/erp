<?php
include('../connexion/connexionDB.php');
$paq=$_POST['paq'];
echo(" <TABLE >

<tr><td> Code paquet</td>
<td> Code article</td>
<td>Batch  </td>
<td>Stock </td></tr>");

	$sql = mysql_query("SELECT * FROM paquet2 where IDpaquet LIKE '%$paq%' ");
	while($data=mysql_fetch_array($sql)){
	  $art=$data['IDarticle'];
	 $sql1 = mysql_query("SELECT * FROM article1 where code_article LIKE '%$art%'");
	$data1=mysql_fetch_array($sql1);
	
	echo("<TR>
	<td  HEIGHT=30> ".$data['IDpaquet']."</td><td>".$data['IDarticle']." </td>
<td>".$data['batch']." </td>
<td style=\"background-color:pink\">".$data['qte_res']." ".$data1['unit']."</td>
</tr>"); 
 }
echo("</table>");


?>