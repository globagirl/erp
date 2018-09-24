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
Ajout Ordre Fabrication
</title>
<script>

function afficheStock(){		
 var art = document.getElementById("art").value;
 if(art==""){
	  bootbox.alert("Donner le code article svp !!");

 }else{	
	$.ajax({
			url: '../php/update_stock_article.php',
			type: 'POST',
			data: "art="+art,
			success:function(data){
				if(data != 0){
				$('#OFD').html(data);
				}else{
				bootbox.alert("Vérifier votre code article SVP !!");
				}
			}});
	//
	
 }
}



//////////////
function desactiveEnter(){ 
 if (event.keyCode == 13) { 
      event.keyCode = 0; 
      window.event.returnValue = false; 
 } 
} 	  
	
</script>



</head>


<body onKeyDown="desactiveEnter()">
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
                    <h1 class="page-header">Stock article </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>


<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          Mise a jour stock
 </div>
 <div class="panel-body" >
     <form role="form" method="post" name="form1" action="../php/ajout_ordre_fabrication.php">
  <div class="row">
                                <div class="col-lg-6">
                                
                                        <div class="form-group form-inline">
                                            
                                            <input class="form-control" id="art" name="art" placeholder="Article">
                                            <button type="button" class="btn btn-default" onclick="afficheStock()">>> </button>
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