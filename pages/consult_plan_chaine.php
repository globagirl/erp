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
consultation plan / chaine
</title>



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
<p class="two">QUALITE</p>
<div id="globalc">
<div id="mbmcpebul_wrapper" style="max-width: 413px;">
  <ul id="mbmcpebul_table" class="mbmcpebul_menulist css_menu">
  <li class="first_button"><div class="buttonbg gradient_button gradient30" style="width: 150px;"><div class="arrow"><a>Consulter les OF / plan</a></div></div>
    <ul>
    <li class="first_item"><a href="pro_consu_plan.php" title="">Cosulter OF / plan</a></li>
    <li class="last_item"><a href="pro_consu_plan_ch.php" title="">Plan / chaine</a></li>
    </ul></li>
  <li><div class="buttonbg gradient_button gradient30" style="width: 155px;"><div class="arrow"><a>Consulter les graphes</a></div></div>
    <ul>
    <li class="first_item"><a title="">************</a></li>
    <li class="last_item"><a title="">************</a></li>
    </ul></li>
  <li class="last_button"><div class="buttonbg gradient_button gradient30" style="width: 106px;"><div class="arrow"><a>Fabrication</a></div></div>
    <ul>
    <li class="first_item"><a class="with_arrow" title="">Nomenclature</a>
      <ul>
      <li class="first_item"><a href="fab_ajout_nomenc.php" title="">Ajout nomenclature</a></li>
      <li class="last_item"><a title="">consulter nomenclature</a></li>
      </ul></li>
    <li class="separator"><div></div></li>
    <li class="last_item"><a class="with_arrow" title="">Article</a>
      <ul>
      <li class="first_item"><a href="fab_ajout_article.php" title="">Ajout article</a></li>
      <li class="last_item"><a title="">consulter article</a></li>
      </ul></li>
    </ul></li>
  </ul>
</div>
</div>


<p class="there">Consulter les plans par chaine</p>
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
   <table border="1" bordercolor="red" >

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
	
   <td colspan="5" align="center" >Découpage</td></tr>
   <tr>
   <td>Num° Plan</td>
   <td>DATE</td>
   <td>Num° Machine</td>
   <td>Opérateur</td>
   <td>rebut</td>
   
   
   
   </tr>
	
	';
		 
	while($row1=@mysql_fetch_array($req1))
	{
	$num_plan=$row1['n_p_t'];  
	$date_recep=$row1['date'];	
	$mach_dec=$row1['mach_dec'];
	$nom_oper=$row1['nom_oper'];
	$nbr_def=$row1['q_reb'];
	
	echo"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
    <td>$mach_dec</td>
	<td>$nom_oper</td>
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
   <td>Num chaine</td>
   <td>Agent Qualité</td>
    <td>rebut</td>
	
	
   </tr>
	
	';
		 
	while($row2=@mysql_fetch_array($req2))
	{
	$num_plan=$row2['n_p_t'];  
	$date_recep=$row2['date'];	
	$ch_ins=$row2['ch_ins'];
	$ag_cont=$row2['ag_cont'];
	$nbr_def=$row2['nbr_def'];
	
	
	
	echo"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
    <td>$ch_ins</td>
	<td>$ag_cont</td>
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
   <td>Num chaine</td>
   <td>Agent qualité</td>
    <td>rebut</td>
	
   </tr>
	
	';
		 
	while($row3=@mysql_fetch_array($req3))
	{
	$num_plan=$row3['n_p_t'];  
	$date_recep=$row3['date'];	
	$num_ch=$row3['num_ch'];
	$ag_cont=$row3['ag_cont'];
	$nbr_def=$row3['nbr_def'];
	
	
	echo
	
	"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
    <td>$num_ch</td>
	<td>$ag_cont</td>
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
   <td>Num chaine</td>
   <td>Agent qualité</td>
   <td>rebut</td>
   </tr>
	
	';
		 
	while($row4=@mysql_fetch_array($req4))
	{
	$num_plan=$row4['n_p_t'];  
	$date_recep=$row4['date'];	
	$ch_ins=$row4['ch_ins'];
	$ag_cont=$row4['ag_cont'];
	$nbr_def=$row4['nbr_def'];
	
	
	
	echo"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
    <td>$ch_ins</td>
	<td>$ag_cont</td>
	<td>$nbr_def</td>
	 
	</tr>
	";
	
	
	
	}
	
	
	echo
	'
	
   
   <tr>
	
   <td colspan="5" align="center" >Contrôle Fluke</td></tr>
   <tr>
   <td>Num° Plan</td>
   <td>DATE</td>
  
   <td>Agent qualité</td>
   
   </tr>
	
	';
		 
	while($row5=@mysql_fetch_array($req5))
	{
	$num_plan=$row5['n_p_t'];  
	$date_recep=$row2['date_recep'];	
	$ag_cont=$row5['ag_cont'];
	
	
	
	
	echo"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
    <td>$ag_cont</td>
	
	</tr>
	";
	
	
	
	
	
	}
	echo
	'
	
   <tr>
	
   
   <tr>
	
   <td colspan="5" align="center" >Emballage</td></tr>
   <tr>
   <td>Num° Plan</td>
   <td>DATE</td>
   <td>Num chaine</td>
   <td>Agent qualité</td>
   
   </tr>
  
   </tr>
	
	';
		 
	while($row6=@mysql_fetch_array($req6))
	{
	$num_plan=$row6['n_p_t'];  
	$date_recep=$row6['date_recep'];
    $ch_ins=$row6['ch_ins'];
	$ag_cont=$row6['ag_cont'];
	
	
	echo"
	
	<td>$num_plan</td>
	<td>$date_recep</td>
	<td>$ch_ins</td>
	<td>$ag_cont</td>
	
	
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