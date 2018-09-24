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



<title>
Modifier commande
</title>
<script>
function affichePO(){
		 var PO = document.getElementById("PO1").value;

 if(PO==""){
	 alert("Entrez un PO SVP !!");
	
 }
 else{
$.ajax({
          type: 'POST',
          data : 'PO=' + PO ,
          url: '../php/affiche_po_up.php',
          success: function(data) {
		        
                $("#tab").html(data);   
           }});
 }
}


function upPrix(i){
var qte="qte"+i;
var prixT="prixT"+i;
var prixU="prixU"+i;
var qte1 = document.getElementById(qte).value;
qte1=parseFloat(parseFloat(qte1).toFixed(6));
var prixU1= document.getElementById(prixU).value;
prixU1=parseFloat(parseFloat(prixU1).toFixed(6));
var pq=qte1*prixU1;
pq=parseFloat(parseFloat(pq).toFixed(6));
 document.getElementById(prixT).value=pq;
 
}
function upPrixT(j){
var t=0;
for(i=1;i<=j;i++){

var prixT="prixT"+i;

var prixT1= document.getElementById(prixT).value;
prixT1=parseFloat(parseFloat(prixT1).toFixed(6));


t=t+prixT1;
 }
  document.getElementById("prixT").value=t;
  //alert(t);
}

function upQtyT(j){
var t=0;
for(i=1;i<=j;i++){
var qte="qte"+i;

var prixU="prixU"+i;
var qte1 = document.getElementById(qte).value;
qte1=parseFloat(parseFloat(qte1).toFixed(6));

t=t+qte1;
 }
  document.getElementById("qtyT").value=t;
}

//Update produit
function verifierProduit(i){

  /////////////
   var it="item"+i;
var qt="qte"+i;

var pT="prixT"+i;
var ordX="ordX"+i;
var p="prixU"+i;
       
	    
		var item = document.getElementById(it).value;
        var qte=document.getElementById(qt).value;
	    var prixT=document.getElementById(pT).value;
        $.ajax({
        type: 'POST',
        data : 'produit=' +item +'&qty=' + qte,
        url: '../php/verifChampsCommande.php',
        success: function(data) {
			if(data=="NO"){
				alert("verifiez le code produit SVP !! ");
				document.getElementById(p).value=0;
				document.getElementById(pT).value=0;
			}
			else{
			
				document.getElementById(p).value=data;
				
				document.getElementById(pT).value=data*qte;
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
</script>
</head>

<body onKeyDown='desactiveEnter()'>
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
elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>



<!-- began --> 
<BR>
<p class="there">Modifier commande</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form  id="form1" name="form" method="POST" action="../php/update_commande.php">


<TABLE >
<tr>
 <TH>PO client: </TH> 
 <td>
	<input type="text" name="PO1" id="PO1" size="20" placeholder="PO client" onKeyPress="if (event.keyCode == 13) affichePO();"/>
 <input type="button" id="submitbutton" value=">>" onclick="affichePO()"/> 
 </td>

			
		</tr>
 
</TABLE > 
<table id="tab">
</table>
</form>
</div>
</div>


</body>

</html>
