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
Liste des pointages
</title>
<SCRIPT> 
////////////////////////LISTE LIKE GOOGLE :) /////////////
function autoComplete(){
var liste = document.getElementById('recherche');
var R = liste.options[liste.selectedIndex].value;
var zoneC="#valeur";
var zoneL="#listeP";
var min_length =1; 
	var keyword = $(zoneC).val();	
	if (keyword.length >= min_length) {
	
		$.ajax({
			url: '../php/auto_liste_personnel.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC+"&R="+R,
			success:function(data){
				$(zoneL).show();
				$(zoneL).html(data);
			}});
	}else {
		$(zoneL).hide();
	}
}
///
function hideListe() {
	
    var zoneL="#listeP";
	$(zoneL).hide();
	}

function choixListe(p,z) {
var ch=p.replace("|"," ");
var ch=ch.replace("|"," ");
var ch=ch.replace("|"," ");
	$(z).val(ch);
	
}
////////////////////////////////////FIN///////////////
function affichePointage(){

var liste2 = document.getElementById("recherche");
var R = liste2.options[liste2.selectedIndex].value;

if (R =="category"){
var liste1 = document.getElementById("valeur");
var val = liste1.options[liste1.selectedIndex].value;
}else{

var val = document.getElementById("valeur").value;
}

var d1 = document.getElementById("date1").value;
var d2 = document.getElementById("date2").value;

$.ajax({
        type: 'POST',
        data: 'recherche='+R +'&valeur='+val +'&date1='+d1 +'&date2='+d2 ,
        url: '../php/consult_pointage.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	  
}
///Affichage zone
function afficheZone(){

 var liste = document.getElementById('recherche');
  var recherche = liste.options[liste.selectedIndex].value;
  if(recherche=="a"){
  $('#zone').html('<input type="text" id="valeur" name="valeur" DISABLED> ');
  }else if (recherche=="category"){
		
	    $('#zone').html('<span class="custom-dropdown custom-dropdown--white custom-dropdown--small"><select name="valeur" id="valeur"  style="width:220px" class="custom-dropdown__select custom-dropdown__select--white" ><option value="s">---Selectionnez</option> </select> </span> ');
        $.ajax({
        type: 'POST',
      
        url: '../php/listeCatPersonnel.php',
        success: function(data) {
        $('#valeur').html(data);
       }});
	   

}else{
  $('#zone').html('<input type="text" id="valeur" name="valeur" onBlur="hideListe();" onKeyup="autoComplete(); " onFocus="autoComplete()"><div class="divAuto2"><ul id="listeP" ></ul></div> ');
  }

}
/*
//Fichier excel
function excelPointage(){
	document.form1.action="../php/excel_pointage.php";
    document.form1.submit(); 
}
//Print Invoice
function printPointage(){
	document.form1.action="../tcpdf/print_pointage.php";
    document.form1.submit(); 
}	
*/		   
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
elseif($role=="GRH"){
include('../menu/menuGRH.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Liste des pointages</p>

<br>

<!-- end --> 





<form method="post" name="form1" id="form1">
<?php
include('../connexion/connexionDB.php');
?>
<p style="float:right"><img src="../image/print.png" onclick="printPointage();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
<img src="../image/excel.png" onclick="excelPointage();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p>
<TABLE BORDER="0"> 

<tr>
 <TH>Search: </TH> 
 <td style="width:50px">
 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="recherche" id="recherche" onChange="afficheZone();" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a">ALL</option>
			 <option value="nom"> Nom</option> 
	         <option value="matricule"> Matricule</option> 
				     
			

   </select> 
   </span><td id="zone">
   <input type="text" name="valeur" id="valeur" size="15"  disabled></td></tr><tr>
    <Td></Td> 
 <td colspan=3>
   <input type="date" name="date1" id="date1" size="10" >  <b> TO </b>
<input type="date" name="date2" id="date2"  size="10">   
 </td></tr><tr>
 <td></td>
 <td colspan=2><input type="button" id="submitbutton" value=">>" onclick="affichePointage()">  
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