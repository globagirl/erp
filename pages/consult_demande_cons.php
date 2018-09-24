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
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<title>
Demande Consommable
</title>
<SCRIPT> 

function afficheCommande(){
var liste2 = document.getElementById("recherche");
var R = liste2.options[liste2.selectedIndex].value;

if (R !="client" ){
var val = document.getElementById("valeur").value;
}else{
var liste1 = document.getElementById("valeur");
var val = liste1.options[liste1.selectedIndex].value;
}

var val2 = document.getElementById("statut").value;
$.ajax({
        type: 'POST',
        data: 'recherche='+R +'&valeur='+val+'&statut='+val2,
        url: '../php/consult_demande_cons.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	  
}


/////Afficher zone de recherche
function afficheZone(){

 var liste = document.getElementById('recherche');
  var recherche = liste.options[liste.selectedIndex].value;
   if (recherche=="IDconsommable"){
		
	    $('#zone').html('	<span class="custom-dropdown custom-dropdown--white custom-dropdown--small"><select name="valeur" id="valeur"  style="width:220px" class="custom-dropdown__select custom-dropdown__select--white" ><option value="s">---Selectionnez</option> </select> </span> ');
        $.ajax({
        type: 'POST',
      
        url: '../php/listeConsommable.php',
        success: function(data) {
        $('#valeur').html(data);
       }});
	   
}else if ((recherche=="IDdemande") || (recherche=="a")){
  $('#zone').html('<input type="text" id="valeur" name="valeur"> ');
  }else{
  $('#zone').html('<input type="date" id="valeur" name="valeur"> ');
  }

}
//////////////////
function afficheItems(i){

$.ajax({
        type: 'POST',
        data:'ID='+i,
        url: '../php/affiche_cons_items.php',
        success: function(data) {
        window.open('../php/affiche_cons_items.php','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=700,height=500,directories=no,location=no'); 
       }});

}






			   
			   
</SCRIPT> 
</head>

<body onLoad="afficheCommande();">


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

elseif($role=="MAG"){
include('../menu/menuMagazin.php');	
}
elseif($role=="CONS"){
include('../menu/menuConsommable.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Demande Consommable</p>

<br>

<!-- end --> 





<form method="post">
<?php
include('../connexion/connexionDB.php');
?>

<TABLE BORDER="0"> 

<tr>
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Recherche: </TH> 
 <td>
 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="recherche" id="recherche" onChange="afficheZone();" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a"> ALL</option>
	         <option value="IDdemande"> Demande N°</option> 
			 <option value="IDconsommable"> Consommable ID</option> 
			 <option value="dateD">Date demande </option> 
			 <option value="dateS"> Date sortie</option> 
		     <option value="dateC"> Date Confirmation</option> 
			

   </select> 
   </span>
   <td id="zone">
   <input type="text" name="valeur" id="valeur" size="15" OnFocus="focusZone();" disabled>
   </td>
    
 
   <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Etat: </TH> 
<td>
  <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="statut" id="statut" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a" selected>ALL</option>
	         <option value="D"> En attente</option> 
			 <option value="T">Sortie</option> 
			 <option value="C">Confirmée</option> 
			

   </select> 
   </span>
 <input type="button" id="submitbutton" value=">>" onclick="afficheCommande();">  
 </td>
 </tr>
 </table>
 <div id="div1">
 </div>
 
</form>


</div>


</div>
</body>

</html>