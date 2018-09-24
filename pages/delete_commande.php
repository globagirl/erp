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
Supprimer Commande
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
          url: '../php/affiche_po_delete.php',
          success: function(data) {
		        
                $("#div1").html(data);   
           }});
 }
}


function deleteI(po,s,i){
if(s !="waiting"){
alert("Vous ne pouvez pas supprimer cette commande !! ");
}else{
var nbr = document.getElementById("nbr").value;
var qte="qte"+i;
var prixT="prixT"+i;
var qteI=document.getElementById(po).value;
 if(confirm("Voulez-vous vraiment supprimer cette commande?")){
 $.ajax({
          type: 'POST',
          data : 'POi=' + po+'&nbr=' + nbr ,
          url: '../php/delete_commande_item.php',
          success: function(data) {
		     	
	         affichePO();
           }});
 }
 }
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
<p class="there">Supprimer commande</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form  id="form1" name="form" method="POST" action="../php/delete_commande.php">


<TABLE >
<tr>
 <TH>PO client: </TH> 
 <td>
	<input type="text" name="PO1" id="PO1" size="20" placeholder="PO client" />
 <input type="button" id="submitbutton" value=">>" onclick="affichePO()"/> 
 </td>

			
		</tr>
 
</TABLE > 
<div id="div1">
</div>
</form>
</div>
</div>


</body>

</html>
