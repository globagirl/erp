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
		<title>Liste des demandes</title>
		<script>
		    function updateZone(){
			    var val = document.getElementById("recherche").value;
				if(val == "dateD"){
                    $('#zone').html('<input type="date" class="form-control" name="valeur" id="valeur"> ');
				}else if(val == "fournisseur"){
	                $('#zone').html('<select name="valeur" id="valeur" class="form-control"> <option value="s">---Selectionnez</option> </select> ');
					$.ajax({
					    type: 'POST',
                        url: '../php/listeFournisseur.php',
                        success: function(data) {
                            $('#valeur').html(data);
                    }});
	            }else{
                    $('#zone').html('<input type="text" class="form-control" name="valeur" id="valeur" placeholder="Search "> ');
	            }
			}
			//
			function afficheD(){
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;
                $.ajax({
                    type: 'POST',
					data: 'recherche='+recherche +'&valeur='+val ,
					url: '../php/consult_demande_prix.php',
					success: function(data) {
					    $('#tbody2').html(data);
                }});
            }
			//
			function print_demande(numD){
                $.ajax({
                   type: 'POST',
				           data: 'IDdemande='+numD,
				           url: '../tcpdf/demande_prix_article2.php',
				           success: function(data) {
				              document.location.href="../tcpdf/demande_prix_article2.php";
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
                            <h1 class="page-header">Demande de prix  </h1>
                        </div>
                    </div>
					<div class="row">
                        <div class="col-lg-12">
						    <div class="panel panel-default">
                                <div class="panel-heading"> Liste des demandes</div>
                                <div class="panel-body">
								    <form  id="form1" name="form1" action="" method="POST" target="_blank">
									    <div class="row">
										    <div class="pull-left col-lg-8">
											    <div class="form-group form-inline">

												    <select class="form-control" name="recherche" id="recherche" onChange="updateZone();">

														<option value="IDdemande">N° demande</option>
														<option value="fournisseur"> Fournisseur</option>
														<option value="IDarticle"> IDarticle</option>
														<option value="dateD">Date demande</option>

													</select>


                                                    <span id="zone"><input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Search "></span>

												    <input type="button" onClick="afficheD();" class="btn btn-primary" Value=">>">

												</div>

                                            </div>

											<br><br><br><br>
                                            <div class="table-responsive col-lg-12" id="divRel">
											    <table  class="table table-fixed table-bordered results" id="table3">
												    <thead style="width:100%">
			                                        <tr>
													<th style="width:9.8%;height:60px" class="degraD">N° demande</th>

													<th style="width:12.8%;height:60px" class="degraD">Fournisseur</th>
													<th style="width:21.8%;height:60px" class="degraD">Date demande</th>
				                                    <th style="width:14.8%;height:60px" class="degraD">Article</th>
													<th style="width:12.9%;height:60px" class="degraD">QTE</th>
													<th style="width:9.9%;height:60px" class="degraD">Devise</th>
													<th style="width:9.9%;height:60px" class="degraD">Terme pay</th>

													<th style="width:6.9%;height:60px" class="degraD"></th>
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													<?php
                                                    $x=0;
													$req=mysql_query("SELECT * FROM demande_prix");
													while($a=@mysql_fetch_array($req)){
	                                                    $IDdemande=$a['IDdemande'];
														$req2= mysql_query("SELECT IDarticle,qte FROM demande_prix_article where IDdemande='$IDdemande'");
														while($a1=@mysql_fetch_array($req2)){

														echo'<tr><td style="width:10%;height:60px;text-align:center;">'.$IDdemande.'</td>
										                <td style="width:23%;height:60px;text-align:center;">'.$a['fournisseur'].'</td>
										                <td style="width:12%;height:60px;text-align:center;">'.$a['dateD'].'</td>
										                <td style="width:15%;height:60px;text-align:center;">'.$a1['IDarticle'].'</td>
										                <td style="width:13%;height:60px;text-align:center;">'.$a1['qte'].'</td>
										                <td style="width:10%;height:60px;text-align:center;">'.$a['devise'].'</td>
										                <td style="width:10%;height:60px;text-align:center;">'.$a['termeP'].'</td>
										                ';
										                echo "<td style=\"width:7%;height:60px;text-align:center\">
														<img src=\"../image/print.png\" onclick=print_demande('".$IDdemande."'); style=\"cursor:pointer;\" target=\"_blank\" width=\"30\" height=\"30\"  />
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
