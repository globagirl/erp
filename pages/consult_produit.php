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
Consulter Produit
</title>
<SCRIPT>
function afficheProduit(){
 var liste1 = document.getElementById("recherche");
 var recherche = liste1.options[liste1.selectedIndex].value;

if (recherche !="categorie"){
var val = document.getElementById("valeur").value;
}else{
var liste1 = document.getElementById("valeur");
var val = liste1.options[liste1.selectedIndex].value;
}

$.ajax({
        type: 'POST',
        data: 'recherche='+recherche +'&valeur='+val ,
        url: '../php/consult_produit.php',
        success: function(data) {
        $('#div1').html(data);
       }});

}
/////
function afficheZone(){

 var liste = document.getElementById('recherche');
  var recherche = liste.options[liste.selectedIndex].value;
  if(recherche !="categorie"){
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

///
	function afficheArt(prd){
	   $.ajax({
        type: 'POST',
        data:'valeur='+prd,
        url: '../php/consult_article_produit.php',
        success: function(data) {
        window.open('../php/consult_article_produit.php','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=500,height=300,directories=no,location=no,left=200,top=200');
       }});
	//

}
	//Fichier excel
function excelProduit(){
	document.form1.action="../php/excel_produit.php";
    document.form1.submit();
}
//Print Invoice
function printProduit(){
	document.form1.action="../tcpdf/print_produit.php";
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

else if($role=="LOG"){
include('../menu/menuLogistique.php');
}else if($role=="COM"){
include('../menu/menuCommercial.php');
}else if($role=="QLT"){
include('../menu/menuQualite.php');
}else if($role=="FIN"){
include('../menu/menuFinance.php');
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Consulter Produit</p>

<br>

<!-- end -->





<form method="post" id="form1" name="form1">

<p style="float:right"><img src="../image/print.png" onclick="printProduit();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
<img src="../image/excel.png" onclick="excelProduit();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p>
<TABLE BORDER="0">

<tr>
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Recherche: </TH>
 <td>
 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="recherche" id="recherche" onChange="afficheZone();" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a"> ALL</option>
	         <option value="code_produit"> Produit</option>
             <option value="Article">Article </option>
			 <option value="categorie">Catégorie </option>
			 <option value="longueur">Longueur</option>
			 <option value="taille_lot">Taille du lots </option>
			 <option value="revision">Revision </option>



   </select>
   </span>
   </td>
   </tr>
   <tr><td></td>
   <td id="zone">
   <input type="text" name="valeur" id="valeur" size="15"  disabled>
   </td>
   </tr>
	  <tr><td></td><td>
 <input type="button" id="submitbutton" value=" >> " onclick="afficheProduit()">
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
