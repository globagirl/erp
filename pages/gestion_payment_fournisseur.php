<?php
    session_start ();
    if( !isset($_SESSION["role"]) ){
        header('Location: ../index.php');
        exit();
    }else{
        $role=$_SESSION['role'];
        $userID=$_SESSION['userID'];
		include('../connexion/connexionDB.php');
    }
?>
<html>
    <head>
        <meta charset="utf-8" />	
		<link rel="stylesheet" type="text/css" href="../css/style.css"/>
		<script src="../jquery/jquery-latest.min.js"></script>		
		<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
		<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
		<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
		<script src="../bootstrap/js/bootbox.min.js"></script>
		<title>Gestion payment fournisseur</title>
		<script>
		
			//
			function afficheFacture(){
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var four = document.getElementById("four").value;
				
				$.ajax({
                  type: 'POST',
                  data: 'four='+four,
                  url: '../php/gestion_payment_fournisseur.php',
                  success: function(data) {
                        $('#tbody2').html(data);
                }});
			
            }
            //
                        
			function totalInvoice(){			    
               var valeurs = [];
               $("input:checked").each(function (box) {
                if($(this).val() != "on"){
                 valeurs.push($(this).val());
                }
                });
				
				$.ajax({
                  type: 'POST',
                  data: 'invoices='+valeurs,
                  url: '../php/gestion_paymentF_total.php',
                  success: function(data) {
                       $('#totalF').html(data);
                }});
			
            }
			//
			function printListeF(){      
	           document.form1.action="../tcpdf/print_payment_fournisseur.php";
			   document.form1.submit(); 
			   }
            //
            
            //
			function checkAllFact(){ 
               if($('#checkALL').prop('checked')){
                   $('input:checkbox').prop('checked',true);  
               }else{			
	               $('input:checkbox').prop('checked',false);   
			   }
               totalInvoice();
            }//

		</script>
    </head>
	<body>
	<div id="entete">
        <div id="logo"></div>
        <div id="boton"><?php include('../include/logOutIMG.php');?></div>
    </div>
	<div id="main">
        <div id="menu">
		    <?php
                if($role=="ADM"){
				    include('../menu/menuAdmin.php');
				}else if($role=="COM"){
                    include('../menu/menuCommercial.php');	
                }else if($role=="FIN"){
                    include('../menu/menuFinance.php');	
                }else{
	                header('Location: ../deny.php');
                }
            ?>
        </div>
		<div id='contenu'>
            <div class="container">
			    <div id="page-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <h1 class="page-header">Payment </h1>
                        </div>           
                    </div>
					<div class="row">
                        <div class="col-md-12">
						    <div class="panel panel-default">
                                <div class="panel-heading"> Gestion payment fournisseur</div>
                                <div class="panel-body">
								    <form  id="form1" name="form1" method="POST" target="_blank">
									    <div class="row">
										    <div class="col-md-12">						      	
											    										
												<div class="form-group">
                                                    
												    <label>Fournisseur</label>
                                                    <div class="form-group form-inline">
                                                    <select class="form-control" id="four" name="four">
                                                        <?php
                                                        $q1 = mysql_query("SELECT nom FROM fournisseur1");
                                                        echo '<option value="S">Selectionnez...</option>';
                                                        while($data1=mysql_fetch_array($q1)) {
                                                            echo '<option value="'.$data1["nom"].'">'.$data1["nom"].'</option>';
                                                        }
                                                        mysql_close();
                                                        ?>
                                                    </select>
                                                     <input type="button" onClick="afficheFacture();" class="btn btn-primary" Value="Consult >>"/>
												 
                                                    </div>
												</div>
                                              
                                            </div>
                                               
												
                                            
                                            <div class="col-md-12">
                                            <div class="row">
										
                                            <div class="col-md-9">
                                            <br><br>
                                            <div class="table-responsive" id="divRel">
											    <table  class="table table-fixed  results" id="table3">
												    <thead style="width:100%">       
			                                        <tr>
													<th style="width:4.8%;height:60px;text-align:center" >
                                                        <input type="checkbox" name="checkALL" id="checkALL" onClick="checkAllFact();"></th>
													<th style="width:24.8%;height:60px;text-align:center">N° Facture</th>
													<th style="width:19.8%;height:60px;text-align:center">Date facture</th>	
													<th style="width:19.9%;height:60px;text-align:center">Echéance</th>
													<th style="width:19.9%;height:60px;text-align:center">Montant</th>
													<th style="width:9.9%;height:60px;text-align:center">Devise</th>
													
														  
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													
                                                    </tbody>
												</table>
											</div> 
											</div> 
											<div class="col-md-3">
											
											<br><br><br><br>
                                            <h2 id="totalF">Total : </h2>
											<button type="button" onClick="printListeF();" class="btn btn-success btn-block">Imprimer</button>
											
											</div>
                                            </div>
                                            </div>
                                        </div>
                                    </form>
                                </div> 
                            </div> 
                        </div> 
                    </div>
				</div>
            </div>
        </div>
    </div>
    </body>
</html>