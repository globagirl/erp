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
		<script src="../jquery/jquery.dataTable.min.js"></script>
		<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
		<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
		<link rel="stylesheet" href="../jquery/jquery.dataTables.min.css" type="text/css" />
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
		<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
		<script src="../bootstrap/js/bootbox.min.js"></script>
		<title>Facture echantillant</title>
		<script>
        $(document).ready(function() {
            $('#samplesTable').DataTable({
                responsive: true
            });
        });
    </script>
		<script>

			function afficheF(){
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
          var val = document.getElementById("valeur").value;
				  var recherche = document.getElementById("recherche").value;
          $.ajax({
              type: 'POST',
					    data: 'recherche='+recherche +'&valeur='+val ,
					    url: '../php/consult_facture_echantillant.php',
					    success: function(data) {
					      $('#tbody2').html(data);
              }});
      }
			//
			function print_facture(numF){
                $.ajax({
                   type: 'POST',
				           data: 'IDfact='+numF,
				           url: '../tcpdf/facture_echantillant2.php',
				           success: function(data) {
				              document.location.href="../tcpdf/facture_echantillant2.php";
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
                            <h1 class="page-header">Facture echantillant </h1>
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
												    <select class="form-control" name="recherche" id="recherche">
														<option value="IDdemande">N° facture</option>
														<option value="IDproduit"> Produit</option>
                          	</select>
                            <span id="zone"><input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Search "></span>
												    <input type="button" onClick="afficheD();" class="btn btn-primary" Value=">>">
												 </div>
                       </div>
                       <br><br><br><br>
                       <div class="table-responsive col-lg-12" id="divRel">
							<table   width="100%" class="table table-striped table-bordered table-hover" id="samplesTable" >
												    <thead style="width:100%">
			                         <tr>
													     <th style="width:9.8%;height:60px" class="degraD">N° demande</th>
                               <th style="width:24.8%;height:60px" class="degraD">Client</th>
                               <th style="width:19.8%;height:60px" class="degraD">Produit</th>
                               <th style="width:9.9%;height:60px" class="degraD">QTY</th>
                               <th style="width:7.9%;height:60px" class="degraD">Devise</th>
                                <th style="width:9.9%;height:60px" class="degraD">Terme</th>
                                 <th style="width:9.9%;height:60px" class="degraD">Montant</th>
                               <th style="width:6.9%;height:60px" class="degraD"></th>

			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													<?php
                              $x=0;
                              $req= mysql_query("SELECT * FROM facture_echantillon_item LIMIT 200");
														  while($a1=@mysql_fetch_array($req)){
                                    $IDfact=$a1['IDfact'];
                                    $req2=mysql_query("SELECT * FROM facture_echantillon where numFact='$IDfact'");
                                    $a2=@mysql_fetch_array($req2);
														        echo'<tr><td style="width:10%;height:60px;text-align:center;">'.$IDfact.'</td>
										                <td style="width:25%;height:60px;text-align:center;">'.$a2['client'].'</td>
										                <td style="width:20%;height:60px;text-align:center;">'.$a1['IDproduit'].'</td>
										                <td style="width:10%;height:60px;text-align:center;">'.$a1['qty'].'</td>
										                <td style="width:8%;height:60px;text-align:center;">'.$a2['devise'].'</td>
                                    <td style="width:10%;height:60px;text-align:center;">'.$a2['termeP'].'</td>
                                    <td style="width:10%;height:60px;text-align:center;">'.$a2['montant'].'</td>
                                    ';
										                echo "<td style=\"width:7%;height:60px;text-align:center\">
														       <img src=\"../image/print.png\" onclick=print_facture('".$IDfact."'); style=\"cursor:pointer;\" target=\"_blank\" width=\"30\" height=\"30\"  />
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
