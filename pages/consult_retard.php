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
Liste des retards
</title>
<SCRIPT> 
function consultRetard(){

var liste1 = document.getElementById("mois");
var val = liste1.options[liste1.selectedIndex].value;
var val2 = document.getElementById("year").value;
if(val=="s"){
alert("Selectionnez un mois SVP ");
}else{
$.ajax({
        type: 'POST',
        data: 'mois='+val+'&year='+val2,
        url: '../php/consult_retard.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	  
}
}
//
function afficheR(mat){

var liste1 = document.getElementById("mois");
 var val1 = liste1.options[liste1.selectedIndex].value;
 var val2 = document.getElementById("year").value;
 var val=val2+"-"+val1;
$.ajax({
        type: 'POST',
        data: 'mois='+val+'&mat='+mat,
        url: '../php/consult_liste_retard.php',
        success: function(data) {
        window.open('../php/consult_liste_retard.php','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=300,height=600,directories=no,location=no'); 
       }});

	 ////
	
	 
 
 //alert(article);
}

//Print Liste
function printRetard(){
 var liste1 = document.getElementById("mois");
 var val = liste1.options[liste1.selectedIndex].value;

if(val=="s"){
alert("Selectionnez un mois SVP ");
}else if (val2==""){
alert("Donnez le total des minutes de travail du mois ");
}else{
	document.form1.action="../tcpdf/print_salaire.php";
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


<p class="there">Liste des retards</p>

<br>

<!-- end --> 





<form method="post" name="form1" id="form1">
<?php
include('../connexion/connexionDB.php');
?>
<br>
<hr>
<TABLE BORDER="0"> 

<tr>
 <TH> Mois: </TH> 
 
 <td style="width:50px">
 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="mois" id="mois" type="text" class="custom-dropdown__select custom-dropdown__select--white">
			
			<option value="s">--Sélectionnez</option>
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

 <td></td>
 <td colspan=2><input type="button" id="submitbutton" value=">>" onclick="consultRetard()">  
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