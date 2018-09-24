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
Modifier Ordre d'achat
</title>
<script>
function afficheOrd(){
		 var ord = document.getElementById("ord1").value;

 if(ord==""){
	 alert("Entrez un numéro d'ordre SVP !!");
	
 }
 else{
$.ajax({
          type: 'POST',
          data : 'ord=' + ord ,
          url: '../php/affiche_ord_up.php',
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
 document.getElementById(prixT).value=qte1*prixU1;
 
}
function upPrixT(j){
var t=0;
for(i=1;i<=j;i++){

var prixT="prixT"+i;

var prixT1= document.getElementById(prixT).value;
prixT1=parseFloat(parseFloat(prixT1).toFixed(6));
t=parseFloat(parseFloat(t).toFixed(6));
t=t+prixT1;
t=parseFloat(parseFloat(t).toFixed(6));
 }
 var tax= document.getElementById("tax").value;
 tax=parseFloat(parseFloat(tax).toFixed(6));
 var transport= document.getElementById("transport").value;
 transport=parseFloat(parseFloat(transport).toFixed(6));
 t=parseFloat(parseFloat(t).toFixed(6));
 t=t+tax+transport;
  t=parseFloat(parseFloat(t).toFixed(6));
  document.getElementById("prixT").value=t;
  //alert(t);
}
//Liste Four
function affichelisteF(){
		
	    
        $.ajax({
        type: 'POST',
    
        url: '../php/listeFournisseur.php',
        success: function(data) {
        $('#four').html(data);
       }});
	

}
///Update item
function afficheP(i){
 var it="item"+i;
var qt="qte"+i;

var pT="prixT"+i;
var ordX="ordX"+i;
var p="prixU"+i;
       
	    
		var item = document.getElementById(it).value;
     
        $.ajax({
        type: 'POST',
        data : 'item=' + item,
        url: '../php/affichePriceAchat.php',
        success: function(data) {
			if(data=="NO"){
				alert("verifiez le code produit SVP !! ");
				document.getElementById(p).value=0;
				document.getElementById(pT).value=0;
			}
			else{
			
				document.getElementById(p).value=data;
				qte=document.getElementById(qt).value;
				prixT=document.getElementById(pT).value;
				document.getElementById(pT).value=data*qte;
			}
			
       }});
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
<p class="there">Modifier Ordre d'achat</p>




<br>


<form  id="form1" name="form1" method="POST" action="../php/update_ordre_achat.php">


<TABLE >
<tr>
 <TH>Ordre d'achat N°: </TH> 
 <td>
	<input type="text" name="ord1" id="ord1" size="20" placeholder="N°" />
 <input type="button" id="submitbutton" value=">>" onclick="afficheOrd()"/> 
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
