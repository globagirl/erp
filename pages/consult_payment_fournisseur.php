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
		<title>Payment client</title>
		<script>
		    function updateZone(){
			    var val = document.getElementById("recherche").value;
				if((val == "dateE") || (val == "dateP")){      
                    $('#zone').html(' <input type="date" class="form-control" name="valeur1" id="valeur1"> >> <input type="date" class="form-control" name="valeur2" id="valeur2">');
				}else if(val=="fournisseur"){ 
                    $.ajax({
                    type: 'POST',               
                    url: '../php/listeFournisseur.php',
                    success: function(data) {
                        $('#zone').html('<select name="valeur1" id="valeur" class="form-control">'+data+'</select>');
                    }});				
                    
	            }else if(val=="compte"){ 
                    $.ajax({
                    type: 'POST',               
                    url: '../php/listeCompte.php',
                    success: function(data) {
                        $('#zone').html('<select name="valeur1" id="valeur" class="form-control">'+data+'</select>');
                    }});				
                    
	            }else{
				    $('#zone').html('<input type="text" class="form-control" name="valeur1" id="valeur" placeholder="Search">');
				}
			}
			//
			function afficheP(){
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
				var recherche = document.getElementById("recherche").value;  
				if((recherche == "dateE") || (recherche == "dateP")){
				    var val1 = document.getElementById("valeur1").value;
				    var val2 = document.getElementById("valeur2").value;				
				}else{				
                    var val1 = document.getElementById("valeur").value;
					var val2=val1;
				}	              
				
                $.ajax({
                    type: 'POST',
                    data: 'valeur1='+val1+'&recherche='+recherche+'&valeur2='+val2,
                    url: '../php/consult_payment_fournisseur.php',
                    success: function(data) {
                        $('#tbody2').html(data);
                }});
	  
            }
			
            function affichePayInfo(i){
			    $.ajax({
                    type: 'POST',
					data:'IDpay='+i,
					url: '../pages/consult_paymentF_info.php',
					success: function(data) {
                        document.location.href="../pages/consult_paymentF_info.php";
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
                        <div class="col-lg-12">
                            <h1 class="page-header">Payment Fournisseur </h1>
                        </div>           
                    </div>
					<div class="row">
                        <div class="col-lg-12">
						    <div class="panel panel-default">
                                <div class="panel-heading"> Liste des payment client </div>
                                <div class="panel-body">
								    <form  id="form1" name="form1" method="POST">
									    <div class="row">
										    <div class="pull-left col-lg-8">											   
												<div class="form-group form-inline">
												    <select class="form-control" name="recherche" id="recherche" onChange="updateZone();">     
													    <option value="A">ALL</option>
														<option value="dateP">Date payment</option>
														<option value="compte">Compte</option>
														<option value="fournisseur">Fournisseur</option>
														<option value="IDpay">N° payment</option>
														<option value="dateE">Date entrée</option>
													</select>
                                                    <span id="zone"><input type="text" class="search form-control" name="valeur1" id="valeur" placeholder="Search "></span> 
												    <input type="button" onClick="affichePC();" class="btn btn-primary" Value=">>">
												</div>
	
                                            </div>
											<div class="col-lg-4">											    
												<div class="form-group pull-right form-inline">
												    													
												</div>
											</div>
											<br><br><br><br>	
                                            <div class="table-responsive col-lg-12" id="divRel">
											    <table  class="table table-fixed table-bordered results" id="table3">
												    <thead style="width:100%">       
			                                        <tr>
													<th style="width:19.7%;height:60px" class="degraD">N° payment</th>
													<th style="width:19.7%;height:60px" class="degraD">Fournisseur</th>
													<th style="width:14.7%;height:60px" class="degraD">Date payment</th>
													<th style="width:19.8%;height:60px" class="degraD">Compte</th>
				                                    <th style="width:14.8%;height:60px" class="degraD">Montant</th>
													<th style="width:9.8%;height:60px" class="degraD"></th>			  
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													<?php
                                                    $x=0;
													$req= mysql_query("SELECT * FROM payment_fournisseur");
													while(($a=mysql_fetch_array($req)) && ($x<200)){
	                                                    $x++;
                                                        $IDpay=$a['IDpay'];													
														echo ('<tr>
														<td style="width:20%;height:40px;text-align:center">'.$a['IDpay'].'</td>
														<td style="width:20%;height:40px;text-align:center">'.$a['fournisseur'].'</td>
														<td style="width:15%;height:40px;text-align:center">'.$a['dateP'].'</td>
														<td style="width:20%;height:40px;text-align:center">'.$a['compte'].'</td>
														<td style="width:15%;height:40px;text-align:center">'.$a['solde'].'</td>
														<td style="width:10%;height:40px;text-align:center">');
														
														echo "<img src=\"../image/viewFile.png\" onclick=affichePayInfo('".$IDpay."'); alt=\"see\" style=\"cursor:pointer;\" width=\"30\" height=\"30\"  /></td></tr>";

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