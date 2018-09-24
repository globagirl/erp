<?php 
session_start();
?>
<html>
<head>
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<title>
Consult BL items
</title>
</head>
<body>

<?php

include('../connexion/connexionDB.php');
if(isset($_POST['BL'])){
$BL=$_POST['BL'];
$_SESSION['BL']=$BL;	
}
else{
	$BL=$_SESSION['BL'];
	$sql1 = mysql_query("SELECT * FROM bon_livr where num_bl='$BL'");
	$data1=mysql_fetch_array($sql1);
    
echo(" <TABLE ><TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=6 >BL N°: ".$BL."</th></tr>

<tr><td> Item ID</td>
<td>PO client  </td>
<td>OF </td>
<td>Qty </td>
<td>Boxs </td>

");
$sql = mysql_query("SELECT * FROM bon_livr_items where idBL='$BL'");
 while($data=mysql_fetch_array($sql)){
	echo("<TR><td  HEIGHT=30> ".$data['IDproduit']."</td>
<td>".$data['PO']." </td>
<td>".$data['OF']." </td>
<td>".$data['qty']." </td>
<td> ".$data['box']." </td>

</tr>"); 
 }
echo("<TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=6 ></th></tr>
</table>");	
}

mysql_close();
?>
</body>
</html>