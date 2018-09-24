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
	<script src="../jquery/jqueryDataTable.min.js"></script>
	<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
	<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
	<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
	<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
	<script src="../bootstrap/js/bootbox.min.js"></script>
	<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<title>Calcul salaire</title>
<script>
function calcul_salaire(){
$('#div1').html('<center><br><br> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center>');
var liste1 = document.getElementById("recherche");
var recherche= liste1.options[liste1.selectedIndex].value;
var valeur = document.getElementById("valeur").value;
var nbm = document.getElementById("nbm").value;
var year = document.getElementById("year").value;
var mois = document.getElementById("mois").value;
var dateD = document.getElementById("dateD").value;
var dateF = document.getElementById("dateF").value;
var avance=document.getElementById("avance").checked;
var mise=document.getElementById("mise").checked;
//var conge=document.getElementById("conge").checked;
var pay=document.getElementById("pay").checked;
mois=year+"-"+mois;
if(dateD==""){
bootbox.alert("Vérifier vos date SVP ");
}else if (nbm==""){
bootbox.alert("Donnez le total des minutes SVP !! ");
}else{
$.ajax({
        type: 'POST',
        data: 'recherche='+recherche+'&valeur='+valeur+'&dateM1='+dateD+'&dateM2='+dateF+'&nbm='+nbm+'&mois='+mois+'&avance='+avance+'&mise='+mise+'&pay='+pay,
        url: '../php/calcul_salaire.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	  
}
}
//
function calcul_salaire_jour(){
$('#div1').html('<center><br><br> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center>');
var liste1 = document.getElementById("recherche");
var recherche= liste1.options[liste1.selectedIndex].value;
var valeur = document.getElementById("valeur").value;
var nbm = document.getElementById("nbm").value;

 if (nbm==""){
bootbox.alert("Donnez le total des minutes SVP !! ");
}else{
$.ajax({
        type: 'POST',
        data: 'recherche='+recherche+'&valeur='+valeur+'&nbm='+nbm,
        url: '../php/calcul_salaire_jour.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	  
}
}


//
function calcul_date(){
var liste1 = document.getElementById("mois");
var mois= liste1.options[liste1.selectedIndex].value;
var year = document.getElementById("year").value;
var dateD = year+"-"+mois+"-01";
document.getElementById("dateD").value=dateD;

	   $.ajax({
        type: 'POST',
        data: 'dateM1='+dateD,
        url: '../php/calcul_dateF.php',
        success: function(data) {
        document.getElementById("dateF").value=data;
       }});
	  
}

//Fichier excel
function excelPS(){
var liste1 = document.getElementById("recherche");
var recherche= liste1.options[liste1.selectedIndex].value;
var valeur = document.getElementById("valeur").value;
var dateD = document.getElementById("dateD").value;
var dateF = document.getElementById("dateF").value;
if(dateD==""){
bootbox.alert("Donnez la date de début SVP ");
}else if (dateF==""){
bootbox.alert("Donnez la date de fin SVP !! ");
}else{
	document.form1.action="../php/excel_pay_sup.php";
    document.form1.submit(); 
}
}
//Print Invoice
function printSalaire(){
 var liste1 = document.getElementById("mois");
 var val = liste1.options[liste1.selectedIndex].value;
 var val2 = document.getElementById("nbm").value;
 var val3 = document.getElementById("year").value;
if(val=="s"){
alert("Selectionnez un mois SVP ");
}else if (val2==""){
alert("Donnez le total des minutes de travail du mois ");
}else if (val3==""){
alert("Donnez l'année SVP !!  ");
}else{
	document.form1.action="../tcpdf/print_salaire.php";
    document.form1.submit(); 
}
}			   			   
</SCRIPT> 
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
elseif($role=="GRH"){
include('../menu/menuGRH.php');	
}elseif($role=="DIR"){
include('../menu/menuDirecteur.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
 <?php
$date=date("Y-m-d");
$date= strtotime($date);
$year= strftime("%Y",$date);
 ?>
<div id='contenu'>
<div class="container" >
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
        <h1 class="page-header">Payment</h1>
     </div>              
</div>
<div class="row">
<div class="col-lg-12" >
<div class="panel panel-default">
<div class="panel-heading">  Calcul des payments </div>
<div class="panel-body" >
  <form role="form" method="post" name="form1" id="form1">
	 <div class="well">
	   <div class="row">
	     <div class="col-lg-8"> 
		   <div class="form-group">
		      <div class="form-inline">
			    <select name="mois" id="mois" type="text"  class="form-control" Onchange="calcul_date();">		
			      <option value="s">Sélectionnez un mois</option>
				  <option value="01">Janvier</option>
				  <option value="02">Février</option>
				  <option value="03">Mars</option>
				  <option value="04">Avril</option>
				  <option value="05">May</option>
				  <option value="06">Juin</option>
				  <option value="07">Juillet</option>
				  <option value="08">Aout</option>
				  <option value="09">Septembre</option>
				  <option value="10">Octobre</option>
				  <option value="11">Novembre</option>
				  <option value="12">Décembre</option>			
			    </select>
				<input type="text" size="10" placeholder="Year" name="year" id="year" value="<?php echo $year ; ?>"  class="form-control">
			  </div>
		   </div>
           <div class="form-group">
		     <label>Marge par date:</label>	
             <div class="form-inline">		
               <input class="form-control" id="dateD" name="dateD" type="date"> 
		       <input class="form-control" id="dateF" name="dateF" type="date">		
		       <input type="text" class="form-control" placeholder="NBR Minutes" name="nbm" id="nbm">	
             </div>
           </div>		 
           <div class="form-group">
		      <div class="form-inline">
		        <select name="recherche" id="recherche" class="form-control" >
			      <option value="A">ALL</option>
			      <option value="matricule">Matricule</option> 
	             	
                </select> 
			    <span id="zone">
			      <input type="text" name="valeur" id="valeur"  class="form-control">
			    </span>
		     </div>
	      </div>
		</div>
		<div class="col-lg-4"> 
		    <div class="form-group">
			   <label>Options</label>
               <div class="checkbox">
                  <label>
                     <input type="checkbox" id="avance" checked>Avances
                  </label>
               </div>
			   <div class="checkbox">
                  <label>
                     <input type="checkbox" id="mise" checked>Mise à pieds
                  </label>
               </div>
			  
			   <div class="checkbox">
                  <label>
                     <input type="checkbox" id="pay"checked>Payé
                  </label>
               </div>
            </div>
		</div> 
        <div class="col-lg-12">
           <input type="button" class="btn btn-primary" value="Calcul >>"  onclick="calcul_salaire()"> 		
		   <input type="button" class="btn btn-danger" value="Calcul salaire journalier >>"  onclick="calcul_salaire_jour()">
		</div>
      </div>
    </div>
	<div id="div1"> <!--Resultat affiché --> </div> 
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