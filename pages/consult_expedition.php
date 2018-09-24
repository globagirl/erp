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
		<title>Consulter OF</title>
		<script>
		    function updateZone(){
			    var val = document.getElementById("recherche").value;
				if((val != "date_exp") && (val != "date_crea")){      
                    $('#zone').html('<input type="text" class="form-control" name="valeur" id="valeur">');
				}else{    
                    $('#zone').html('<input type="date" class="form-control" name="valeur" id="valeur">');
	            }
			}
			//
			function afficheEXP(){
			    $('#div1').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;
                
				//alert (statut);
                $.ajax({
                    type: 'POST',
                    data: 'valeur='+val+'&recherche='+recherche,
                    url: '../php/consult_expedition.php',
                    success: function(data) {
                        $('#div1').html(data);
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
				}elseif($role=="CONS"){
                    include('../menu/menuConsommable.php');
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
                            <h1 class="page-header">Expédition </h1>
                        </div>           
                    </div>
					<div class="row">
                        <div class="col-md-12">
						    <div class="panel panel-default">
                                <div class="panel-heading"> Liste des expéditions </div>
                                <div class="panel-body">
								    <form  id="form1" name="form1">
									    <div class="row">
										    <div class="pull-left col-md-8">											    
												<div class="form-group form-inline">
												    <select class="form-control" name="recherche" id="recherche" onChange="updateZone();">   
													  
														<option value="date_exp">Date expédition</option>
														<option value="date_crea">Date création</option>                                              
													    <option value="PO">PO</option>             
													   
													</select>
                                                    <span id="zone">
                                                        <input type="date" class="form-control" name="valeur" id="valeur">
                                                    </span>
                                                    
												    <input type="button" onClick="afficheEXP();" class="btn btn-danger" Value=">>">
												</div>
	
                                            </div>
											<div class="col-md-12" id="div1">	
                                              
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