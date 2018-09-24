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
Consult etat export
</title>
<script>


////////////////////////////////////FIN///////////////
function afficheEtat(){
		
 var date1 = document.getElementById("date1").value;
 var date2 = document.getElementById("date2").value;
 if(date1==""){
	  alert("Donner une date SVP !!");

 }else if(date2==""){
 alert("Donner une date SVP !!");
 } else{
	
	$.ajax({
			url: '../php/consult_etat_export.php',
			type: 'POST',
			data: "date1="+date1+"&date2="+date2,
			success:function(data){
				if(data != 0){
				$('#OFD').html(data);
				}else{
				alert("Pas d'export  !!");
				}
			}});
	//
	
 }
}
function affiche2016(){

	
	$.ajax({
			url: '../php/consult_etat_export2016.php',
			type: 'POST',
			
			success:function(data){
				if(data != 0){
				$('#OFD').html(data);
				}else{
				alert("Pas d'export  !!");
				}
			}});
	
	
 
}
//
function affiche2015(){

	
	$.ajax({
			url: '../php/consult_etat_export2015.php',
			type: 'POST',
			
			success:function(data){
				if(data != 0){
				$('#OFD').html(data);
				}else{
				alert("Pas d'export  !!");
				}
			}});
	
	
 
}

///////

//Fichier excel
function excelEtat(){
	document.form1.action="../php/excel_etat_export.php";
    document.form1.submit(); 
}
//
function excel2016(){
	document.form1.action="../php/excel_etat_export2016.php";
    document.form1.submit(); 
}
//
function excel2015(){
	document.form1.action="../php/excel_etat_export2015.php";
    document.form1.submit(); 
}
//Page consult commande
function printEtat(){
	document.form1.action="../tcpdf/print_etat_export.php";
	 document.form1.submit(); 
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
else if($role=="FIN"){
include('../menu/menuFinance.php');	
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
                    <h1 class="page-header">Etat export  </h1>
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
          Consult etat export
 </div>
 <div class="panel-body" >
     <form role="form" method="post" name="form1" id="form1">
  <div class="row">
                                <div class="col-lg-6">
								          <div class="form-group form-inline">
                                            
											
											 <button type="button" class="btn btn-default red" onclick="affiche2016()">Ancien 2016 </button>
											 
											 <button type="button" class="btn btn-default red" onclick="excel2016()">Excel 2016 </button>  
											 
                                            <button type="button" class="btn btn-default red" onclick="affiche2015()">Etat 2015 </button> 
											
                                            <button type="button" class="btn btn-default red" onclick="excel2015()">Excel 2015 </button>
                                           
                                        </div>
                                
                                        <div class="form-group form-inline">
                                            
                                            <input class="form-control" id="date1" name="date1" type="date">
                                            <input class="form-control" id="date2" name="date2" type="date">
                                            <button type="button" class="btn btn-default blue" onclick="afficheEtat()">  >> </button>
											
                                           
                                        </div>
										
										
									
							    </div>
								<div>
								<p style="float:right">
<img src="../image/excel.png" onclick="excelEtat();" alt="Excel" style="cursor:pointer;" width="60" height="50"  />
<img src="../image/print.png" onclick="printEtat();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
</p>
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