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
Print planning
</title>

<SCRIPT>


function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no') 
}
function excelPlanning(){
	document.form1.action="../php/excel_planning.php";
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
                    <h1 class="page-header">Planning </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>



<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
        Print planning  
 </div>
 <div class="panel-body" >
 <?php 
include('../connexion/connexionDB.php');

?>
 <div class="row">
          <div class="col-lg-12" >
		  <form name="form1" id="form1" method="post" action="../tcpdf/planing.php">
		  <div class="col-lg-6">
                  <div class="form-group">
				  <label>Shipping date</label>
				  <input class="form-control" type="date" name="dat_exp">                                          
				  </div>
				  <div class="form-group">
				  <label>Week </label>
				  <input class="form-control" type="text" name="sem">                                          
				  </div>
				  
				  <div class="form-group">
				  <label>Year </label>
				  <input class="form-control" type="text" name="year">                                          
				  </div>
                  <button type="submit" class="btn btn-default">Print </button>                                                
                  <button type="button" class="btn btn-default" onClick="excelPlanning();">Excel </button>                        <button type="reset" class="btn btn-default">Reset </button>                     
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
</div>


</body>

</html>