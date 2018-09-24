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
Auto-creation BL 
</title>
<script>

function addBL(){

		
 var valeur = document.getElementById("dateE").value;
 if(valeur==""){
	  bootbox.alert("Donnez la date d'expédition  SVP !!");

 }
 else{
	$.ajax({
			url: '../php/ajout_BL_auto.php',
			type: 'POST',
			data: "dateE="+valeur,
			success:function(data){
				if(data==0){
				 bootbox.alert("Vérifier  la date d'expédition  SVP !!");
				}else{
				$('#OFD').html(data);
				}
			}});
 }
}
//Fichier excel
function excelBL(){

	document.form1.action="../php/excel_BL_auto.php";
    document.form1.submit(); 

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
                    <h1 class="page-header">Bon de livraison  </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>
<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
       Auto-creation BL 
 </div>
 <div class="panel-body" >
     <form role="form" method="post" name="form1" id="form1">
  <div class="row">
  
                                <div class="col-lg-12">
                                <div class="col-lg-6">
                                
                                        <div class="form-group">
                                             <label>Date expédition</label>
											 <div class="form-inline">
                                            <input class="form-control" id="dateE" name="dateE" type="date" >
                                            <button type="button" class="btn btn-default blue" onclick="addBL();">>> </button>
											</div>
                                        </div>
										
									
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