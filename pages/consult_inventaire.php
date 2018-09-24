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
				data:'IDinventaire='+ID,
				url: '../php/consult_inventaire_article.php',
				success: function(data) {
                     document.location.href="../php/consult_inventaire_article.php";
                }});

            }
			//
			function affiche_inventaire(){
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;          
				
                $.ajax({
                    type: 'POST',
                    data: 'valeur='+val+'&recherche='+recherche,
                    url: '../php/consult_inventaire.php',
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
												<div class="form-group form-inline">
												    <select class="form-control" name="recherche" id="recherche" >     
													    <option value="dateI">Date inventaire</option>
														<option value="dateE">Date entrée</option>
														          
													    
													</select>
                                                    <input type="date" class="search form-control" name="valeur" id="valeur" placeholder="Search ">
												    <input type="button" onClick="affiche_inventaire();" class="btn btn-danger" Value=">>">
												</div>
	
                                            </div>
											<br><br><br><br>	
                                            <div class="table-responsive col-md-12" id="divRel">
											    <table  class="table table-fixed  results" id="table3">
												    <thead style="width:100%">       
			                                        <tr>
                                                    <th style="width:19.8%"> Inventaire</th>
													<th style="width:19.8%"> Date Inventaire</th>												
													<th style="width:29.8%">Operateur</th>
													<th style="width:19.8%">Date entrée</th>
													<th style="width:9.8%"></th>                            
																  
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													<?php
                                                    $x=0;
													$req= mysql_query("SELECT * FROM inventaire  order by dateI DESC LIMIT 100 ");  
													while($a=mysql_fetch_array($req)){	                                                    
														$ID=$a['operateur'];	
														$req1= mysql_query("SELECT nom  FROM users1 where ID='$ID'");	
														$operateur=mysql_result($req1,0);											
														$IDinventaire=$a['IDinventaire'];
														echo ('
                                                        <td style="width:20%;height:40px">'.$a['IDinventaire'].'</td>
														<td style="width:20%;height:40px">'.$a['dateI'].'</td>
														<td style="width:30%;height:40px">'.$operateur.'</td>
														<td style="width:20%;height:40px">'.$a['dateE'].'</td>');
														echo "<td style=\"width:10%;height:40px\">
														<input type=\"button\" onClick=afficheInfo('".$IDinventaire."'); Value=\">>\"></td>
                                                      
														
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