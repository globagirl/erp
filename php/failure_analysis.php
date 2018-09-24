<?php
include('../connexion/connexionDB.php');
$date1=$_POST['date1'];
$date2=$_POST['date2'];
if($date2==""){
$date2=$_POST['date1'];
}
$dateX=$date1;

echo '

			<br>
                    <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Polarity test failures
                        </div>
                       
                        <div class="panel-body">
						<div class="row">';
		while($date1 <= $date2){				
		$req1=mysql_query ("SELECT * FROM pro_test_pol where date_debut LIKE '$date1%'");		
		while($data1=mysql_fetch_array($req1)){				
						$nbr_def=$data1['nbr_def'];
						$qty=$data1['qte_e'];
						$x=($nbr_def*100)/$qty;
						$x= round ( $x,2);
						$PO=$data1['PO'];
						if($x >=3){
						$req2=mysql_query ("SELECT produit FROM commande_items where POitem = '$PO'");
						$produit=mysql_result($req2,0);
						
	         echo '     <div class="col-lg-12">
	                    <div class="col-lg-6">
                         Plan :
                        </div>
						<div class="col-lg-6">
                         '.$data1['plan'].' / '.$date1.'
						 
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                         Purchase order :
                        </div>
						<div class="col-lg-6">
                         '.$data1['PO'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Product  :
                        </div>
						<div class="col-lg-6">
                        '.$produit.'
                        </div>
						</div>
						
						
						
						
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                         Line :
                        </div>
						<div class="col-lg-6">
                         '.$data1['ch_ins'].'
                        </div>						
						</div>
						
						
						<div class="col-lg-12">
	                    <div class="col-lg-6">                         
                           Control agent:
                        </div>
						<div class="col-lg-6">
                        '.$data1['ag_cont'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">                         
                           Operator 1 :
                        </div>
						<div class="col-lg-6">
                        '.$data1['op_1'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">                         
                           Operator 2 :
                        </div>
						<div class="col-lg-6">
                        '.$data1['op_2'].'
                        </div>						
						</div>
						<div class="col-lg-12" style="background-color:#F6CEF5">
	                    <div class="col-lg-6">
                         Defects percentage   :
                        </div>
						<div class="col-lg-6">
                         '.$x.'%
                        </div>						
						</div>
						
												
						
						
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">
                         Input qty :
                        </div>
						<div class="col-lg-6">
                         '.$data1['qte_e'].'
                        </div>						
						</div>
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">
                         Defects :
                        </div><div class="col-lg-6">
                        '.$data1['nbr_def'].'
                        </div>
						</div>
                         <div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">                         
                           Quality :
                        </div>
						<div class="col-lg-6">
                        '.$data1['qlty'].'
                        </div>						
						</div>
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">                         
                           Polarity :
                        </div>
						<div class="col-lg-6">
                        '.$data1['p_inv'].'
                        </div>						
						</div>
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">                         
                           Short circuit :
                        </div>
						<div class="col-lg-6">
                        '.$data1['p_cc'].'
                        </div>						
						</div>
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">                         
                           No continuity :
                        </div>
						<div class="col-lg-6">
                        '.$data1['cntn'].'
                        </div>
                         						
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">                         
                           <hr>
                        </div>
						<div class="col-lg-6">
                        <hr>
                        </div>
                         						
						</div>
						
					
						';
						}
						}
						$dateNext= strtotime($date1."+ 1 day");
						$date1= date('Y-m-d', $dateNext);
						}
						
						echo '
					
						</div>
						
						
						
						</div>
					</div>
                    </div>	
				
			';
			
			///
				echo '
                    <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Fluke test failures
                        </div>
                       
                        <div class="panel-body">
						<div class="row">';
						$date1=$dateX;
		while($date1 <= $date2){				
		$req11=mysql_query ("SELECT * FROM pro_contr_fluke where date_debut LIKE '$date1%' and pass_fail='fail'");		
		while($data11=mysql_fetch_array($req11)){				
						
						$req22=mysql_query ("SELECT produit FROM commande_items where POitem = '$PO'");
						$produit=mysql_result($req22,0);
						
	         echo '     <div class="col-lg-12">
	                    <div class="col-lg-6">
                         Plan :
                        </div>
						<div class="col-lg-6">
                         '.$data11['plan'].'
						 
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                         Purchase order :
                        </div>
						<div class="col-lg-6">
                         '.$data11['PO'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Product  :
                        </div>
						<div class="col-lg-6">
                        '.$produit.'
                        </div>
						</div>
																
						
						
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                         Input qty :
                        </div>
						<div class="col-lg-6">
                         '.$data11['qte_e'].'
                        </div>						
						</div>
						
						
						
						<div class="col-lg-12">
	                    <div class="col-lg-6">                         
                           Control agent:
                        </div>
						<div class="col-lg-6">
                        '.$data11['ag_cont'].'
                        </div>
						<hr>
						</div>
						
					
						';
						}
						
						$dateNext= strtotime($date1."+ 1 day");
						$date1= date('Y-m-d', $dateNext);
						}
						
						echo '
					
						</div>
						
						
						
						</div>
					</div>
                    </div>	
				
			';
		 
		///
echo '

			<br>
                    <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Crimping default
                        </div>
                       
                        <div class="panel-body">
						<div class="row">';
						$date1=$dateX;
		while($date1 <= $date2){				
		$req13=mysql_query ("SELECT * FROM pro_sertiss where date_debut LIKE '$date1%'");		
		while($data13=mysql_fetch_array($req13)){				
						$nbr_def=$data13['nbr_def'];
						$qty=$data13['qte_e'];
						$x=($nbr_def*100)/$qty;
						$x= round ( $x,2);
						$PO=$data13['PO'];
						//if($x >=1){
						if($nbr_def >=1){
						$req2=mysql_query ("SELECT produit FROM commande_items where POitem = '$PO'");
						$produit=mysql_result($req2,0);
						
	         echo '     <div class="col-lg-12">
	                    <div class="col-lg-6">
                         Plan :
                        </div>
						<div class="col-lg-6">
                         '.$data13['plan'].' / '.$date1.'
						 
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                         Purchase order :
                        </div>
						<div class="col-lg-6">
                         '.$data13['PO'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Product  :
                        </div>
						<div class="col-lg-6">
                        '.$produit.'
                        </div>
						</div>
						
						
						
						
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                         Line :
                        </div>
						<div class="col-lg-6">
                         '.$data13['num_mach'].'
                        </div>						
						</div>
						
						
						<div class="col-lg-12">
	                    <div class="col-lg-6">                         
                           Control agent:
                        </div>
						<div class="col-lg-6">
                        '.$data13['ag_cont'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">                         
                           Operator :
                        </div>
						<div class="col-lg-6">
                        '.$data13['nom_opr'].'
                        </div>
						</div>
						
						<div class="col-lg-12" style="background-color:#F6CEF5">
	                    <div class="col-lg-6">
                         Defects percentage   :
                        </div>
						<div class="col-lg-6">
                         '.$x.'%
                        </div>						
						</div>
						
												
						
						
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">
                         Input qty :
                        </div>
						<div class="col-lg-6">
                         '.$data13['qte_e'].'
                        </div>						
						</div>
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">
                         Defects :
                        </div><div class="col-lg-6">
                        '.$data13['nbr_def'].'
                        </div>
						</div>
                         <div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">                         
                           Pair length :
                        </div>
						<div class="col-lg-6">
                        '.$data13['long_pair'].'
                        </div>						
						</div>
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">                         
                           Damaged PIN :
                        </div>
						<div class="col-lg-6">
                        '.$data13['pin_end'].'
                        </div>						
						</div>
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">                         
                           striped cable :
                        </div>
						<div class="col-lg-6">
                        '.$data13['cable_r'].'
                        </div>						
						</div>
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">                         
                           Contaminated product :
                        </div>
						<div class="col-lg-6">
                        '.$data13['prod_s'].'
                        </div>
                         						
						</div>
						
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">                         
                           Damaged shield :
                        </div>
						<div class="col-lg-6">
                        '.$data13['sh_end'].'
                        </div>
                         						
						</div>
						<div class="col-lg-12" style="background-color:#FBEFFB">
	                    <div class="col-lg-6">                         
                           Damaged plug :
                        </div>
						<div class="col-lg-6">
                        '.$data13['ang_pl_end'].'
                        </div>
                         						
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">                         
                           <hr>
                        </div>
						<div class="col-lg-6">
                        <hr>
                        </div>
                         						
						</div>
						
					
						';
						}
						}
						$dateNext= strtotime($date1."+ 1 day");
						$date1= date('Y-m-d', $dateNext);
						}
						
						echo '
					
						</div>
						
						
						
						</div>
					</div>
                    </div>	
				
			';
			
			///		
		

?>