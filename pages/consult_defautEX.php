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

<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>


<title>
Liste des défauts
</title>
<script>

function afficheD(){

var d1 = document.getElementById("dateE").value;

$.ajax({
        type: 'POST',
        data: 'dateE='+d1,
        url: '../php/consult_defautEx.php',
        success: function(data) {
        $('#divDef').html(data);
		
       }});

   
}	   

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
}

elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}elseif($role=="QLT"){
include('../menu/menuQualite.php');	
}
else{

	 header('Location: ../deny.php');
}
?>
</div>
<?php
include('../connexion/connexionDB.php');
?>
<div id='contenu'>

<div class="container" >
<div id="page-wrapper">
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Total des défauts   </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>



<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
         Total defauts par expédition 
 </div>
 <div class="panel-body" >

<form method="post"  id="form1">
<div class="row">  
<div class="col-md-12"> 
<div class="form-group form-inline"> 
<label class="control-label " for="dateE">Date Expedition: </label>                 
<input id="dateE" name="dateE" type="date" class="form-control"> 
<input  type="button"  onClick="afficheD();" class="btn btn-default " id="b1" value=">>">
</div>
</div>
</div>
<div id="divDef">

	


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
