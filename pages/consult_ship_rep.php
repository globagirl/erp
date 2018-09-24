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
		<title>Shipment report</title>
		<script>
		    function updateZone(){
			    var val = document.getElementById("recherche").value;
				if(val == "dateE"){      
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
			function afficheShip(){
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;
                $.ajax({
                    type: 'POST',
					data: 'recherche='+recherche +'&valeur='+val ,
					url: '../php/consult_ship_rep.php',
					success: function(data) {
					    $('#tbody2').html(data);
                }});	  
            }
			//
			function print_ship(clt,dateE){
			    bootbox.alert("Wait plz ...");
                $.ajax({
                   type: 'POST',
				   data:'client='+clt+'&dateE='+dateE,
				   url: '../tcpdf/shipment_report.php',
				   success: function(data) {
				   //document.location.href="../tcpdf/shipment_report.php";
				   window.open('../tcpdf/shipment_report.php','_blank');
				    bootbox.hideAll();
                 }});
             }
	  
            
			

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
                }else{
	                header('Location: ../deny.php');
                }
            ?>
        </div>
		<div id='contenu'>
            <div class="container">
			    <div id="page-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Shipment Reports </h1>
                        </div>           
                    </div>
					<div class="row">
                        <div class="col-lg-12">
						    <div class="panel panel-default">
                                <div class="panel-heading"> Liste shipments</div>
                                <div class="panel-body">
								    <form  id="form1" name="form1" method="POST" target="_blank">
									    <div class="row">
										    <div class="pull-left col-lg-8">
											    <div class="form-group form-inline">
												 
												    <select class="form-control" name="recherche" id="recherche" onChange="updateZone();">     
													  
														<option value="IDshipment"> Shipment N°</option>
														<option value="client"> Client</option> 
														<option value="dateE">Date expédition</option> 
														<option value="dateC">Date creation/option> 
														<option value="nbrPal"> Total palettes</option>	
													
													</select>
											
												
                                                    <span id="zone"><input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Search "></span>
												
												    <input type="button" onClick="afficheShip();" class="btn btn-primary" Value=">>"> 
												
												</div>
	
                                            </div>
												
											<br><br><br><br>	
                                            <div class="table-responsive col-lg-12" id="divRel">
											    <table  class="table table-fixed  results" id="table3">
												    <thead style="width:100%">       
			                                        <tr>
													<th style="width:19.9%;height:60px">Shipment ID</th>
													<th style="width:19.9%;height:60px"> Client</th>
													<th style="width:19.7%;height:60px">Date expédition</th>
													<th style="width:19.8%;height:60px">Date Creation</th>
													<th style="width:9.8%;height:60px">Nbr palette</th>
													<th style="width:9.7%;height:60px"></th>
													
																													  
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													<?php
                                                    
													$req= mysql_query("SELECT * FROM shipment_report order by dateE DESC LIMIT 100");  
													while($a=mysql_fetch_array($req)) {
	                                                   														
														$ship = $a['IDshipment'];
														$dateE = $a['dateE'];
														$dateC = $a['dateC'];
														$client = $a['client'];
														$nbrPal = $a['nbrPal'];
														
														$req11= mysql_query("SELECT nomClient FROM client1 where name_client='$client'");
														$clt=@mysql_result($req11,0);
														echo'<tr><td style="width:20%;height:60px;">'.$ship.'</td>
														<td style="width:20%;height:60px;">'.$clt.'</td>
														<td style="width:20%;height:60px;">'.$dateE.'</td>
														<td style="width:20%;height:60px;">'.$dateC.'</td>
														<td style="width:10%;height:60px;">'.$nbrPal.'</td>								                       
										                
												    	</tr>';
														 echo "<td style=\"width:10%;height:60px;text-align:center\">
														<img src=\"../image/print.png\" onclick=print_ship('".$client."','".$dateE."'); style=\"cursor:pointer;\" target=\"_blank\" width=\"30\" height=\"30\"  />
														</td>
												    	</tr>";
                                                        }
																				
													

	                                                    
														mysql_close();
                                                    ?>
                                                    </tbody>
												</table>
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