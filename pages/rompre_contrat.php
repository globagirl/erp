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
Contrat
</title>
<script>
var i=1;
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



function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no') 
}

function afficheContrat(){
	
  
	 var liste = document.getElementById('recherche');
    var R = liste.options[liste.selectedIndex].value; 
	
	var personnel = document.getElementById('P1').value;

	
    if(P1==""){
      alert("Personnel  !! ");
   }else{
	  $.ajax({
			url: '../php/affiche_contratR.php',
			type: 'POST',
			data: "recherche="+R+"&P1="+personnel,
			success:function(data){
				$('#div1').html(data);
				
			}}); 
   }
}

function rompreContrat() {
       if (confirm("Voulez-vous romre ce contrat ?")) { // Clic sur OK
            document.getElementById('form1').submit();
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

elseif($role=="GRH"){
include('../menu/menuGRH.php');	
}
else{
session_unset();
session_destroy();
header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


<!-- began --> 
<BR>
<p class="there">Rompre un contrat</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form method="post"  id="form1" action="../php/rompre_contrat.php">


<TABLE > 



<TR> 
 <TH>Personnel: </th>
 <td> 
   <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="recherche" id="recherche" type="text" class="custom-dropdown__select custom-dropdown__select--white">			
			<option value="nom">Nom</option>
			<option value="matricule">Matricule</option>
			<option value="NCIN">NCIN</option>
			</select>
	 </span>
 </Td> 
 </tr>
 <tr>
 
<td></td>
<td>
<input type="text" id="P1" name="P1" size="25" onBlur="hideListe('listeP1');" onKeyup="autoComplete('P1','listeP1'); " onFocus="autoComplete('P1','listeP1')"> 
<div class="divAuto2"><ul id="listeP1" ></ul></div>
</td>
 </tr>
 <tr id="TRF">
 <td></td>		

 <td><input type="button" onclick="afficheContrat();" id="add1" value="Submit >> ">
</Td></tr>



</table>
<div id="div1"></div>

</form>
</div>
</div>
</body>
</html>
