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
Consult prices updates
</title>
<script>

function afficheListe(){

var val=$('input[name=cl_four]:checked', '#form1').val();
 if(val=="client"){
	  	$.ajax({
			url: '../php/listeClient.php',
			type: 'POST',
			success:function(data){

				$('#valeur').html(data);

			}});

 }
 else{

	$.ajax({
			url: '../php/listeFournisseur.php',
			type: 'POST',
			success:function(data){

				$('#valeur').html(data);

			}});
	//

 }
}


function verifItem(){

     var cl_four=$('input[name=cl_four]:checked', '#form1').val();
	 var liste1 = document.getElementById("valeur");
     var valeur = liste1.options[liste1.selectedIndex].value;
     var item=document.getElementById("item").value;
	  	$.ajax({
			url: '../php/verif_update_price.php',
			data: "val="+valeur+"&item="+item+"&cl_four="+cl_four,
			type: 'POST',
			success:function(data){

				if(data==0){

		        //$("#item").addClass("has-error");
				  bootbox.alert("Check your ITEM ID PLZ !!!");
				}
			}});

 }
//////////////
function desactiveEnter(){
 if (event.keyCode == 13) {
      event.keyCode = 0;
      window.event.returnValue = false;
 }
}
//
function consultListe(){

   var cl_four=$('input[name=cl_four]:checked', '#form1').val();
	  var liste1 = document.getElementById("valeur");
   var valeur = liste1.options[liste1.selectedIndex].value;
   var item=document.getElementById("item").value;
   var date1=document.getElementById("date1").value;
   var date2=document.getElementById("date2").value;
	  	$.ajax({
			url: '../php/consult_price_updates.php',
			data: "val="+valeur+"&item="+item+"&cl_four="+cl_four+"&date1="+date1+"&date2="+date2,
			type: 'POST',
			success:function(data){

					$('#divCons').html(data);
			}});

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

elseif($role=="FIN"){
include('../menu/menuFinance.php');
}elseif($role=="COM"){
include('../menu/menuCommercial.php');	
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
                    <h1 class="page-header">Consult updates </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>

   <form role="form" method="post" name="form1" id="form1" >
<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
      Consult prices updates
 </div>
 <div class="panel-body">
  <div class="row">
   <div class="col-lg-6">
    <div class="form-group col-lg-12">
     <label class="radio-inline">
      <input type="radio" name="cl_four" id="cl_four1" value="client" checked><b>Client</b>
     </label>
     <label class="radio-inline">
      <input type="radio" name="cl_four" id="cl_four2" value="fournisseur"><b>Supplier</b>
     </label>
    </div>
    <div class="form-group col-lg-7">
     <select class="form-control" name="valeur" id="valeur" onFocus="afficheListe();">
      <option>--Selectionnez</option>
     </select>
    </div>
    <div class="form-group col-lg-12">
     <label>Marge par date modification</label>
     <div class="form-inline ">
      <input class="form-control" id="date1" name="date1" type="date">
      <input class="form-control" id="date2" name="date2" type="date">
     </div>
    </div>
    <div class="form-group col-lg-12">
     <label>Item</label>
     <div class="form-inline ">
      <input class="form-control" id="item" name="item" onBlur="verifItem();" placeholder="ALL">
      <button class="btn btn-primary" type="button" onClick="consultListe();">>> </button>
     </div>
    </div>
   </div>
   <div id="divCons" class="col-lg-12">	</div>
  </div>
 </div>
</div>
</div>
</div>
</form>
</div>
</div>
</body>
</html>
