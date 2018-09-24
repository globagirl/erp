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
		<link href="../tablecloth/table.css" rel="stylesheet" type="text/css" media="screen" />
		<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/style.css"/>
		<script src="../jquery/jquery-latest.min.js"></script>
		<script src="../jquery/jqueryDataTable.min.js"></script>
		<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
		<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
		<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
		<script src="../bootstrap/js/bootbox.min.js"></script>
		<title>Liste des factures</title>
		<script>
		    function updateZone(){
			    var val = document.getElementById("recherche").value;
				if((val == "date_E") || (val == "date_pay")){      
                    $('#zone').html('<input type="date" class="form-control" name="valeur" id="valeur"> ');
				}else if(val == "client"){              
	                $('#zone').html('<select name="valeur" id="valeur" class="form-control"> <option value="s">---Selectionnez</option> </select> ');
					$.ajax({
					    type: 'POST',      
                        url: '../php/listeClient.php',
                        success: function(data) {
                            $('#valeur').html(data);
                    }});	   
	            }else{    
                    $('#zone').html('<input type="text" class="form-control" name="valeur" id="valeur" placeholder="Search "> ');
	            }
			}
			//
			function afficheFact(){
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;
				if($('#S1').is(':checked')){
				    var statut="A";
				}else if($('#S2').is(':checked')){
				    var statut="paid";
				}else if($('#S3').is(':checked')){
				    var statut="unpaid";
				}
                $.ajax({
                    type: 'POST',
					data: 'recherche='+recherche +'&valeur='+val +'&statut='+statut ,
					url: '../php/consult_facture.php',
					success: function(data) {
					    $('#tbody2').html(data);
                }});	  
            }
			//
			function print_facture(F){
                $.ajax({
                   type: 'POST',
				   data:'num_f_1='+F,
				   url: '../tcpdf/factu.php',
				   success: function(data) {
				   document.location.href="../tcpdf/factu.php";
                 }});
             }
	  
            
			//
			function excelFacture(){
	            document.form1.action="../php/excel_consult_facture.php";
                document.form1.submit(); 
            }//
			function excel2015(){
	            document.form1.action="../php/consult_facture2015.php";
                document.form1.submit(); 
            }
			//
			function excel2016(){
	            document.form1.action="../php/consult_facture2016.php";
                document.form1.submit(); 
            }

		</script>
    </head>
	<body>

	
 <div class="container">
			    <div id="page-wrapper">
          <div class="row">
              <div class="col-lg-12">
                            <h1 class="page-header">Factures  </h1>
               </div>           
          </div>
					     <div class="row">
              <div class="col-lg-12">
						           <div class="panel panel-default">
                     <div class="panel-heading"> Liste des factures</div>
                         <div class="panel-body">
								                    <form  id="form1" name="form1" action="" method="POST" target="_blank">
									                     <div class="row">
										                       <div class="pull-left col-lg-8">
											                         <div class="form-group form-inline">
                                     <select class="form-control" name="recherche" id="recherche" onChange="updateZone();">
                                      <option value="num_fact"> Invoice N°</option>
                                      <option value="client"> Client</option>
                                      <option value="produit"> Produit</option>
                                      <option value="PO"> PO client</option>
                                      <option value="date_E"> Date expédition</option>
                                      <option value="date_pay"> Date payment</option>
                                     </select>
											                          <span id="zone"><input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Search "></span>
												                        </div>
												                        <div class="form-group">
												                          <div class="radio-inline">
                                         <label><input type="radio" name="statut" id="S1" value="A" checked>ALL </label>
													                         </div>
                                      <div class="radio-inline">
                                         <label><input type="radio" name="statut" id="S2" value="paid">Paid </label>
                                      </div>
                                      <div class="radio-inline">
                                         <label><input type="radio" name="statut" id="S3" value="unpaid">Unpaid </label>
                                      </div>
													                       </div>
                                    <div class="form-group">                 
												                           <input type="button" onClick="afficheFact();" class="btn btn-primary" Value=">>">
                                       <input type="button" onClick="excelFacture();" class="btn btn-danger" Value="Excel >>">
                                    </div>
                                 </div>
                                 <div class="col-lg-4">
                                  <div class="form-group pull-right form-inline">
                                   <input type="button" onClick="excel2016();" class="btn btn-danger" Value="Excel 2016">
                                   <input type="button" onClick="excel2015();" class="btn btn-danger" Value="Excel 2015">
                                  </div>
                                 </div>
                              </div>
                              <div class="row">
                               <div class="table-responsive" id="divRel">
                                <table  class="table table-fixed table-bordered results" id="table3">
                                 <thead style="width:100%">
                                  <tr>
                                   <th style="width:9.8%;height:60px" class="degraD">N° facture</th>
                                   <th style="width:12.8%;height:60px" class="degraD">Client</th>
													<th style="width:11.8%;height:60px" class="degraD">Date expédition</th>
				                                    <th style="width:14.8%;height:60px" class="degraD">PO</th>	
													<th style="width:12.9%;height:60px" class="degraD">Produit</th>
													<th style="width:9.9%;height:60px" class="degraD">Qty</th>
													<th style="width:9.9%;height:60px" class="degraD">Total</th>																  
													<th style="width:9.9%;height:60px" class="degraD">Statut</th>																  
													<th style="width:6.9%;height:60px" class="degraD"></th>																  
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													<?php
                                                    
													$req= mysql_query("SELECT * FROM fact1 order by num_fact DESC LIMIT 100");  
													while($a=mysql_fetch_object($req)) {
	                                                   														
														$num = $a->num_fact;
														$num_bl = $a->num_bl;
														$client = $a->client;
														$t = $a->tot_val;
														$devise = $a->devise;
														$dateE= $a->date_E;
														$statut = $a->statut;
														$req11= mysql_query("SELECT nomClient FROM client1 where name_client='$client'");
														$clt=mysql_result($req11,0);														
														if($statut=="unpaid"){
														$col="#F6CECE";
														}else{
														$col="#E0F8F1";
														}
														$req2= mysql_query("SELECT * FROM fact_items where idF='$num'");	
														while($a1=mysql_fetch_object($req2)){
														$prd=$a1->produit;
														$po=$a1->PO;
														$qtu=$a1->qty;
														echo'<tr><td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$num.'</td>								                       
										                <td style="width:13%;height:60px;text-align:center;background-color:'.$col.'">'.$clt.'</td>
										                <td style="width:12%;height:60px;text-align:center;background-color:'.$col.'">'.$dateE.'</td>
										                <td style="width:15%;height:60px;text-align:center;background-color:'.$col.'">'.$po.'</td>
										                <td style="width:13%;height:60px;text-align:center;background-color:'.$col.'">'.$prd.'</td>
										                <td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$qtu.'</td>
										                <td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$t.' '.$devise.'</td>
										                <td style="width:10%;height:60px;text-align:center;background-color:'.$col.'">'.$statut.'</td>';
										                echo "<td style=\"width:7%;height:60px;text-align:center\">
														<img src=\"../image/print.png\" onclick=print_facture('".$num_bl."'); style=\"cursor:pointer;\" target=\"_blank\" width=\"30\" height=\"30\"  />
														</td>
												    	</tr>";
    }
																				
													

	                                                    }
														mysql_close();
                                                    ?>
                                                    </tbody>
												</table>
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

    </body>
</html>