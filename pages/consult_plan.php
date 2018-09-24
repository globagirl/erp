<html>
<head>
<meta charset="utf-8" />
<meta charset="utf-8" />
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />





<title>
consulter plan/chaine
</title>

<SCRIPT LANGUAGE="javascript">




</SCRIPT>



</head>

<body>



<div id="entete">

<div id="logo">


</div>

<div id="boton">



</div>


</div>


<div id="main">


<div id="contenu">

<!-- began --> 
<BR>



<p class="there">Consulter les plans de tarvail</p>
<br>

<!-- end --> 



<form method="post">
<table>
<tr>


<th>Num°of </th>
<td>
<input type="text" name="numof" id="num_po">
</td>

<td>
<input type="submit" value="afficher" target="_blank">

</td>
</tr>
</table>

  <?php
  include('../connexion/connexionDB.php');



$num_of = @$_POST["numof"];



  $req = mysql_query ("SELECT * FROM ordre_fabrication WHERE num_of= $num_of ");
 
  $req1 = mysql_query ("SELECT * FROM decoup WHERE n_o_f= $num_of ");
  
  $req2= mysql_query ("SELECT * FROM pro_assem WHERE n_o_f= $num_of ");
  
  $req3 = mysql_query ("SELECT * FROM pro_sertiss WHERE n_o_f= $num_of ");
  
  $req4 = mysql_query ("SELECT * FROM pro_test_pol WHERE n_o_f= $num_of ");
  
  $req5 = mysql_query ("SELECT * FROM pro_contr_fluke WHERE n_o_f= $num_of ");
  
  $req6 = mysql_query ("SELECT * FROM pro_emb WHERE n_o_f= $num_of ");
  
  
   
   

   echo'
   <br>
   <br>
   <table name ="a" border="1" bordercolor="red" class="tablesorter" >

   <tr>
   <td>Num° OF</td>
   <td>code_article</td>
   <td>taille de lot</td>
   <td colspan=2>nombre de lot</td>
   
   </tr>';
   
 
  while($row=@mysql_fetch_array($req))
         {
		 $num_of=$row['num_of'];  
		 $code_article=$row['code_artic'];	
	     $taille_lot=$row['taille_lot'];
	     $nbr_lot=$row['nbr_lot']; 
		 echo"	
	<tr>
	<td>$num_of</td>
	<td>$code_article</td>
	<td>$taille_lot</td>
	<td colspan=2>$nbr_lot</td>
	
	";
		 }	

	echo
	'
	
   <tr>
	
   <td colspan="5" align="center" >decoupage</td></tr>
   <tr>
   <td>Num° Plan</td>
   <td>DATE</td>
   <td>Q/E</td>
   <td>Q/S</td>
   <td>rebut</td>
   </tr>
	
	';
		 
	while($row1=@mysql_fetch_array($req1))
	{
	$num_plan=$row1['n_p_t'];  
	$date_recep=$row1['date'];	
	$qte_e=$row1['qte_e'];
	$qte_s=$row1['q_sor'];
	$nbr_def=$row1['q_reb'];
	echo"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
    <td>$qte_e</td>
	<td>$qte_s</td>
	<td>$nbr_def</td>
	</tr>
	";
	
	}	

echo
	'
	
   <tr>
	
   <td colspan="5" align="center" >Assemblage</td></tr>
   <tr>
   <td>Num° Plan</td>
   <td>DATE</td>
   <td>Q/E</td>
   <td>Q/S</td>
   <td>rebut</td>
   </tr>
	
	';
		 
	while($row2=@mysql_fetch_array($req2))
	{
	$num_plan=$row2['n_p_t'];  
	$date_recep=$row2['date'];	
	$qte_e=$row2['qte_e'];
	$qte_s=$row2['qte_s'];
	$nbr_def=$row2['nbr_def'];
	
	
	
	echo"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
    <td>$qte_e</td>
	<td>$qte_s</td>
	<td>$nbr_def</td>
	</tr>
	";
	
	
	
	
	
	}
	echo
	'
	
   <tr>
	
   <td colspan="5" align="center" >Sertissage</td></tr>
   <tr>
   <td>Num° Plan</td>
   <td>DATE</td>
   <td>Q/E</td>
   <td>Q/S</td>
   <td>rebut</td>
   </tr>
	
	';
		 
	while($row3=@mysql_fetch_array($req3))
	{
	$num_plan=$row3['n_p_t'];  
	$date_recep=$row3['date_recep'];	
	$qte_e=$row3['qte_e'];
	$qte_s=$row3['qte_s'];
	$nbr_def=$row3['nbr_def'];
	
	
	
	echo
	
	"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
    <td>$qte_e</td>
	<td>$qte_s</td>
	<td>$nbr_def</td>
	</tr>
	";
	
	
	
	
	
	}
	echo
	'
	
   <tr>
	
   <td colspan="5" align="center" >Test Polarité</td></tr>
   <tr>
   <td>Num° Plan</td>
   <td>DATE</td>
   <td>Q/E</td>
   <td>Q/S</td>
   <td>rebut</td>
   </tr>
	
	';
		 
	while($row4=@mysql_fetch_array($req4))
	{
	$num_plan=$row4['n_p_t'];  
	$date_recep=$row4['date_recep'];	
	$qte_e=$row4['qte_e'];
	$qte_s=$row4['qte_s'];
	$nbr_def=$row4['nbr_def'];
	
	
	
	echo"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
    <td>$qte_e</td>
	<td>$qte_s</td>
	<td>$nbr_def</td>
	</tr>
	";
	
	
	
	}
	
	
	echo
	'
	
   <tr>
	
   <td colspan="5" align="center" >Controle Fluke</td></tr>
   <tr>
   <td>Num° Plan</td>
   <td>DATE</td>
   <td>Echantillon</td>
  
   </tr>
	
	';
		 
	while($row5=@mysql_fetch_array($req5))
	{
	$num_plan=$row5['n_p_t'];  
	$date_recep=$row5['date_recep'];	
	$echt=$row5['echt'];
	
	
	
	
	echo"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
    <td>$echt</td>
	
	</tr>
	";
	
	
	
	
	
	}
	echo
	'
	
   <tr>
	
   <td colspan="5" align="center" >Emballage</td></tr>
   <tr>
   <td>Num° Plan</td>
   <td>DATE</td>
   <td>Q/E</td>
  
   </tr>
	
	';
		 
	while($row6=@mysql_fetch_array($req6))
	{
	$num_plan=$row6['n_p_t'];  
	$date_recep=$row6['date_recep'];	
	$qte_e=$row6['qte_e'];

	
	
	
	echo"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
    <td>$qte_e</td>
	
	</tr>
	";
	
	
	
	
	
	
	
	
	
	
	
	
	}	

		
	echo '</table>';

	
 
	
 
	
	 
	
  
  ?>
<br/>
<br/>

</form>


</div>

</div>

</body>

</html>