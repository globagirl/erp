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
Consulter Personnel
</title>
<script>
////////////////////////LISTE LIKE GOOGLE :) /////////////
function autoComplete(c,l){
var liste = document.getElementById('recherche');
var R = liste.options[liste.selectedIndex].value;
var zoneC="#"+c;
var zoneL="#"+l;
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
function hideListe(l) {
	
    var zoneL="#"+l;
	$(zoneL).hide();
	}

function choixListe(p,z) {
var ch=p.replace("|"," ");
var ch=ch.replace("|"," ");
var ch=ch.replace("|"," ");
	$(z).val(ch);
	
}
////////////////////////////////////FIN///////////////
//
function affichePersonel(){
   var liste2 = document.getElementById("recherche");
   var R = liste2.options[liste2.selectedIndex].value;
   var liste = document.getElementById("statut");
   var statut = liste.options[liste.selectedIndex].value;
   var val = document.getElementById("valeur").value;
   $.ajax({
        type: 'POST',
        data: 'recherche='+R +'&valeur='+val+'&statut='+statut,
        url: '../php/consult_personnel.php',
        success: function(data) {
        $('#div1').html(data);
    }});
	  
}
//
function afficheP(i){

   $.ajax({
       type: 'POST',
       data:'mat='+i,
       url: '../pages/update_personnel.php',
       success: function(data) {
       document.location.href="../pages/update_personnel.php";
       }});

}	
//
function afficheP2(i){

$.ajax({
        type: 'POST',
        data:'mat='+i,
        url: '../pages/consult_personnel_info.php',
        success: function(data) {
       document.location.href="../pages/consult_personnel_info.php";
       }});

}			   

//Personnel actif
function actifP(val){
//alert(val);

 if(confirm("Ce personnel sera actif de nouveau , Voulez vous terminer ?!")){
 var matNV = prompt("Entrer un nouveau matricule SVP ",val);
 
$.ajax({
        type: 'POST',
        data:'mat='+val+'&matNV='+matNV,
        url: '../php/update_personnel_actif.php',
        success: function(data) {        
        //location.reload();
        document.location.href="../pages/consult_personnel.php";	
       }});
}
}
//Personel inactif 
function inactifP(val){

 if(confirm("Ce personnel sera inactif  , Voulez vous terminer ?!")){
$.ajax({
        type: 'POST',
        data:'mat='+val,
        url: '../php/update_personnel_inactif.php',
        success: function(data) {
        alert("Nouveau matricule : "+data);
		//location.reload();
		document.location.href="../pages/consult_personnel.php";	
       }});
}
}
			   
</script> 
</head>

<body onLoad="affichePersonel();">


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
}elseif($role=="DIR"){
include('../menu/menuDirecteur.php');	
}
else{
header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Consulter Personnel</p>

<br>
<br>
<hr>
<form method="post">
<TABLE> 

<tr>
<th>Recherche: </th> 
<td>
    <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	<select name="recherche" id="recherche"  class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a"> ALL</option>
			 <option value="nom"> Nom & Prenom</option> 
	         <option value="NCIN"> NCIN</option> 			
			 <option value="matricule"> Matricule</option> 
	</select> 
   </span>
</td>
<td id="zone">
   <input type="text" name="valeur" id="valeur" size="20" onBlur="hideListe('listeP1');" onKeyup="autoComplete('valeur','listeP1'); " onFocus="autoComplete('valeur','listeP1')" >
   <div class="divAuto2"><ul id="listeP1" ></ul></div>
</td>
<th >Etat: </th> 
<td>
  <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	<select name="statut" id="statut" class="custom-dropdown__select custom-dropdown__select--white">
	<option value="a">ALL</option>	
	<option value="actif">Actif </option>     		 
	<option value="inactif"> Inactif</option> 
   </select> 
  </span> 
<td>
  <input type="button" id="submitbutton" value=">>" onclick="affichePersonel()">  
</td>
</tr>
</table>
<div id="div1"> </div>
</form>
</div>
</div>
</body>
</html>
<?PHP 

if(!empty($_GET['status']))
{ 
     $status = $_GET['status']; 
     if  ($status=="sent")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Personel modifié avec succès \');</SCRIPT>';
	 
	 } else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Fail !! veuillez réessayer SVP \');</SCRIPT>';}
} 
?>