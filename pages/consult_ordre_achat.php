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
		<title>Consulter Ordre d'achat</title>
		<script>
		//Auto complete
		function autoComplete(){
		var liste = document.getElementById('recherche');
		var R = liste.options[liste.selectedIndex].value;
		var c="valeur";
		var l="liste1";
		if(R=="IDarticle"){
		var zoneC="#"+c;
		var zoneL="#"+l;
		var min_length =1; 
		var keyword = $(zoneC).val();
		if (keyword.length >= min_length) {
	
		$.ajax({
			url: '../php/auto_liste_article.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC+"&R="+R,
			success:function(data){
				$(zoneL).show();
				$(zoneL).html(data);
			}});
	    }else {
		$(zoneL).hide();
	   }
	   }//fin si
       }
       ///
	   function hideListe() {	   
	   var l="liste1";
	   var zoneL="#"+l;
	   $(zoneL).hide();
	   }
	   
	   function choixListe(p,z) {
	   
	   var ch=p.replace("|"," ");
	   var ch=ch.replace("|"," ");
	   var ch=ch.replace("|"," ");
	   $(z).val(ch);
	
       }
		
		
		
		///
		    function updateZone(){
			  var liste = document.getElementById('recherche');
              var recherche = liste.options[liste.selectedIndex].value;
			  if(recherche != "fournisseur"){
                 $('#zone').html('<input type="text" id="valeur" class="form-control" name="valeur" onBlur="hideListe();" onKeyup="autoComplete();" onFocus="autoComplete()"><div class="divAuto2"><ul id="liste1" ></ul></div> ');
             }else{
		         $('#zone').html('<select name="valeur" id="valeur"  class="form-control"><option value="s">---Selectionnez</option> </select> ');
				 $.ajax({
                   type: 'POST',
				   url: '../php/listeFournisseur.php',
				   success: function(data) {
                   $('#valeur').html(data);
                 }});
	   
            }
			}
			//
			function afficheOA(){
			    $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var val = document.getElementById("valeur").value;
				var recherche = document.getElementById("recherche").value;
				var recherche1 = document.getElementById("recherche1").value;
				var date1 = document.getElementById("date1").value;
				var date2 = document.getElementById("date2").value;
                if($('#S1').is(':checked')){
				    var statut="A";
				}else if($('#S2').is(':checked')){
				    var statut="waiting";
				}else if($('#S3').is(':checked')){
				    var statut="incomplete";
				}else if($('#S4').is(':checked')){
				    var statut="received";
				}
				
             $.ajax({
              type: 'POST',
              data: 'valeur='+val+'&recherche='+recherche+'&statut='+statut+'&recherche1='+recherche1+'&date1='+date1+'&date2='+date2,
                    url: '../php/consult_ordre_achat.php',
                    success: function(data) {
                        $('#tbody2').html(data);
                }});
				
	  
            }
			//
			function excelOA(){      
	           document.form1.action="../php/excel_consult_OA.php";
			   document.form1.submit(); 
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
                            <h1 class="page-header">Bon d'achat </h1>
                        </div>           
                    </div>
					<div class="row">
                        <div class="col-md-12">
						    <div class="panel panel-default">
                                <div class="panel-heading"> Consult bon d'achat </div>
                                <div class="panel-body">
								    <form  id="form1" name="form1" method="POST">
									    <div class="row">
										    <div class="well col-md-12">	
											    <div class="form-group">
												    <div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S1" value="A" checked>ALL </label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S2" value="waiting">En attente </label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S3" value="incomplete">Incompléte </label>
													</div>
													<div class="radio-inline">
                                                        <label><input type="radio" name="statut" id="S4" value="received">Reçue</label>
													</div>
             
                                                </div>											
												<div class="form-group form-inline">
												    <select class="form-control" name="recherche" id="recherche" onChange="updateZone();">     
													    <option value="IDordre">N° ordre</option>
														<option value="IDarticle">Article</option>
														<option value="fournisseur">Fournisseur</option>
													</select>
													<span id="zone">
                                                      <input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Search " onBlur="hideListe();" onKeyup="autoComplete(); " onFocus="autoComplete()">
													  <div class="divAuto2"><ul id="liste1" ></ul></div>
												   </span>
												</div>
												<div class="form-group form-inline">
												    <select class="form-control" name="recherche1" id="recherche1">     
													    <option value="dateR">Date reception</option>
													    <!--<option value="date_creation">Date entrée </option>
													    <option value="date_demand_starz">Date demande </option>-->
													
														
													</select>
                                                    <input type="date" class="form-control" name="date1" id="date1">
                                                    <input type="date" class="form-control" name="date2" id="date2">
												   
												</div>
												
												<div class="form-group">	                                        
												    <input type="button" onClick="afficheOA();" class="btn btn-primary" Value="Consult >>">
													<input type="button" onClick="excelOA();" class="btn btn-danger" Value="Excel >>">
												</div>
                                            </div>
										
                                            <div class="col-md-12">
                                            <div class="table-responsive" id="divRel">
											    <table  class="table table-fixed  results" id="table3">
												    <thead style="width:100%">       
			                                        <tr>
													<th style="width:6.8%;height:60px;text-align:center" >Order N°</th>
													<th style="width:18.8%;height:60px;text-align:center">Fournisseur</th>
													<th style="width:13.8%;height:60px;text-align:center">Article</th>	
													<th style="width:9.9%;height:60px;text-align:center">QTE demand</th>
													<th style="width:9.9%;height:60px;text-align:center">QTE reçue</th>
													<th style="width:10%;height:60px;text-align:center">Reception</th>
													<th style="width:9.9%;height:60px;text-align:center">Prix unitaire</th>
													<th style="width:9.9%;height:60px;text-align:center" >Total</th>
													<th style="width:8.9%;height:60px;text-align:center">Statut</th>		  
			                                        </tr>
												    </thead>
													<tbody id="tbody2" style="width:100%">
													<?php
													 //Les fonction a utiliser 
													 function afficheLigne($IDordre,$four,$art,$qteD,$qteR,$dateR,$prixU,$stat){    $prixT=$prixU*$qteR;
													     echo('<tr>
													     <td style="width:6.6%;height:60px;text-align:center" class="tdTab">'.$IDordre.'</td>
													     <td  style="width:19%;height:60px;text-align:center">'.$four.'</td>
													     <td  style="width:14.1%;height:60px;text-align:center">'.$art.'</td>
													     <td style="width:10%;height:60px;text-align:center">'.$qteD.'</td>
													     <td style="width:10.1%;height:60px;text-align:center">'.$qteR.'</td>
													     <td style="width:10.1%;height:60px;text-align:center">'.$dateR.'</td>
													     <td style="width:10.1%;height:60px;text-align:center">'.$prixU.'</td>
													     <td style="width:10%;height:60px;text-align:center">'.$prixT.'</td>
													     <td style="width:9%;height:60px;text-align:center">'.$stat.'</td>
													     </tr>');
													}
 
 
                                                     $req= mysql_query("SELECT * FROM ordre_achat_article1  order by IDordre DESC LIMIT 100");
													 
													 while($a=@mysql_fetch_array($req)){
													 $IDordre =$a['IDordre'];
													 $statut =$a['statut'];
													 $IDarticle=$a['IDarticle'];
													 $qteD =$a['qte_demande'];
													 $prixU =$a['prix_unitaire'];
													 $qteR =$a['qte_recue'];
													 $dateR =$a['dateR'];
													 $req1= mysql_query("SELECT fournisseur FROM ordre_achat2 where IDordre='$IDordre'");
													 $fournisseur=mysql_result($req1,0);
													 afficheLigne($IDordre,$fournisseur,$IDarticle,$qteD,$qteR,$dateR,$prixU,$statut);
													 if($statut != 'waiting'){
													 $req2= mysql_query("SELECT IDreception,qty,status FROM reception_items where IDorder='$IDordre' and item='$IDarticle'");
													 // if(mysql_num_rows($req2)>1){
													 while($a2=mysql_fetch_array($req2)){
													 $IDreception=$a2['IDreception'];
													 $qteR=$a2['qty'];
													 $stat=$a2['status'];
													 $req3= mysql_query("SELECT dateR FROM reception where IDreception='$IDreception'");
													 $dateR=@mysql_result($req3,0);
													 $val="--";
													 afficheLigne($val,$val,$val,$val,$qteR,$dateR,$prixU,$stat);
													 //}
													 }
													 }
													 }
													 mysql_close();
                                                    ?>
                                                    </tbody>
												</table>
											</div> 
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