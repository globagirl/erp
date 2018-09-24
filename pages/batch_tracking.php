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
Batch tracking
</title>
<script>

function afficheTrack(){
	
var item = document.getElementById("item").value;
var batch = document.getElementById("batch").value;



$.ajax({
        type: 'POST',
        data: 'item='+item+'&batch='+batch,
        url: '../php/batch_tracking.php',
        success: function(data) {
		if(data==0){
		bootbox.alert("check your item ID PLZ ");
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
                    <h1 class="page-header">Tracking  </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>



<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
         Batch tracking
 </div>
 <div class="panel-body" >

<form method="post"  id="form1">
<div class="row">  
         
                    
                   
                    <div class="col-md-12"> 
					 
					<div class="form-group col-md-6 form-inline"> 
                    
                    
					
                    <input id="item" name="item" type="text" class="col-md-4 form-control input-md" placeholder="Item ID "> 
                    <input id="batch" name="batch" type="text" class="col-md-4 form-control input-md" placeholder="Batch "> 
					 <input  type="button"  onClick="afficheTrack();" class="btn btn-default col-md-1" id="b1" value=">>">
                  </div>
					
                   
					
					 
                    </div>
      <br>
	<hr>
	<br>
	

<div class="col-md-12" id="div1">
                  
            <div class="row">
			<br>
                    <div class="col-lg-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Reception information
                        </div>
                       
                        <div class="panel-body">
						<div class="row">
	                    <div class="col-lg-12">
	                    <div class="col-lg-6">
                         Reception ID :
                        </div>
						<div class="col-lg-6">
                        -------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                         Shipment ID:
                        </div>
						<div class="col-lg-6">
                         ------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Reception date :
                        </div>
						<div class="col-lg-6">
                        -------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Supplier :
                        </div>
						<div class="col-lg-6">
                        ------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Quantity :
                        </div>
						<div class="col-lg-6">
                         -------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Boxs :
                        </div>
						<div class="col-lg-6">
                        -------
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        <hr>
                        </div>
						<div class="col-lg-6">
                         <hr>
                        </div>
						</div>
						
						
						
						</div>
						</div>
					</div>
                    </div>	
					<div class="col-lg-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Affected orders
                        </div>
                       
                        <div class="panel-body">
						<div class="row">
	                    <div class="col-lg-12">
	                    <div class="col-lg-3">
                         <b>Purchase order </b><hr>
                        </div>
						<div class="col-lg-3">
                         <b>date </b><hr>
                        </div>
						
	                    <div class="col-lg-2">
                         <b>QTY </b><hr>
                        </div>
						<div class="col-lg-4">
                         <b> Paquet</b><hr>
                        </div>
						</div>
						 <div class="col-lg-12">
	                    <div class="col-lg-3">
                         ---------- 
                        </div>
						<div class="col-lg-3">
                         -------- 
                        </div>
						
	                    <div class="col-lg-2">
                         ----- 
                        </div>
						<div class="col-lg-4">
                          ----------
                        </div>
						</div>
						</div>
						</div>
					</div>
                    </div>
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
