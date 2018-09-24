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
Liste des sorties Stock
</title>
<SCRIPT> 
function afficheSortie(){
 var liste1 = document.getElementById("recherche");
 var val1 = liste1.options[liste1.selectedIndex].value;
 
 var val2=document.getElementById("valeur").value;
 var liste2 = document.getElementById("statut");
 var val3 = liste2.options[liste2.selectedIndex].value;
 
 
 if(val1=="s"){
	 alert("Selectionnez un mode de recherche SVP !!");

	
 }
 else{
	 
	$.ajax({
        type: 'POST',
        data: 'recherche='+val1 +'&valeur='+val2+'&statut='+val3,
        url: '../php/consult_sortie.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	 
 }
 //alert(valeur);
}


/////Afficher zone de recherche
function afficheZone(){

 var liste = document.getElementById('recherche');
  var recherche = liste.options[liste.selectedIndex].value;
  if(recherche=="dateS"){
  $('#zone').html('<input type="date" id="valeur" name="valeur"> ');
  }else{
  $('#zone').html('<input type="text" id="valeur" name="valeur"> ');
  }

}



///////////
function excelSortie(){
	document.form1.action="../php/excel_consult_sortie.php";
    document.form1.submit(); 
}


			   
			   
</SCRIPT> 
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

elseif($role=="MAG"){
include('../menu/menuMagazin.php');	
}elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Liste des sorties Stock</p>

<br>

<!-- end --> 





<form method="post" id="form1" name="form1">
<p style="float:right">
<img src="../image/excel.png" onclick="excelSortie();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p>
<TABLE BORDER="0"> 

<tr>
 <TH>Recherche: </TH> 
 <td>
 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="recherche" id="recherche" onChange="afficheZone();" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a">ALL</option>
	         <option value="article"> Article</option> 
			 <option value="paquet">Paquet </option> 
			 <option value="commande">Commande </option> 
		     <option value="OF"> Ordre fabrication</option> 
		     <option value="dateS"> Date sortie</option> 
			

   </select> 
   </span>
   </td>
   <td id="zone">
   <input type="text" name="valeur" id="valeur" size="15" disabled>
   </td>
    <TH>Type: </TH> 
	
 <td>
  <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="statut" id="statut" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a" selected>ALL</option>
	         <option value="s">Sortie</option> 
			 <option value="relance">Sortie par Relance </option> 
			

   </select> 
   </span>
 <input type="button" id="submitbutton" value="OK" onclick="afficheSortie()">  
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