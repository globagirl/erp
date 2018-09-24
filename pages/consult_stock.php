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
		<script type='text/javascript' src="../include/scripts/consult_bande_sortie.js"></script>
		<script>
		    function affiche_sortie(){
			    //alert ("hhhhhh");
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;
				var statut = document.querySelector('input[name=statut]:checked').value;
                var dateA = document.getElementById("dateA").value;
                $.ajax({
                    type: 'POST',
                    data: 'valeur='+val+'&recherche='+recherche+'&statut='+statut+'&dateA='+dateA,
                    url: '../php/consult_stock.php',
                    success: function(data) {
                        $('#tbody2').html(data);
                }});

            }
            //
            function afficheZone(){
		        var recherche = document.getElementById("recherche").value;
                if (recherche=="typeA"){
                    $('#zone').html('<select name="valeur" id="valeur" class="form-control" ></select>');
                    $.ajax({
                       type: 'POST',
                       url: '../php/liste_typeA.php',
                       success: function(data) {
                        $('#valeur').html(data);
                    }});
                }else if (recherche=="supplier"){
                    $('#zone').html('<select name="valeur" id="valeur" class="form-control" ></select>');
                    $.ajax({
                        type: 'POST',
                        url: '../php/listeFournisseur.php',
                        success: function(data) {
                            $('#valeur').html(data);
                        }});

                }else if (recherche=="catA"){

	                $('#zone').html('<select name="valeur" id="valeur" class="form-control" ><option value="Consumable">Consommable</option><option value="Production">Production</option> </select> ');


                }else{
                    $('#zone').html('<input type="text" id="valeur" name="valeur" class="form-control" > ');
                }
            }
            //Affiche paquet
            function affichePaquet(article){
                $.ajax({
                    type: 'POST',
                    data: 'article='+article,
                    url: '../php/consult_stock_paquet.php',
                    success: function(data) {
                       bootbox.alert(data);
                }});
            }
            function stock_excel(){
                document.form1.action="../php/excel_consult_stock.php";
                document.form1.submit();
            }
		</script>
		<title>Consult stock</title>


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
                }else if($role=="COM"){
                    include('../menu/menuCommercial.php');
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
                            <h1 class="page-header">STOCK </h1>
                        </div>
                    </div>
					<div class="row">
                       <!-- <div class="col-md-12">-->
						    <div class="panel panel-default">
                                <div class="panel-heading"> Stock magazin</div>
                                <div class="panel-body">
								    <form  id="form1" name="form1" method="POST">
									    <div class="row">
										    <div class="pull-left col-md-6">

												<div class="form-group form-inline col-md-12">
												    <select class="form-control" name="recherche" id="recherche" onChange="afficheZone();">
													    <option value="a"> ALL</option>
                                                        <option value="code_article"> Article</option>
														<option value="supplier"> Fournisseur</option>
														<option value="typeA">Type article </option>
														<option value="catA">category  </option>

													</select>
                                                    <span id="zone">
                                                        <input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Search ">
												    </span>
												</div>
												<div  class="form-group col-md-6">
												    <label>Date antérieur :</label>
												    <input type="date" class="search form-control" name="dateA" id="dateA" >

												</div>
											    <div  class="form-group col-md-12">
												    <input type="button" onClick="affiche_sortie();" class="btn btn-primary" Value=">>>">
												    <input type="button" onClick="stock_excel();" class="btn btn-danger" Value="Excel >>">
												</div>

                                            </div>
												<div class="pull-left col-md-6">
												<div class="form-group">
												    <div class="radio">
                                                        <label><input type="radio" name="statut" id="S1" value="ALL" checked>ALL </label>
													</div>
													<div class="radio">
                                                        <label><input type="radio" name="statut" id="S2" value="NN">Non Null</label>
													</div>
													<div class="radio">
                                                        <label><input type="radio" name="statut" id="S3" value="N">Null</label>
													</div>


                                                </div>

												</div>

											<div class="col-md-12">
                                              <div class="table-responsive" id="divRel">
											    <table  class="table  table-striped table-bordered table-hover" id="table3">
												    <thead style="width:100%">
			                                        <tr>
													<th style="width:14.8%;height:60px" class="degraD">Article</th>
													<th style="width:19.8%;height:60px" class="degraD">Description</th>
                                                    <th style="width:14.8%;height:60px" class="degraD">Fournisseur</th>
													<th style="width:14.8%;height:60px" class="degraD">Stock réel</th>
													<th style="width:14.8%;height:60px" class="degraD">Stock antérieur</th>
                                                    <th style="width:14.8%;height:60px" class="degraD">Total Paquet</th>
										            <th style="width:14.8%;height:60px" class="degraD">Stock Rebut</th>
													<th style="width:4.9%;height:60px" class="degraD"></th>

			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													<?php
                                                    include('../include/functions/consult_stock_functions.php');
													$req= mysql_query("SELECT code_article,description,stock,stock_rebut,supplier,unit,catA FROM article1 ");
													while($a=mysql_fetch_array($req)){
	                                                    $dateA="";
                                                        affiche_ligne($a,$dateA);
                                                    }
                                                    ?>
                                                    </tbody>
												</table>
											</div>
										  </div>
                                       </div> <!--Fin row-->
                                    </form>
                                </div>
                            </div>
                        <!--</div> -->
                    </div><!-- row 2 fin -->
				</div>
            </div>
        </div>
    </div>
    </body>
</html>
