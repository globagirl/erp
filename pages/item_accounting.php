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
Item accounting
</title>
<SCRIPT> 
function afficheRevenu(){


var liste = document.getElementById('recherche');
var recherche = liste.options[liste.selectedIndex].value;

if (recherche !="cat"){
var val = document.getElementById("valeur").value;
}else{
var liste1 = document.getElementById("valeur");
var val = liste1.options[liste1.selectedIndex].value;
}

$.ajax({
        type: 'POST',
        data: 'recherche='+recherche +'&valeur='+val,
        url: '../php/item_accounting.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	  
}
//
function afficheZone(){

 var liste = document.getElementById('recherche');
  var recherche = liste.options[liste.selectedIndex].value;
  if(recherche !="cat"){
if(recherche =="a"){
  $('#zone').html('<input type="text" id="valeur" name="valeur" DISABLED> ');
  }else{
  $('#zone').html('<input type="text" id="valeur" name="valeur"> ');
  }
  }else{
		
	    $('#zone').html('	<span class="custom-dropdown custom-dropdown--white custom-dropdown--small"><select name="valeur" id="valeur"  style="width:220px" class="custom-dropdown__select custom-dropdown__select--white" ><option value="s">---Category</option> </select> </span> ');
        $.ajax({
        type: 'POST',
      
        url: '../php/listeCatProduit.php',
        success: function(data) {
        $('#valeur').html(data);
       }});
	   
}
}


//Fichier excel
function excelProfit(){
	document.form1.action="../php/excel_item_accounting.php";
    document.form1.submit(); 
}
//Print Invoice
function printProfit(){
	document.form1.action="../tcpdf/print_item_accounting.php";
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
elseif($role=="FIN"){
include('../menu/menuFinance.php');	
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


<p class="there">Item accounting </p>

<br>

<!-- end --> 





<form method="post" name="form1" id="form1">
<?php
include('../connexion/connexionDB.php');
?>
<p style="float:right"><img src="../image/print.png" onclick="printProfit();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
<img src="../image/excel.png" onclick="excelProfit();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p>
<TABLE BORDER="0"> 

<tr>
 <TH>Search: </TH> 

  
 <td>
  <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="recherche" id="recherche" onChange="afficheZone();" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a">ALL</option>			
	         <option value="item">Item ID</option> 		     
	         <option value="cat">Item category</option> 		     
			 <option value="long">Item length</option> 		     
			

   </select> 
   </span>
 </td>
 </tr>
 <tr>
 <td></td>
 <td id="zone">
<input type="text" name="valeur" id="valeur" DISABLED>
 </td></tr>
 
 <tr>
 <td></td>
 <td colspan=2><input type="button" id="submitbutton" value=">>" onclick="afficheRevenu()">  
 </td>
 </tr>
 </table>
 <div id="div1">
 </div>
 <div id="div2">
 <p id="p2"></p>
 </div>
 
</form>


</div>


</div>
</body>

</html>