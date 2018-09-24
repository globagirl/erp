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
	//Méme page que consult OF//répitition // Tu peut supprimer 
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
		<title>Consulter OF</title>
		<script>
		    function updateZone(){
			    var val = document.getElementById("recherche").value;
				if((val != "date_exped_conf") && (val != "date_lance")){      
                    document.getElementById("valeur").type="text";
					document.getElementById("valeur").value="";
				}else{    
                    document.getElementById("valeur").type="date";
					document.getElementById("valeur").value="";
	            }
			}
			//
			function afficheOF(){
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;
                if($('#S1').is(':checked')){
				    var statut="A";
				}else if($('#S2').is(':checked')){
				    var statut="planned";
				}else if($('#S3').is(':checked')){
				    var statut="in progres";
				}else if($('#S4').is(':checked')){
				    var statut="closed";
				}
				//alert (statut);
                $.ajax({
                    type: 'POST',
                    data: 'valeur='+val+'&recherche='+recherche+'&statut='+statut,
                    url: '../php/consult_OF.php',
                    success: function(data) {
                        $('#tbody2').html(data);
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
                        <div class="col-lg-12">
                            <h1 class="page-header">Manufacturing orders </h1>
                        </div>           
                    </div>
					<div class="row">
                        <div class="col-lg-12">
						    <div class="panel panel-default">
                                <div class="panel-heading"> Consult Manufacturing orders </div>
                                <div class="panel-body">
								    <form  id="form1" name="form1">
									    <div class="row">
										    <div class="pull-left col-lg-8">
											    
												<div class="form-group">
												    <div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S1" value="A" checked>ALL </label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S2" value="planned">Planned </label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S3" value="in progres">In progress </label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S4" value="closed">Closed </label>
													</div>
             
                                                </div>
												<div class="form-group form-inline">
												    <select class="form-control" name="recherche" id="recherche" onChange="updateZone();">     
													    <option value="A">ALL</option>
														<option value="OF">OF</option>
														<option value="PO">PO</option>                                              
													    <option value="produit">Product</option>             
													    <option value="date_exped_conf">Expédition</option>
														<option value="date_lance">Lancement</option>
													</select>
                                                    <input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Search ">
												    <input type="button" onClick="afficheOF();" class="btn btn-danger" Value=">>">
												</div>
	
                                            </div>
											<br><br><br><br>	
                                            <div class="table-responsive col-lg-12" id="divRel">
											    <table  class="table table-fixed table-bordered results" id="table3">
												    <thead style="width:100%">       
			                                        <tr>
													<th style="width:9.8%;height:60px" class="degraD">OF</th>
													<th style="width:14.8%;height:60px" class="degraD">PO</th>
													<th style="width:14.8%;height:60px" class="degraD">Product</th>
													<th style="width:7.8%;height:60px" class="degraD">QTY</th>
				                                    <th style="width:7.8%;height:60px" class="degraD">Nombre plan</th>	
													<th style="width:7.9%;height:60px" class="degraD">Quantité par plan</th>
													<th style="width:11.9%;height:60px" class="degraD">Date lancement</th>
													<th style="width:11.9%;height:60px" class="degraD">Date expedition</th>
													<th style="width:11.9%;height:60px" class="degraD">Statut</th>			  
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													<?php
                                                        $x=0;
														$req= mysql_query("SELECT * FROM ordre_fabrication1  order by OF DESC");    while(($a=@mysql_fetch_array($req)) && ($x<200)){
	                                                            $x++;
																$OF =$a['OF'];
																$req1= mysql_query("SELECT qte_p FROM plan1 where OF='$OF'");	$qte_p=mysql_result($req1,0);
																echo('<tr id='.$x.'><td style="width:10%;height:40px;text-align:center" class="tdTab">'.$OF.'</td><td  style="width:15%;height:40px;text-align:center">'.$a['PO'].'</td><td style="width:15%;height:40px;text-align:center">'.$a['produit'].'</td><td style="width:8%;height:40px;text-align:center">'.$a['qte'].'</td><td style="width:8%;height:40px;text-align:center">'.$a['nbr_plan'].'</td><td style="width:8%;height:40px;text-align:center">'.$qte_p.'</td>	<td style="width:12%;height:40px;text-align:center">'.$a['date_lance'].'</td>	<td style="width:12%;height:40px;text-align:center">'.$a['date_exped_conf'].'</td>	<td style="width:12%;height:40px;text-align:center">'.$a['statut'].'</td>');

	                                                        }
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