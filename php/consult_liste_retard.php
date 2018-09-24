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
Liste des retards
</title>
</head>
<body>
<?php
include('../connexion/connexionDB.php');
if(isset($_POST['mat'])){
$mat=$_POST['mat'];
$_SESSION['mat']=$mat;	
$mois=$_POST['mois'];
$_SESSION['mois']=$mois;	
}
else{
	$mois=$_SESSION['mois'];
	$mat=$_SESSION['mat'];
	$sql1 = mysql_query("SELECT * FROM personnel_pointage where matricule='$mat' and dateP LIKE '$mois%' and etat='R'");


echo(" <TABLE ><TR>	<Th  colspan=3 >Matricule: ".$mat."</th></tr>

<tr><td> Date</td>
<td>Heure Debut   </td>
<td>Heure Fin </td>

");

 while($data=mysql_fetch_array($sql1)){
	echo("<TR><td  HEIGHT=30> ".$data['dateP']."</td>
<td>".$data['heureD']." </td>
<td>".$data['heureF']." </td>

</tr>"); 
 }
echo("<TR>	<Th Wcode_articleTH=150 HEIGHT=30 colspan=3 ></th></tr>
</table>");	
}


?>
</body>
</html>