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
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
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
Report
</title>
<script>

function afficheGE(){
	
var PO = document.getElementById("PO").value;



$.ajax({
        type: 'POST',
        data: 'PO='+PO,
        url: '../php/rapport_poGeneral.php',
        success: function(data) {
		if(data==0){
		bootbox.alert("check your purchase order number PLZ ");
		}else{
        $('#div1').html(data);
		}
       }});
	   
}	
//
   

////

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
}else if($role=="LOG"){
include('../menu/menuLogistique.php');	
}else if($role=="COM"){
    include('../menu/menuCommercial.php');	
}else if($role=="QLT"){
    include('../menu/menuQualite.php');	
}else{
header('Location: ../deny.php');
}
?>
</div>

<div id='contenu'>

<div class="container" >
<div id="page-wrapper">
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Report  </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>



<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          Purshase order report
 </div>
 <div class="panel-body" >

<form method="post"  id="form1">
<div class="row">  
         
                    
                   
                    <div class="col-md-12"> 
					 
					<div class="form-group col-md-6 form-inline"> 
                    
                    
					
                    <input id="PO" name="PO" type="text" class="col-md-4 form-control input-md" placeholder="Purshase order "> 
					 <input  type="button"  onClick="afficheGE();" class="btn btn-default col-md-1" id="b1" value=">>">
                  </div>
					
                   
					
					 
                    </div>
      <br>
	<hr>
	<br>
	

<div class="col-md-12" id="div1">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#GE" data-toggle="tab">General </a>
                                </li>
                                <li><a href="#mag" data-toggle="tab" >Used materiel</a>
                                </li>
                                <li><a href="#man" data-toggle="tab" >Manufacturing</a>
                                </li>
                               
                            </ul>

         <div class="tab-content" id="general">
         <div class="tab-pane fade in active" id="GE">
            <div class="row">
			<br>
                    <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Commercial information
                        </div>
                       
                        <div class="panel-body">
						<div class="row">
	                    <div class="col-lg-12">
	                    <div class="col-lg-6">
                         Purshase order N° :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                         Product :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Quantity :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Amount :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Creation date :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Shipping date :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Invoice date :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div><div class="col-lg-12">
	                    <div class="col-lg-6">
                        BL N°:
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div><div class="col-lg-12">
	                    <div class="col-lg-6">
                        Invoice N° :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div>
						</div>
						
						
						
						</div>
					</div>
                    </div>	
					<div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Manufacturing information
                        </div>
                       
                        <div class="panel-body">
						<div class="row">
	                    <div class="col-lg-12">
	                    <div class="col-lg-6">
                         Manufacturing order N° :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                         WorkPlans :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Quantity :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Release date :
                        </div>
						<div class="col-lg-6">
                         --------
                        </div>
						</div>
						</div>
						</div>
					</div>
                    </div>
             </div>					
         </div>
                                <div class="tab-pane fade" id="mag" >
                                  
                                    
                                </div>
                                <div class="tab-pane fade" id="man">
                                   
                                </div>
                                
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
</body>
</html>
