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
<title>Consult congés</title>
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
var ch=ch.replace("|"," ");
var ch=ch.replace("|"," ");
	$(z).val(ch);
	
}



function afficheConge(){
 $('#div1').html('<center><br><br> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center>');
 var liste2 = document.getElementById("recherche");
 var R = liste2.options[liste2.selectedIndex].value;
 var val = document.getElementById("valeur").value; 
 var dateD = document.getElementById("dateD").value;
 var dateF = document.getElementById("dateF").value;
 var year = document.getElementById("year").value;
$.ajax({
        type: 'GET',
        data: 'recherche='+R +'&valeur='+val +'&dateD='+dateD+'&dateF='+dateF+'&year='+year,
        url: '../php/consult_conge.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	  
}
//
function deleteConge(idPC){
 if(confirm("Voulez vous vraiment supprimer cet avance ?!")){ 
   $.ajax({
        type: 'POST',
        data:'idPC='+idPC,
        url: '../php/delete_personnel_conge.php',
        success: function(data) {         
        afficheConge();
       }});
   }
}

function ajoutConge(){
     window.location.href = "../pages/ajout_conge.php";
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
        <h1 class="page-header">Congé</h1>
     </div>              
</div>
<div class="row">
<div class="col-md-12" >
<div class="panel panel-default">
<div class="panel-heading">  Liste des congés</div>
<div class="panel-body" >
  <form role="form" method="post" name="form1" id="form1">
	 <div class="well">
	   <div class="row">
	     <div class="col-md-8"> 
		    <div class="form-group">
			   <label>Personnel:</label>	
		      <div class="form-inline">
		        <select name="recherche" id="recherche" class="form-control" >
			      <option value="A">ALL</option>
			      <option value="matricule">Matricule</option>
				  <option value="nom"> Nom</option>
				  	
	             	
                </select> 
			    <span id="zone">
			      <input type="text" name="valeur" id="valeur"  class="form-control" onBlur="hideListe('listeP');" onKeyup="autoComplete('valeur','listeP'); " onFocus="autoComplete('valeur','listeP')">
			    </span>
				<div class="divAuto2"><ul id="listeP" ></ul></div>
		     </div>
	      </div>
           <div class="form-group">
		     <label>Marge par date:</label>	
             <div class="form-inline">		
               <input class="form-control" id="dateD" name="dateD" type="date"> 
		       <input class="form-control" id="dateF" name="dateF" type="date">	
               <input type="text" size="10" placeholder="Year" name="year" id="year" value="<?php echo $year ; ?>"  class="form-control">			   
		      
             </div>
           </div>		 
          
		</div>
		<div class="pull-left col-md-2"> 
		   <p style="float:right"><img src="../image/conge.png" onclick="ajoutConge();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
		</div> 
        <div class="col-md-12">
           <input type="button" class="btn btn-primary" value="Consult >>"  onclick="afficheConge()"> 		
          	
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