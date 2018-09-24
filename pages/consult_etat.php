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
Etat salaire
</title>
<SCRIPT> 
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

function printEtat(){
 var liste1 = document.getElementById("mois");
 var val = liste1.options[liste1.selectedIndex].value;
 var liste = document.getElementById('recherche');
 var R = liste.options[liste.selectedIndex].value;
 var personnel = document.getElementById('P1').value;
 if(val=="s"){
   alert("Selectionnez un mois");
 }else if (personnel==""){
   alert("Donnez un personnel SVP");
 }else{
	document.form1.action="../tcpdf/print_etat.php";
    document.form1.submit(); 
 }
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


<p class="there">Etat salaire</p>

<br>

<!-- end --> 





<form method="post" name="form1" id="form1">
<br>
<hr>
<table> 

<tr>
 <th style="width:200px"> Mois: </th> 
 
 <td style="width:100px">
 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="mois" id="mois" type="text" class="custom-dropdown__select custom-dropdown__select--white">
			
			<option value="01">Janvier</option>
			<option value="02">Février</option>
			<option value="03">Mars</option>
			<option value="04">Avril</option>
			<option value="05">May</option>
			<option value="06">Juin</option>
			<option value="07">Juillet</option>
			<option value="08">Aout</option>
			<option value="09">Septembre</option>
			<option value="10">Octobre</option>
			<option value="11">Novembre</option>
			<option value="12">Décembre</option>
			
			
			</select>
			</span>	 
 </td>
<?php
$date=date("Y-m-d");
$date= strtotime($date);
$year= strftime("%Y",$date);
 ?>
 <td><input type="text" size="10" placeholder="Year" name="year" id="year" value="<?php echo $year ; ?>"></td>
 </tr>
<TR> 
 <TH>Personnel: </th>
 <td colspan=2> 
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
<td colspan=2>
<input type="text" id="P1" name="val" size="25" onBlur="hideListe('listeP1');" onKeyup="autoComplete('P1','listeP1'); " onFocus="autoComplete('P1','listeP1')"> 
<div class="divAuto2"><ul id="listeP1" ></ul></div>
</td>
 </tr>

<tr>
 <td></td>
 <td colspan=2 ><input type="button" id="submitbutton" value=">>" onclick="printEtat()">  
 </td>
 </tr>
 </table>
 <div id="div1"> </div>
 
</form>


</div>


</div>
</body>

</html>