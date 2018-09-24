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
Modifier Ordre Fabrication
</title>
<script>

function afficheOF(){

		
 var valeur = document.getElementById("OF").value;
 if(valeur==""){
	  alert("Ajouter un OF  SVP !!");

 }
 else{
	$.ajax({
			url: '../php/affiche_update_of.php',
			type: 'POST',
			data: "OF="+valeur,
			success:function(data){
				
				$('#OFD').html(data);
			}});
 }
}

///////
function verifQTY(){
 var qte = document.getElementById("qte").value;
 var PO = document.getElementById("PO").value;
 var OF = document.getElementById("OF").value;

	$.ajax({
			url: '../php/verifier_qty_update.php',
			type: 'POST',
			data: "qty="+qte +"&PO="+PO+"&OF="+OF,
			success:function(data){
				if(data=="1"){
				alert("Cette QTY dépasse la qte de la commande , Vérifier vos valeur SVP!!");
				document.getElementById("statutPO").value="NON";
				}else {
				document.getElementById("statutPO").value=data;
				}
			}});
 }

//Update OF 
function updateOF(){

 var qte = document.getElementById("qte").value;
 var nbr = document.getElementById("nbr").value;
 var S = document.getElementById("statutPO").value;
 var i=0;
 var somme=0;
 
 while(nbr>i){
  i++;
  var q ="q"+i;
  var Q = document.getElementById(q).value;
  Q=parseInt(Q);
  somme=somme+Q;
 }
 if (S=="NON"){
 alert("la qte planifiée dépasse la qte de la commande , Vérifier vos valeur SVP!!");
 }
 else if(somme !=qte){
 alert("Verifier vos Plan SVP !!"); 
 }else{
 document.forms['form1'].submit(); 
 }
  //alert(Q);
 }
 
 function updatePlan(){
 document.form1.action="../php/update_ordre_fabrication2.php";
    document.form1.submit(); 
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
                    <h1 class="page-header">Manufacturing order  </h1>
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
        Update manufacturing order
 </div>
 <div class="panel-body" >
     <form role="form" method="post" name="form1" id="form1" action="../php/update_ordre_fabrication.php">
  <div class="row">

                                <div class="col-lg-6">
                                
                                        <div class="form-group">
                                             <label>Manufacturing order</label>
											 <div class="form-inline">
                                            <input class="form-control" id="OF" name="OF" >
                                            <button type="button" class="btn btn-default" onclick="afficheOF();">>> </button>
											</div>
                                        </div>
										
									
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