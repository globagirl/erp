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
imprimer OF
</title>
<script>

function printEN(){
		document.form1.action="../tcpdf/plan_travailEN.php";
		document.form1.submit();
}
function printFR(){
		document.form1.action="../tcpdf/plan_travailFR.php";
		document.form1.submit();
}


function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no') 
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
elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
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
                    <h1 class="page-header">Manufacturing orders </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>



<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
         Print Manufacturing orders     
 </div>
 <div class="panel-body" >
 <div class="row">
  <form name="form1" id="form1" method="post" action="../tcpdf/log_plan_travail.php">
          <div class="col-lg-12" >
		  
		  <div class="col-lg-9">
		 
		   <!--<input href="#" onclick="pop_up('../pages/pop_consult_OF.php');" type="button" value="Liste des OF" class="btn btn-default">-->
		   <br>
                  <div class="form-group form-inline" >
				    <img src="../image/consult.png" onclick="pop_up('../pages/pop_consult_OF.php');" alt="Excel" style="cursor:pointer;" width="60" height="50"  />
				  <input class="form-control" type="text" name="num_of1" placeholder="From">                                          
				  <input class="form-control" type="text" name="num_of2" placeholder="TO">                                          
				  </div>
				 
		
		<input type="button" value="Print FR" onclick="printFR()" class="btn btn-default">
		<input type="button" onclick="printEN()" value="Print EN" class="btn btn-default">
		<br>
		<br>
		
		</div>
		</div>
</form>
</div>		


</div>

</div>

</body>

</html>