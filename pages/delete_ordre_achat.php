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
Supprimer bon d'achat
</title>
<script>
function afficheOrd(){
		 var ord = document.getElementById("ord").value;

 if(ord==""){
	 alert("Entrez un numéo d'ordre SVP !!");
	
 }
 else{
$.ajax({
          type: 'POST',
          data : 'ord=' + ord ,
          url: '../php/affiche_ord_delete.php',
          success: function(data) {
		        
                $("#tab").html(data);   
           }});
 }
}


function deleteI(ord){
var nbr = document.getElementById("nbr").value;
var ordX = document.getElementById(ord).value;

 if(confirm("Voulez-vous vraiment supprimer cette item ?")){
 
 $.ajax({
          type: 'POST',
          data : 'ordI=' +ordX+'&nbr=' + nbr,
          url: '../php/delete_ord_items.php',
          success: function(data) {
		     afficheOrd();
           }});
 }

}
function deleteOrd(){


 if(confirm("Voulez-vous vraiment supprimer cette ordre ?")){
 	document.forms['form1'].submit(); 
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
<p class="there">Supprimer bon d'achat</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form  id="form1" name="form1" method="POST" action="../php/delete_ordre_achat.php">


<TABLE >
<tr>
 <TH>N° ordre: </TH> 
 <td>
	<input type="text" name="ord" id="ord" size="20" placeholder="N°" />
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
