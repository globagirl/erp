<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
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
Consulter Bon Livraison
</title>
<SCRIPT> 

function afficheBL(){
var liste2 = document.getElementById("recherche");
var R = liste2.options[liste2.selectedIndex].value;

if (R !="client" ){
var val = document.getElementById("valeur").value;
}else{
var liste1 = document.getElementById("valeur");
var val = liste1.options[liste1.selectedIndex].value;
}
var S = document.getElementById("statut").value;

$.ajax({
        type: 'POST',
        data: 'recherche='+R +'&valeur='+val +'&statut='+S ,
        url: '../php/consult_BL.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	  
}

/////Afficher zone de recherche
function afficheZone(){

 var liste = document.getElementById('recherche');
  var recherche = liste.options[liste.selectedIndex].value;
  if(recherche=="date_liv"){
  $('#zone').html('<input type="date" id="valeur" name="valeur"> ');
  }else if (recherche=="client"){
		
	    $('#zone').html('	<span class="custom-dropdown custom-dropdown--white custom-dropdown--small"><select name="valeur" id="valeur"  style="width:220px" class="custom-dropdown__select custom-dropdown__select--white" ><option value="s">---Selectionnez</option> </select> </span> ');
        $.ajax({
        type: 'POST',
      
        url: '../php/listeClient.php',
        success: function(data) {
        $('#valeur').html(data);
       }});
	   
}else{
  $('#zone').html('<input type="text" id="valeur" name="valeur"> ');
  }

}
//////////////////
//////////////////
function afficheItems(i){

$.ajax({
        type: 'POST',
        data:'BL='+i,
        url: '../php/affiche_BL_items.php',
        success: function(data) {
        window.open('../php/affiche_BL_items.php','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=700,height=500,directories=no,location=no'); 
       }});

}



			   
			   
</SCRIPT> 
</head>

<body OnLoad="afficheBL();">



<div id="main">


<br>


<p class="there">Consulter Bon Livraison</p>

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
			 <option value="num_bl"> BL N°</option>
	         <option value="client"> Client</option> 			
			 <option value="IDproduit"> Produit</option> 
			 <option value="PO"> PO client</option>			 
		     <option value="date_bl"> Date expédition</option> 
		  
			

   </select> 
   </span>
   </td>
   <td id="zone">
   <input type="text" name="valeur" id="valeur" size="15"  disabled>
    <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Etat: </TH> 
 <td>
  <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="statut" id="statut" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a" selected>ALL</option>
	         <option value="invoiced"> Facturée</option> 
			 <option value="unbilled">Non facturée </option> 
			

   </select> 
   </span>
 <input type="button" id="submitbutton" value="OK" onclick="afficheBL()">  
 </td>
 </tr>
 </table>
 <div id="div1">
 </div>
 
</form>





</div>
</body>

</html>