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
		<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
		<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
		<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
		<link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
		<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
		<script src="../bootstrap/js/bootbox.min.js"></script>
		<title>Gestion carton</title>
		<script>
		
			//
			function afficheCart(){
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;
				$.ajax({
                  type: 'POST',
                  data: 'valeur='+val+'&recherche='+recherche,
                  url: '../php/gestion_carton.php',
                  success: function(data) {
                        $('#tbody2').html(data);
                }});
			
            }
			//
			function printCarton(){      
	           document.form1.action="../tcpdf/label_paquet_print.php";
			   document.form1.submit(); 
			   }
            //
            function printCartonNV(){      
	           document.form1.action="../tcpdf/label_paquet2_print.php";
			   document.form1.submit(); 
			   }
            //
			function deleteCarton(){
              if(confirm("Voulez vous vraiment supprimer ces paquets ?!!")){
                var valeurs = [];
                $("input:checked[name!=checkALL]").each(function (box) {
                    valeurs.push($(this).val());
                });
	            $.ajax({
                  type: 'POST',
                  data: 'IDcartonT='+valeurs,
                  url: '../php/gestion_carton_delete.php',
                  success: function(data) {
                       //bootbox.alert(data);
                       afficheCart();
                }});
              }
			}
            //
			function checkAllCart(){ 
               if($('#checkALL').prop('checked')){
                   $('input:checkbox').prop('checked',true);  
               }else{			
	               $('input:checkbox').prop('checked',false);   
			   }
            }//

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
                }else if($role=="FIN"){
                    include('../menu/menuFinance.php');	
                }else if($role=="CONS"){
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
                            <h1 class="page-header">Carton </h1>
                        </div>           
                    </div>
					<div class="row">
                        <div class="col-md-12">
						    <div class="panel panel-default">
                                <div class="panel-heading"> Consult carton</div>
                                <div class="panel-body">
								    <form  id="form1" name="form1" method="POST" target="_blank">
									    <div class="row">
										    <div class="col-md-12">	
										      <div class="well">	
											    										
												<div class="form-group form-inline">
												    <select class="form-control" name="recherche" id="recherche">     
													    <option value="X">Carton libre</option>
														<option value="IDpalette">Palette</option>
														<option value="PO">PO</option>
														<option value="IDproduit">Produit</option>
														<option value="OF">OF</option>
														<option value="IDcarton">ID carton</option>
													</select>
													
                                                    <input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Search ">  
												 
												   <input type="button" onClick="afficheCart();" class="btn btn-primary" Value="Consult >>">
												</div>
												
												
												                                        
												    
												
                                            </div>
                                           </div>
										
                                            <div class="col-md-10">
                                            <div class="table-responsive" id="divRel">
											    <table  class="table table-fixed  results" id="table3">
												    <thead style="width:100%">       
			                                        <tr>
													<th style="width:4.8%;height:60px;text-align:center" >
                                                        <input type="checkbox" name="checkALL" id="checkALL" onClick="checkAllCart();"></th>
													<th style="width:14.8%;height:60px;text-align:center">ID carton</th>
													<th style="width:19.8%;height:60px;text-align:center">PO</th>	
													<th style="width:14.9%;height:60px;text-align:center">OF</th>
													<th style="width:14.9%;height:60px;text-align:center">Produit</th>
													<th style="width:9.9%;height:60px;text-align:center">Qte</th>
													<th style="width:19.9%;height:60px;text-align:center">Palette</th>
														  
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													<?php
                                                     $req= mysql_query("SELECT * FROM carton_palette where IDpalette='X'");
													
													 while($a=@mysql_fetch_array($req)){
												
													 $IDcart =$a['IDcarton'];  
													
													 
													 echo('<tr>
													 <td style="width:5%;height:60px;text-align:center">
													 <input type="checkbox" name="IDcarton[]" value='.$IDcart.'>
													 </td> 
													 <td style="width:15%;height:60px;text-align:center">'.$IDcart.'</td>
													 <td  style="width:19%;height:60px;text-align:center">'.$a['PO'].'</td>
													 <td  style="width:15%;height:60px;text-align:center">'.$a['OF'].'</td>
													 <td style="width:15%;height:60px;text-align:center">'.$a['IDproduit'].'</td>
													 <td style="width:10%;height:60px;text-align:center">'.$a['qte'].'</td>
													 <td style="width:20%;height:60px;text-align:center">'.$a['IDpalette'].'</td>
													 
													 </tr>');
													 }
													 mysql_close();
                                                    ?>
                                                    </tbody>
												</table>
											</div> 
											</div> 
											<div class="col-md-2">
											
											<button type="button" onClick="deleteCarton();" class="btn btn-danger  btn-block">Supprimer</button>
											<button type="button" onClick="libreCart();" class="btn btn-primary btn-block">Libérer</button>
											<button type="button" onClick="printCarton();" class="btn btn-success btn-block">Imprimer</button>
											<button type="button" onClick="printCartonNV();" class="btn btn-warning btn-block">Nouveau produit</button>
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