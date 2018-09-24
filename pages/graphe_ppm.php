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
PPM graph
</title>
<SCRIPT> 
function updateG(y){    
    $.ajax({
        type: 'POST',
		data: 'year='+y,
        url: '../pChart/graphe_ppm.php',
        success: function(data) {
        $('#chart1').html(data); 
       		
	}});

}
function updateG2(y){
    $.ajax({
        type: 'POST',
		data: 'year='+y,
        url: '../pChart/graphe_ppmCAT5.php',
        success: function(data) {
        $('#chart2').html(data); 
	}});

}
function updateG3(y){
    $.ajax({
        type: 'POST',
		data: 'year='+y,
        url: '../pChart/graphe_ppmCAT6a.php',
        success: function(data) {
        $('#chart3').html(data); 
	}});

}
function affichePPM(){

$('#chart1').html('<br><br><br><br><br><center> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="250" height="250"  /></center>');
var year=document.getElementById("year").value;
 updateG(year);
 updateG2(year);
 updateG3(year);	
}	 

function printPPM(){
	document.form1.action="../tcpdf/graphe_ppm.php";
    document.form1.submit(); 
}  
</script>

</head>

<body onLoad="affichePPM();">

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
}elseif($role=="DIR"){
include('../menu/menuDirecteur.php');	
}elseif($role=="QLT"){
include('../menu/menuQualite.php');	
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
                    <h1 class="page-header">PPM</h1>
                </div>
                <!-- /.col-lg-12 -->
</div>
 <?php
$date=date("Y-m-d");
$date= strtotime($date);
$year= strftime("%Y",$date);
 ?>

<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
        PPM graphs
 </div>
 <div class="panel-body" >
 <form role="form" method="post" name="form1" id="form1">
	<div class="col-lg-6">
        <div class="form-group form-inline">
            <input class="form-control" id="year" name="year" value="<?php echo $year ; ?>" >
            <button type="button" class="btn btn-default" onclick="affichePPM()">>> </button>
            <button type="button" class="btn btn-default" onclick="printPPM()">Print >> </button>
        </div>
	</div>
	 
    <div class="col-lg-12 scrollY" id="chart1">
	 
	        <br><br><br><br><br>
	        <center> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="250" height="250"  /></center>
	  
	   
	</div>    
	<div class="col-lg-12 scrollY" id="chart2">
	 
	        <br><br><br><br><br>
	        <center> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="250" height="250"  /></center>
	  
	   
	</div>
   	<div class="col-lg-12 scrollY" id="chart3">
	 
	        <br><br><br><br><br>
	        <center> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="250" height="250"  /></center>
	  
	   
	</div>

 </form>
</div>
</div>
</div>
</div>
</div>

</div>

<!--fin -->



</div>


</div>
</body>

</html>