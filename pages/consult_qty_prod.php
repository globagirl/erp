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

<!--<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />-->
<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<link rel="stylesheet" type="text/css" href="../css/starz_tab.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>
<title>
Quantité produite
</title>
<SCRIPT> 
function afficheQty(){

var val = document.getElementById("valeur").value;
var recherche = document.getElementById("recherche").value;


$.ajax({
        type: 'POST',
        data: 'valeur='+val+'&recherche='+recherche,
        url: '../php/consult_qty_prod.php',
        success: function(data) {
        $('#OFD').html(data);
       }});
	  
}
function updateZone(){

var val = document.getElementById("recherche").value;
if(val != "date_exped_conf"){      
   document.getElementById("valeur").type="text";
   document.getElementById("valeur").value="";
}else{
    
    document.getElementById("valeur").type="date";
	document.getElementById("valeur").value="";
	
}
	  
}
//
function excelQtyProd(){
	document.form1.action="../php/excel_qty_prod.php";
    document.form1.submit(); 
}

</SCRIPT> 
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
elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<div class="container" >
<div id="page-wrapper">
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Produced quantity  </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>

<?php
include('../connexion/connexionDB.php');
?>


<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
        Consult produced quantity 
 </div>
 <div class="panel-body" >
     <form role="form" method="post" name="form1" id="form1">
  <div class="row">
  <p style="float:right">
<img src="../image/excel.png" onclick="excelQtyProd();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p>
                                <div class="col-lg-6">
                                
                                       <div class="form-group form-inline">
												    <select class="form-control" name="recherche" id="recherche" onChange="updateZone();">     
													    <option value="date_exped_conf">Shipping date</option>
														<option value="OF">OF</option>
														<option value="PO">PO</option>                                              
													    
													</select>
                                                    <input type="date" class="form-control" name="valeur" id="valeur">
												    <input type="button" onClick="afficheQty();" class="btn btn-danger" Value=">>">
												</div>
										
									
										</div>
										</div>



<div id="OFD"></div>
	</form>



</div>
</div>
</div>
</div>
</div>

</div>





</body>

</html>