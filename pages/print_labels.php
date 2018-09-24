<?php
//TO delete
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
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>

<title>
Etiquette
</title>
<script>

///////Auto Complete //////
function autoComplete(){

var min_length =3; 
	var keyword = $('#PO').val();	
	if (keyword.length >= min_length) {
	var zoneC="#PO";
		$.ajax({
			url: '../php/auto_liste_po.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC,
			success:function(data){
				$('#listePO').show();
				$('#listePO').html(data);
			}});
	}else {
		$('#listePO').hide();
	}
}
//
function hideListe() {
	
    
	$('#listePO').hide();
	}
//	
function choixListe(p,z) {
	$(z).val(p);
}
////////////////////////////////////FIN///////////////
function affichePO(){
		
 var valeur = document.getElementById("PO").value;
 if(valeur==""){
	  alert("Donnez le PO SVP !!");

 }
 else{
	
	$.ajax({
			url: '../php/affichePO_paquet2.php',
			type: 'POST',
			data: "commande="+valeur,
			success:function(data){
				if(data != 0){
				$('#OFD').html(data);
				}else{
				alert("Vérifier votre PO SVP !!");
				$('#OFD').html("<div></div>");
				}
			}});
	//
	
 }
}
//
function tickPaq(){

 var nbrB = document.getElementById("nbrB").value;
 nbrB = parseInt(nbrB);
 var nbrBT = document.getElementById("nbrBT").value;
 nbrBT = parseInt(nbrBT);
 var FR = document.getElementById("FR").value;
 FR = parseInt(FR);
 var tot=nbrB+FR-1;
 tot = parseInt(tot);
if(nbrB < 0){
  bootbox.alert("Donnez le nombre de paquet SVP ");
}else if(FR > nbrBT){
  bootbox.alert("Vérifier le numéro du premier carton SVP ");
}else if(tot > nbrBT){
  bootbox.alert("Vérifier le nombre des cartons SVP ");
}else{
	document.form1.action="../tcpdf/label_paquet2.php";
    document.form1.submit();
    //alert ('OK');	
}
}	
//
function tickBag(){

var nbrBag = document.getElementById("nbrBag").value;
nbrBag = parseInt(nbrBag);
var frBag = document.getElementById("frBag").value;
frBag = parseInt(frBag);
var qty = document.getElementById("qty").value;
qty = parseInt(qty);
if((nbrBag < 0) || (frBag > nbrBag) || (nbrBag > qty)){
  bootbox.alert("Vérifier le nombre des tickets sachet a imprimer SVP  ");
}else{
	 document.form1.action="../tcpdf/label_bag.php";
  document.form1.submit(); 
}
}	
//
	
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

elseif($role=="EMB"){
include('../menu/menuEMB.php');	
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
     <h1 class="page-header">Ticket </h1>
  </div>
</div>
<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          Impression tickets
 </div>
 <div class="panel-body" >
    <form role="form" method="post" name="form1" target="_blank">
      <div class="row">
         <div class="col-lg-6">
            <div class="form-group form-inline">
               <input class="form-control" id="PO" name="PO" placeholder="PO client" onKeyup="autoComplete();" onFocus="autoComplete()"  onBlur="hideListe();">
															<button type="button" class="btn btn-default" onclick="affichePO();">>> </button>
            </div>
												<div class="divAuto2"><ul id="listePO" ></ul></div>								
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