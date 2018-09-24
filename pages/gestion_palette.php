<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
    $role=$_SESSION['role'];
	$userID=$_SESSION['userID'];
	include('../connexion/connexionDB.php');

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

<title>Gestion palettes</title>
<script>
function afficheGP(){
    var dateE = document.getElementById("dateE").value;
    var client = document.getElementById("client").value;
	if(client == "S" || client == ""){
	   bootbox.alert("Selectionnez un client SVP !");
	}else if(dateE == ""){
	   bootbox.alert("Vérifier votre date d'expédition SVP !");
	}else{
	  $.ajax({
		url: '../php/affiche_gestion_palette.php',
		type: 'POST',
		data: "dateE="+dateE+"&client="+client,
		success:function(data){
			$('#divA').html(data);

		}});
	}

}

//
function afficheFiltre(){
    var recherche = document.getElementById("recherche").value;
    var valeur = document.getElementById("valeur").value;
	var dateE = document.getElementById("dateE").value;
    var client = document.getElementById("client").value;
	$.ajax({
		url: '../php/affiche_filtre_palette.php',
		type: 'POST',
		data: "recherche="+recherche+"&valeur="+valeur+"&dateE="+dateE+"&client="+client,
		success:function(data){
			$('#IDpalette').html(data);

		}});
}
//
function update_liste_pal(nbr){
    var dateE = document.getElementById("dateE").value;
    var client = document.getElementById("client").value;
	$.ajax({
		url: '../php/update_liste_palette.php',
		type: 'POST',
		data: "dateE="+dateE+"&client="+client,
		success:function(data){
			$('#IDpalette').html(data);
   document.getElementById("IDpalette").selectedIndex = nbr;
		}});
}
//
function ticket_palette(){

	document.form1.action="../tcpdf/label_palette.php";
    document.form1.submit();
}
//Ajout palette
function ajout_palette(){

    var dateE = document.getElementById("dateE").value;
    var client = document.getElementById("client").value;
    var nbr=0;
	$.ajax({
		url: '../php/ajout_palette.php',
		type: 'POST',
		data: "dateE="+dateE+"&client="+client,
		success:function(data){
			//afficheGP();
			//alert(data);

            update_liste_pal(nbr);
		}});
}





//affiche carton palette
function afficheCarton(){
    var IDpalette = document.getElementById("IDpalette").value;

	$.ajax({
		url: '../php/affiche_carton_palette.php',
		type: 'POST',
		data: "IDpalette="+IDpalette,
		success:function(data){
			$('#divCartPal').html(data);

		}});
		//alert("gr");


}
//affecter tous les cartons a une palette
function affiche_carton_libre(){

	$.ajax({
		url: '../php/affiche_carton_libre.php',
		type: 'POST',
		success:function(data){

            $('#cartonLibre').html(data);
		}});



}
function affect_Carton_all(){
    var IDpalette = document.getElementById("IDpalette").value;
	var nbr=document.getElementById("IDpalette").selectedIndex;
    if(IDpalette != "XX" && IDpalette != ""){
	$.ajax({
		url: '../php/affecter_carton_all.php',
		type: 'POST',
		data: "IDpalette="+IDpalette,
		success:function(data){
			afficheCarton();
			affiche_carton_libre();
            update_liste_pal(nbr);
		}});
	}else{
	   bootbox.alert("Selectionnez une palette SVP !! ");
	}


}
//
function affect_Carton(){
    var IDpalette = document.getElementById("IDpalette").value;
	var nbr=document.getElementById("IDpalette").selectedIndex;
   // var IDcarton = document.getElementById("cartonLibre").value;
    var IDcarton =$("#cartonLibre").val();
	//alert(IDcarton);
  if(IDpalette != "XX" && IDpalette != ""){
	$.ajax({
		url: '../php/affecter_carton.php',
		type: 'POST',
		data: "IDpalette="+IDpalette+"&IDcarton="+IDcarton,
		success:function(data){
			afficheCarton();
			affiche_carton_libre();
			update_liste_pal(nbr);
			//alert(data);
		}});
	}else{
	   bootbox.alert("Selectionnez une palette SVP !! ");
	}


}
//Retirer
function retir_Carton_all(){
    var IDpalette = document.getElementById("IDpalette").value;
	var nbr=document.getElementById("IDpalette").selectedIndex;
    if(IDpalette != "XX" && IDpalette != ""){
	$.ajax({
		url: '../php/retirer_carton_all.php',
		type: 'POST',
		data: "IDpalette="+IDpalette,
		success:function(data){
			afficheCarton();
			affiche_carton_libre();
			update_liste_pal(nbr)
		}});
	}else{
	   bootbox.alert("Selectionnez une palette SVP !! ");
	}


}
//
function retir_Carton(){
    var IDpalette = document.getElementById("IDpalette").value;
	var nbr=document.getElementById("IDpalette").selectedIndex;
    //var IDcarton = document.getElementById("cartPal").value;
    var IDcarton = $("#cartPal").val();
    if(IDpalette != "XX" && IDpalette != ""){
	$.ajax({
		url: '../php/retirer_carton.php',
		type: 'POST',
		data: "IDpalette="+IDpalette+"&IDcarton="+IDcarton,
		success:function(data){
			afficheCarton();
			affiche_carton_libre();
			update_liste_pal(nbr);
		}});
	}else{
	   bootbox.alert("Selectionnez une palette SVP !! ");
	}


}
//
function delete_palette(){
    var IDpalette = document.getElementById("IDpalette").value;
	var nbr=0;
	if(confirm("Voulez-vous vraiment supprimer cette palette ?")){
    if(IDpalette != "XX" && IDpalette != ""){
	$.ajax({
		url: '../php/delete_palette.php',
		type: 'POST',
		data: "IDpalette="+IDpalette,
		success:function(data){
            update_liste_pal(nbr);
			affiche_carton_libre();

			afficheCarton();
		}});
	}else{
	   bootbox.alert("Selectionnez une palette SVP !! ");
	}

 }
}
//
function close_palette(){
  //var IDpalette = document.getElementById("IDpalette").value;
  var IDpalette =$("#IDpalette").val();
	 var nbr=document.getElementById("IDpalette").selectedIndex;
  if((IDpalette != "XX") && (IDpalette != "")){
	    $.ajax({
		     url: '../php/close_palette.php',
         type: 'POST',
         data: "IDpalette="+IDpalette,
         success:function(data){
            bootbox.alert(data);
            update_liste_pal(nbr);
		       }});
	  }else{
	   bootbox.alert("Selectionnez une palette SVP !! ");
	  }
}
//Shipment report
function shipmentReport(){
	document.form1.action="../tcpdf/shipment_report.php";
	document.form1.submit();
}

	//Packing List
/*function packingList(){
	document.form1.action="../tcpdf/pack_liste.php";
	document.form1.submit();
}*/

function packingList(){
  var IDpalette =$("#IDpalette").val();
  var dateE = document.getElementById("dateE").value;
  var client = document.getElementById("client").value;

  if((IDpalette != "XX") && (IDpalette != "")){
          $.ajax({
             type: 'POST',
             data: 'IDpal='+IDpalette+"&dateE="+dateE+"&client="+client,
             url: '../tcpdf/pack_liste.php',
             success: function(data) {
                //document.location.href="../tcpdf/pack_liste.php";
                window.open("../tcpdf/pack_liste.php", '_blank');
             }});
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
}else if($role=="EMB"){
    include('../menu/menuEMB.php');
}else if($role=="CONS"){
    include('../menu/menuConsommable.php');
}else if($role=="FIN"){
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
        <h1 class="page-header">Palettes </h1>
    </div>
</div>
<form role="form" method="post" name="form1" id="form1" target="_blank">
    <div class="row">
        <div class="col-lg-12 well" >
          <div class="col-lg-4">
              <div class="form-group">
                  <label> Client : </label>
								  <select class="form-control" id="client" name="client">
								  <?php
									$q1 = mysql_query("SELECT name_client,nomClient FROM client1");
									echo '<option value="S">Selectionnez...</option>';
									while($data1=mysql_fetch_array($q1)) {
									    echo '<option value="'.$data1["name_client"].'">'.$data1["nomClient"].'</option>';
                  }
									mysql_close();
									?>
                  </select>
              </div>
					</div>
					<div class="col-lg-6">
							<div class="form-group">
                  <label> Date expédition: </label>
                  <div class="form-inline">
                      <input class="form-control" type="date" id="dateE" name="dateE"  >
								      <button type="button" class="btn btn-danger" onClick="afficheGP();">>> </button>
                  </div>
              </div>
					</div>
					<div class="col-lg-2 pull-right">
							 <div class="form-group">
								    <button type="button" class="btn btn-success" onClick="shipmentReport();">SHIPMENT REPORT </button>
        </div>

     </div>


				</div>

    </div>
<!--</div>
</div>-->
</div>
<div class="col-lg-12 well" id="divA">
				</div>

</div><!--row-->

</div>
	</form>
</div>
</div>
</div>


</body>

</html>
