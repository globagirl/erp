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
		<script src="../jquery/jqueryDataTable.min.js"></script>
		<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
		<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
		<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
		<script src="../bootstrap/js/bootbox.min.js"></script>
		<title>Consulter bande relance</title>
		<script>
		    //affiche relance info
		    function afficheInfo(ID){
			  $.ajax({
                type: 'POST',
				data:'IDrelance='+ID,
				url: '../pages/consult_relance_info.php',
				success: function(data) {
                     document.location.href="../pages/consult_relance_info.php";
                }});

            }
			//
			function affiche_relance(){
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;
               
				var statut = document.querySelector('input[name=statut]:checked').value;
				//alert (statut);
				
                $.ajax({
                    type: 'POST',
                    data: 'valeur='+val+'&recherche='+recherche+'&statut='+statut,
                    url: '../php/consult_bande_relance.php',
                    success: function(data) {
                        $('#tbody2').html(data);
                }});
	  
            }
			//
			

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
			}else if($role=="CTRL"){
			include('../menu/menuCTRL.php');
			}else if($role=="MAG"){
			include('../menu/menuMagazin.php');
			}else if($role=="LOG"){
			include('../menu/menuLogistique.php');	
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
                            <h1 class="page-header">Manufacturing orders </h1>
                        </div>           
                    </div>
					<div class="row">
                        <div class="col-md-12">
						    <div class="panel panel-default">
                                <div class="panel-heading"> Consult Manufacturing orders </div>
                                <div class="panel-body">
								    <form  id="form1" name="form1" method="POST">
									    <div class="row">
										    <div class="pull-left col-md-8">
											    
												<div class="form-group">
												    <div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S1" value="ALL" checked>ALL </label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S2" value="A">En attente </label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S3" value="C">Confirmé </label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S4" value="R">Refusé</label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S5" value="T">Traité</label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S6" value="SC">Controlé</label>
													</div>
             
                                                </div>
												<div class="form-group form-inline">
												    <select class="form-control" name="recherche" id="recherche" onChange="updateZone()">     
													    <option value="A">ALL</option>
														<option value="OF">OF</option>
														<option value="PO">PO</option>                                              
													    <option value="produit">Produit</option>             
													    <option value="dateD">Date demande</option>             
													    <option value="dateV">Date validation</option>             
													    <option value="dateS">Date sortie</option>             
													    
													</select>
                                                    <input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Search ">
												    <input type="button" onClick="affiche_relance();" class="btn btn-danger" Value=">>">
												</div>
	
                                            </div>
											<br><br><br><br>	
                                            <div class="table-responsive col-md-12" id="divRel">
											    <table  class="table table-fixed table-bordered results" id="table3">
												    <thead style="width:100%">       
			                                        <tr>
													<th style="width:14.8%;height:60px" class="degraD">N° relance</th>												
													<th style="width:19.8%;height:60px" class="degraD">PO</th>
													<th style="width:14.8%;height:60px" class="degraD">OF</th>
													<th style="width:19.8%;height:60px" class="degraD">Produit</th>
													<th style="width:9.8%;height:60px" class="degraD">QTY</th>
				                                    <th style="width:9.8%;height:60px" class="degraD">Statut</th>	
													<th style="width:9.9%;height:60px" class="degraD"></th>
																  
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													<?php
                                                    $x=0;
													$req= mysql_query("SELECT * FROM bande_relance  order by OF DESC LIMIT 100 ");  
													while($a=mysql_fetch_array($req)){
	                                                    $x++;
														$OF =$a['OF'];
														$stat=$a['statut'];
														if($stat=="A"){
														$statut="En attente ";
														}else if($stat=="C"){
														$statut="Confirmé ";
														}else if($stat=="R"){
														$statut="Refusée ";
														}else if($stat=="T"){
														$statut="Traité ";
														}else if($stat=="CT"){
														$statut="Controlé ";
														}
	
														$req1= mysql_query("SELECT PO,produit FROM ordre_fabrication1 where OF='$OF'");	
														$a1=mysql_fetch_array($req1);
														$IDrelance=$a['IDrelance'];
														echo("<tr><td style=\"width:15%;height:40px;text-align:center\" >".$a['IDrelance']."</td>");
														echo ('
														<td style="width:20%;height:40px;text-align:center">'.$a1['PO'].'</td>
														<td style="width:15%;height:40px;text-align:center">'.$a['OF'].'</td>
														<td style="width:20%;height:40px;text-align:center">'.$a1['produit'].'</td>
														<td style="width:10%;height:40px;text-align:center">'.$a['nbr_piece'].'</td>
														<td style="width:10%;height:40px;text-align:center">'.$statut.'</td>');
														echo "<td style=\"width:10%;height:40px;text-align:center\">
														<input type=\"button\" onClick=afficheInfo('".$IDrelance."'); Value=\">>\"></td></tr>";
														
														
													

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