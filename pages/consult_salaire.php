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
	<!--<script src="../jquery/jqueryDataTable.min.js"></script>-->
	<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
	<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
	<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
	<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
	<script src="../bootstrap/js/bootbox.min.js"></script>
	<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<title>Consult salaire</title>
<script>
function autoComplete(){
var liste = document.getElementById('recherche');
var R = liste.options[liste.selectedIndex].value;
var zoneC="#valeur";
var zoneL="#listeP";
var min_length =1; 
	var keyword = $(zoneC).val();	
	if (keyword.length >= min_length) {
	
		$.ajax({
			url: '../php/auto_liste_personnel.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC+"&R="+R,
			success:function(data){
				$(zoneL).show();
				$(zoneL).html(data);
			}});
	}else {
		$(zoneL).hide();
	}
}
///
function hideListe() {
	
    var zoneL="#listeP";
	$(zoneL).hide();
	}

function choixListe(p,z) {
var ch=p.replace("|"," ");
var ch=ch.replace("|"," ");
var ch=ch.replace("|"," ");
	$(z).val(ch);
	
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


function afficheSalaire(){
$('#div1').html('<center><br><br> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center>');
var liste2 = document.getElementById("recherche");
var R = liste2.options[liste2.selectedIndex].value;

if (R =="category" || R=="typeS"){
var liste1 = document.getElementById("valeur");
var val = liste1.options[liste1.selectedIndex].value;
}else{

var val = document.getElementById("valeur").value;
}

 var liste1 = document.getElementById("mois");
 var val2 = liste1.options[liste1.selectedIndex].value;
 var val3 = document.getElementById("year").value;
 var dateD = document.getElementById("dateD").value;
 var dateF = document.getElementById("dateF").value;
$.ajax({
        type: 'POST',
        data: 'recherche='+R +'&valeur='+val +'&dateD='+dateD+'&dateF='+dateF,
        url: '../php/consult_salaire.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	  
}
///Affichage zone
function afficheZone(){

 var liste = document.getElementById('recherche');
  var recherche = liste.options[liste.selectedIndex].value;
  if(recherche=="a"){
  $('#zone').html('<input type="text" id="valeur" name="valeur" DISABLED> ');
  }else if (recherche=="category"){
		
	    $('#zone').html('<select name="valeur" id="valeur"  style="width:220px" class="form-control" ><option value="s">---Selectionnez</option> </select>');
        $.ajax({
        type: 'POST',
      
        url: '../php/listeCatPersonnel.php',
        success: function(data) {
        $('#valeur').html(data);
       }});
	   

}else if (recherche=="typeS"){
		
	    $('#zone').html('<select name="valeur" id="valeur"  style="width:220px" class="form-control" ><option value="F">Fixe</option><option value="V">Variable</option> </select>');
          

}else{
  $('#zone').html('<input type="text" id="valeur" name="valeur" class="form-control" onBlur="hideListe();" onKeyup="autoComplete(); " onFocus="autoComplete()"><div class="divAuto2"><ul id="listeP" ></ul></div>');
  }

}

//Fichier excel
function excelSalaire(){
	document.form1.action="../php/excel_salaire.php";
    document.form1.submit(); 
}

//Print Invoice
function printSalaire(){
	document.form1.action="../tcpdf/print_salaire2.php";
    document.form1.submit(); 
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
     <div class="col-md-12">
        <h1 class="page-header">Payment</h1>
     </div>              
</div>
<div class="row">
<div class="col-md-12" >
<div class="panel panel-default">
<div class="panel-heading">  Consulter payments </div>
<div class="panel-body" >
  <form role="form" method="post" name="form1" id="form1">
	 <div class="well">
	   <div class="row">
	     <div class="col-md-8"> 
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
		      
             </div>
           </div>		 
           <div class="form-group">
		      <div class="form-inline">
		        <select name="recherche" id="recherche" onChange="afficheZone();" class="form-control" >
			      <option value="A">ALL</option>
			      <option value="matricule">Matricule</option>
				  <option value="nom"> Nom</option>
				  <option value="typeS"> Salaire</option>
				  <option value="category">Category </option> 	
	             	
                </select> 
			    <span id="zone">
			      <input type="text" name="valeur" id="valeur"  class="form-control">
			    </span>
		     </div>
	      </div>
		</div>
		<div class="col-md-4"> 
		   
		</div> 
        <div class="col-md-12">
           <input type="button" class="btn btn-primary" value="Consult >>"  onclick="afficheSalaire()"> 		
          	
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