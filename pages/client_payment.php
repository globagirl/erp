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
Client payment
</title>
<script>

function afficheInvoice(){
		
 var valeur = document.getElementById("fact").value;
 if(valeur==""){
	  alert("Donnez le numéro de la facture SVP !!");

 }
 else{
   if($("#chek").prop('checked') == true){
   
	$.ajax({
			url: '../php/affiche_credit_starz.php',
			type: 'POST',
			data: "CN="+valeur,
			success:function(data){
				if(data==1){
				bootbox.alert("Vérifier le numéro du credit note SVP !!");
				}else if(data==0){
				bootbox.alert("Credit note  payé !!");
				}else{
				$('#OFD').html(data);
				}
			}});
	
	
	}else{
	 	$.ajax({
			url: '../php/affiche_invoice_client.php',
			type: 'POST',
			data: "fact="+valeur,
			success:function(data){
				if(data==1){
				bootbox.alert("Vérifier le numéro de la facture SVP !!");
				}else if(data==0){
				bootbox.alert("Facture payé !!");
				}else{
				$('#OFD').html(data);
				}
			}});
	
	}
 }
}



//////////////
function desactiveEnter(){ 
 if (event.keyCode == 13) { 
      event.keyCode = 0; 
      window.event.returnValue = false; 
 } 
}
//
function submitV(){ 
var valeur = document.getElementById("fact").value;
var dateP = document.getElementById("dateP").value;
 if(valeur==""){
	  bootbox.alert("Donnez le numéro de la facture SVP !!");

 }else if(dateP==""){
 bootbox.alert("Donnez la date de payment SVP !!");
 }else{
	document.form1.action="../php/client_payment.php";
    document.form1.submit(); 
 }

} 	
//
function submitCN(){ 
var valeur = document.getElementById("fact").value;
var dateP = document.getElementById("dateP").value;
 if(valeur==""){
	  bootbox.alert("Donnez le numéro de la facture SVP !!");

 }else if(dateP==""){
 bootbox.alert("Donnez la date de payment SVP !!");
 }else{
	document.form1.action="../php/client_paymentCN.php";
    document.form1.submit(); 
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

elseif($role=="FIN"){
include('../menu/menuFinance.php');	
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
                    <h1 class="page-header">Payment  </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>

<?php
include('../connexion/connexionDB.php');
?>

   <form role="form" method="post" name="form1" id="form1" action="../php/client_payment.php">
<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          Client payment
 </div>
 <div class="panel-body" >
  
  <div class="row">
                                <div class="col-lg-6">
                                
                                        <div class="form-group form-inline">
                                            
                                           <label>
                                            <input type="checkbox" name="chek" id="chek" class="form-control" value="oui"> Credit note
											</label>
                                        </div>
										<div class="form-group form-inline">
                                            
                                            <input class="form-control" id="fact" name="fact" placeholder="Invoice N°" >
                                            <button type="button" class="btn btn-default" onclick="afficheInvoice();">>> </button>
                                        </div>
										
									
								</div>
										</div>



<div id="OFD"></div>




</div>
</div>
</div>
</div>
	</form>
</div>

</div>


</body>

</html>