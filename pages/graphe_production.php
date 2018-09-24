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
Graphe production
</title>
<script>
function grapheProd(){
	var liste = document.getElementById('graphe');
    var g = liste.options[liste.selectedIndex].value;
	var d1 = document.getElementById("date1").value;
var d2 = document.getElementById("date2").value;
if(g=="a"){
alert("Choisissez un graphe SVP ");
}else if(g=="a1"){
$.ajax({
        type: 'POST',
        data: 'date1='+d1 +'&date2='+d2 ,
        url: '../pChart/graphe_prod.php',
        success: function(data) {
        $('#div1').html(data);
       }});

}else if(g=="a2"){
$.ajax({
        type: 'POST',
        data: 'date1='+d1 +'&date2='+d2 ,
        url: '../pChart/graphe_taux.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	   }
}
//
function tableProd(){

var d1 = document.getElementById("date1").value;
var d2 = document.getElementById("date2").value;

$.ajax({
        type: 'POST',
        data: 'date1='+d1 +'&date2='+d2 ,
        url: '../php/total_prod_tab.php',
        success: function(data) {
        $('#tabProd').html(data);
		grapheProd();
       }});
}
///
function excelProd(){
	
	var d1 = document.getElementById("date1").value;
var d2 = document.getElementById("date2").value;
 if(d1==""){
alert("Donnez une date  ");
}else if(d2==""){
alert("Donnez une date SVP ");
}else{
	
	   document.form1.action="../php/excel_articles.php";
    document.form1.submit(); 
   }
    
}
///
function printGraphe(){

	var liste = document.getElementById('graphe');
    var g = liste.options[liste.selectedIndex].value;
	var d1 = document.getElementById("date1").value;
var d2 = document.getElementById("date2").value;

 if(d1==""){
alert("Donnez une date  ");
}else if(d2==""){
alert("Donnez une date SVP ");
}else{
	
	   document.form1.action="../tcpdf/graphe_prod.php";
    document.form1.submit(); 
   }
    
	//alert ("oof");
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
                    <h1 class="page-header">Graphe production   </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>



<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          Production par semaine   
 </div>
 <div class="panel-body" >

<form method="POST"  id="form1" name="form1">
<div class="row">  
                    <div class="form-group col-md-12"> 
		<div class="col-md-4"> 
              <label class="control-label" for="graphe">Type graphe</label> 
			<select name="graphe" id="graphe" class="form-control">
			
			
			<option value="a">---Sélectionnez</option>
			<option value="a1">Quantité produite</option>
			<option value="a2">Taux de productivité </option>
			</select>
	 
	 </div>
	 </div>
                    
                   
                    <div class="form-group col-md-12"> 
					<div class="col-md-4">  
                    <label class="control-label" for="date1">Debut semaine</label> 
                     
                    <input id="date1" name="date1" type="date" class="col-md-4 form-control input-md"> 
                    </div>
                    <div class="col-md-4"> 
                    <label class="control-label" for="date2">Fin semaine</label> 
                   
                    <input  id="date2" name="date2" type="date"  class="col-md-4 form-control input-md"> 
                   
                    </div>
					
					 <div class="col-md-4"> 
	                 <br>
					 
	                 <input type="button" onclick="tableProd();" class="btn btn-default" id="b1" value="Graphe >>">
	                 <input type="button" onclick="excelProd();" class="btn btn-default" id="b2" value="Articles >>">
	                 <input type="button" onclick="printGraphe();" class="btn btn-default" id="b3" value="Print >>">
	                 </div>
                    </div>
      
	
	

<div class="col-md-12" id="tabProd">
</div>
<div class="col-md-12" id="div1">

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
</div>
</body>
</html>
