  <?php
include('../connexion/connexionDB.php');

$date1 =$_POST["date1"];



  $req = mysql_query ("SELECT SUM(qte_p) FROM plan1 WHERE date_debut LIKE '$date1%'");
 
  $req1 = mysql_query ("SELECT SUM(q_reb) AS nbr_def FROM decoup WHERE date_debut LIKE '$date1%'");
  
  $req2= mysql_query ("SELECT SUM(nbr_def) AS nbr_def FROM pro_assem WHERE date_debut LIKE '$date1%'");
  
  $req3 = mysql_query ("SELECT SUM(nbr_def) AS nbr_def FROM pro_sertiss WHERE date_debut LIKE '$date1%'");
  
  $req4 = mysql_query ("SELECT SUM(nbr_def) AS nbr_def, SUM(qlty) AS nbr_qlty, SUM(p_cc) AS nbr_p_cc, SUM(cntn) AS nbr_cntn, SUM(p_inv) AS nbr_p_inv FROM pro_test_pol WHERE date_debut LIKE '$date1%'");
  
 // $req5 = mysql_query ("SELECT SUM(pass_fail) AS nbr_def FROM pro_contr_fluke WHERE pass_fail like'FAILED' AND n_o_f IN (SELECT num_of FROM  ordre_fabrication WHERE date_exped='$date_exped') ");
  
  $req6 = mysql_query ("SELECT SUM(nbr_def) AS nbr_def FROM pro_emb WHERE date_debut LIKE '$date1%'");
  
  
   
   

   echo'
   <br>
   <br>
   <div class="panel panel-default" >
  <div class="panel-heading">
   Totale Quantité produite:  ';
   
$row=@mysql_fetch_row($req);

	$qte_tot=$row[0];
	echo $qte_tot.'</div>
	<div class="panel-body">';
	echo
	'
	<div class="row">
	<div class="col-md-12 well well-sm">
	<div class="col-md-2">
    Decoupage :
   </div>
  

	
	';
		 
	$row1=@mysql_fetch_row($req1);

	$nbr_def=$row1[0];
	$nbr_tot_def=$nbr_def;
	echo'

 <div class="col-md-1">
	'.$nbr_def.'</div></div>

	';
	
echo
	'
	<div class="col-md-12 well well-sm">
	<div class="col-md-2">
	Assemblage :

	</div>
	';
		 
	$row2=@mysql_fetch_row($req2);
	
	$nbr_def=$row2[0];
		$nbr_tot_def+=$nbr_def;
	
	
	echo'
	<div class="col-md-1">'.
	$nbr_def.'</div></div>
	
	';
	
	
	
	echo
	'
	
<div class="col-md-12 well well-sm">
<div class="col-md-2">
	
   Sertissage:
   
  </div>
  
	
	';
		 
	$row3=@mysql_fetch_row($req3);
	
	
	$nbr_def=$row3[0];
	$nbr_tot_def+=$nbr_def;
	
	
	echo '<div class="col-md-1">'.$nbr_def.'</div></div>';

	
	
	echo '
	<div class="col-md-12 well well-sm">
	<div class="row">
	<div class="col-md-12">
	<div class="col-md-2">  Test Polarité </div>
	
	';
		 
while ($row4=@mysql_fetch_array($req4))
{
	
	$nbr_def=$row4['nbr_def'];
	$nbr_qlty=$row4['nbr_qlty'];
	$nbr_p_cc=$row4['nbr_p_cc'];
	$nbr_cntn=$row4['nbr_cntn'];
	$nbr_p_inv=$row4['nbr_p_inv'];
	$nbr_tot_def+=$nbr_def;
	
	
	echo'<div class="col-md-1">'.$nbr_def.'</div></div>
	<div class="col-md-12">
	<br>
	<div class="col-md-2">
	Qualité 
	</div>
	<div class="col-md-1">'.$nbr_qlty.'</div>
	<div class="col-md-2"> Paire court circuit </div>
	<div class="col-md-1">'.$nbr_p_cc.'</div>
	<div class="col-md-2"> Continuité</div>	
	<div class="col-md-1">'.$nbr_cntn.'</div>
	<div class="col-md-2"> Paire inversé </div>
	<div class="col-md-1">'.$nbr_p_inv.'</div>
	</div></div></div>';
	}
	
	
	echo
	'
	
   <div class="col-md-12 well well-sm">
   <div class="col-md-2">
   Emballage :</div>
  
	
	';
		 
	$row6=@mysql_fetch_row($req6);
		$nbr_def=$row6[0];
		$nbr_tot_def+=$nbr_def;
	echo'
		  <div class="col-md-1">
    '.$nbr_def.'</div>
	
	</div>';
	echo'
	</div>
	</div>

	<div class="panel-footer">
                          
		  <b>Nombre de defauts Total :</b> '.
    $nbr_tot_def.'
	
	</div>
	';
	
	
	echo '</div>';

 
	
  
  ?>