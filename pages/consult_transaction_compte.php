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
		<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<title>Transaction compte</title>
		<script>
		
		    function mySearch() {
			    var searchTerm = $(".search").val();
				searchTerm=searchTerm.toUpperCase();
				var jobCount = $('.results tbody').children('tr').length;
				for (var iter = 1; iter <= jobCount; iter++) {
				    var nIter1="."+iter;
					var val=$(nIter1).html();
					//var val=document.getElementsByClassName(iter).innerHTML;
					val=val.toUpperCase();
					if (val.indexOf(searchTerm) >= 0){
					    $(nIter1).attr('visible','true');
                    }else{
                        $(nIter1).attr('visible','false');
                    }
                }
            }
			function mySearch2() {
			  if($('#E1').is(':checked')){
				    //var searchTerm="ALL";
					$(".R").attr('visible','true');
					$(".AT").attr('visible','true');
					$(".AN").attr('visible','true');
				}else if($('#E2').is(':checked')){
				    //var searchTerm="AT";
					$(".R").attr('visible','false');
					$(".AT").attr('visible','true');
					$(".AN").attr('visible','false');
				}else if($('#E3').is(':checked')){
				    //var searchTerm="AN";
					$(".R").attr('visible','false');
					$(".AT").attr('visible','false');
					$(".AN").attr('visible','true');
				}

            }
            //

			function afficheTrans(){
			    $('#divRel').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
                var compte = document.getElementById("compte").value;

				//alert (statut);
                $.ajax({
                    type: 'POST',
                    data: 'compte='+compte,
                    url: '../php/consult_transaction_compte.php',
                    success: function(data) {
                        $('#divRel').html(data);
                }});
            }
			//
			function transPass(T){
			  if(confirm("Voulez vous vraiment passer le chéque ?!")){
			    var compte = document.getElementById("compte").value;
                $.ajax({
                    type: 'POST',
                    data: 'IDtrans='+T,
                    url: '../php/transactionPass.php',
                    success: function(data) {
                        afficheTrans();
                }});

              }
            }
			////
			function transAnnule(T){
			  if(confirm("Voulez vous vraiment annuler la transaction ?!")){
			    var compte = document.getElementById("compte").value;
                $.ajax({
                    type: 'POST',
                    data: 'IDtrans='+T+'&compte='+compte,
                    url: '../php/transactionAnnule.php',
                    success: function(data) {
                        afficheTrans();
                }});
	          }
            }
			//
            function updateTrans(idTrans){
			    var montant = prompt("Entrer le nouveau montant  SVP :");
				if (montant != null) {
      				$.ajax({
					    type: 'POST',
						data:'idTrans='+idTrans+'&montant='+montant,
						url: '../php/update_transaction.php',
                        success: function(data) {
                            afficheTrans();
                     }});
                }
			}
			//
			function transDelete(T){
			  if(confirm("Voulez vous vraiment supprimer la transaction ?!")){
			    var compte = document.getElementById("compte").value;
                $.ajax({
                    type: 'POST',
                    data: 'IDtrans='+T+'&compte='+compte,
                    url: '../php/transactionDelete.php',
                    success: function(data) {
                        afficheTrans();
                }});
	          }
			}
			
			//
			function updateTransRef(idTrans){
			    var ref = prompt("Entrer la nouvelle reference SVP :");
				if (ref != null) {
      				$.ajax({
					    type: 'POST',
						data:'idTrans='+idTrans+'&ref='+ref,
						url: '../php/update_transaction_ref.php',
                        success: function(data) {         
                            afficheTrans();
                     }});
                }
			}
			//redirection
			function redir_ajout_trans(){
                 window.location.href = "../pages/ajout_transaction.php";
            }
            function excelTransaction(){
			document.form1.action="../php/excel_consult_transaction.php";
			document.form1.submit();
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
				}else if($role=="DIR"){
				    include('../menu/menuDirecteur.php');
				}elseif($role=="FIN"){
				    include('../menu/menuFinance.php');
				}elseif($role=="GRH"){
				    include('../menu/menuGRH.php');
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
                            <h1 class="page-header">Transaction  </h1>
                        </div>
                    <!--</div>-->
					<!--<div class="row">-->
                        <div class="col-md-12">
						    <div class="panel panel-default">
                                <div class="panel-heading"> Transaction des comptes </div>
                                <div class="panel-body">
								    <form  id="form1" name="form1" method="POST">
									    <div class="row">
										    <div class="col-md-12">
											    <div class="form-group form-inline " >
                            <select class="form-control" id="compte" name="compte">
					                                    <?php
						                                    $q2 = mysql_query("SELECT * FROM compte_banque");
                                                echo '<option value="S">Selectionnez un compte...</option>';
															while($data2=mysql_fetch_array($q2)) {
							                                    echo '<option value="'.$data2["REFcompte"].'">'.$data2["REFcompte"].'</option>';
                                                }
                                                mysql_close();
                                                ?>
					                  </select>
													  <input type="button" onClick="afficheTrans();" class="btn btn-default blue" Value="Consult >> ">
													<input type="button" onClick="excelTransaction();" class="btn btn-danger" Value="Excel >> ">
			                    </div>



                                            </div>
											<br><br><br><br>
                                            <div class="col-md-12">
                                                <div class="table-responsive" id="divRel"></div>
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
