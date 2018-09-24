<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
}
?>
<html>
<head>
<meta charset="utf-8" />
<link href="../tablecloth/table.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>

<title>
Impression facture
</title>
<script>
function printFacture(){
		document.form1.action="../tcpdf/factu.php";
		document.form1.submit();
}
function excelFacture(){
	document.form1.action="../php/excel_facture.php";
    document.form1.submit(); 
}
function infoFacture(){
    var fact1 = document.getElementById("fact1").value;
				var fact2 = document.getElementById("fact2").value;
    var dateE = document.getElementById("dateE").value;
	   $.ajax({
      type: 'POST',
      data: 'fact1='+fact1+'&fact2='+fact2+'&dateE='+dateE,
      url: '../php/consult_facture_info.php',
      success: function(data) {
         bootbox.alert(data);
      }});
}
function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no'); 
}
</script>


</head>
<body>
<div id="entete">
<div id="logo">
</div>
<div id="boton">
<?php 
include('../include/logOutIMG.php');
?>	
</div>
</div>

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');	
}
elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}elseif($role=="CONS"){
    include('../menu/menuConsommable.php');	
}elseif($role=="FIN"){
    include('../menu/menuFinance.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<div class="container">
 <div id="page-wrapper">
  <div class="row">
   <div class="col-lg-12">
    <h1 class="page-header">Factures</h1>
   </div>
  </div>
  <div class="row">
   <div class="col-lg-12" >
    <div class="panel panel-default">
     <div class="panel-heading">
      Impression des factures
     </div>
     <div class="panel-body" >
      <form name="form1" id="form1" method="post" action="../tcpdf/log_plan_travail.php">
       <div class="row" >
        <div class="col-lg-1">
								   <img src="../image/consult.png" onclick="pop_up('../pages/pop_consult_facture.php');" alt="POP" style="cursor:pointer;" width="60" height="50"  />
							 </div>
        <div class="col-lg-8">								  
		       <div class="form-group" >
										 <label>Marge par N° facture </label>
											<div class="form-group form-inline" >
				       <input class="form-control" type="text" name="num_f_1" id="fact1" placeholder="From">                                          
				       <input class="form-control" type="text" name="num_f_2" id="fact2" placeholder="TO">
											</div>
				     </div>
									<div class="form-group" >   
				       <label>Date Expédition </label>
											<div class="form-group form-inline" >  
				       <input class="form-control" type="date" name="dateE" id="dateE">
											</div>
				     </div>
				     <div class="form-group" >
										  <input type="button" value="?" onclick="infoFacture()" class="btn btn-danger">
		          <input type="button" value="Imprimer >> " onclick="printFacture()" class="btn btn-primary">
												<input type="button" onclick="excelFacture()" value="Excel >> " class="btn btn-success">
					    </div>
        </div>
        	
		     </div>
      </form>
     </div>	
    </div>
   </div>
  </div><!--row-->
 </div>
</div>
</div>
</div>


 
 

</body>

</html>