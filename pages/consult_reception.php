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
Liste des receptions
</title>
<SCRIPT>
function afficheReception(){
var liste2 = document.getElementById("recherche");
var R = liste2.options[liste2.selectedIndex].value;

if (R !="supplier" ){
var val = document.getElementById("valeur").value;
}else{
var liste1 = document.getElementById("valeur");
var val = liste1.options[liste1.selectedIndex].value;
}
var liste2 = document.getElementById("statut");
var statut = liste2.options[liste2.selectedIndex].value;

$.ajax({
        type: 'POST',
        data: 'recherche='+R +'&valeur='+val+'&statut='+statut,
        url: '../php/consult_reception.php',
        success: function(data) {
        $('#div1').html(data);
       }});

}

//

function afficheA(art){

	 var article = art;
	 var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   {
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
			 window.open('../php/consult_article_reception.php','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=600,height=600,directories=no,location=no');


         }

      }
   };

   req.open("POST", "../php/consult_article_reception.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   req.send("reception=" + escape(article));

}
function printR(r){
$.ajax({
        type: 'POST',
        data: 'R1='+r ,
        url: '../tcpdf/print_reception2.php',
        success: function(data) {
        window.open('../tcpdf/print_reception2.php','win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no');
       }
	   });

}

/////Afficher zone de recherche
function afficheZone(){

 var liste = document.getElementById('recherche');
  var recherche = liste.options[liste.selectedIndex].value;
  if(recherche=="dateR" || recherche=="dateE"){
  $('#zone').html('<input type="date" id="valeur" name="valeur"> ');
  }else if (recherche=="supplier"){

	    $('#zone').html('	<span class="custom-dropdown custom-dropdown--white custom-dropdown--small"><select name="valeur" id="valeur"  style="width:220px" class="custom-dropdown__select custom-dropdown__select--white" ><option value="s">---Selectionnez</option> </select> </span> ');
        $.ajax({
        type: 'POST',

        url: '../php/listeFournisseur.php',
        success: function(data) {
        $('#valeur').html(data);
       }});

}else{
  $('#zone').html('<input type="text" id="valeur" name="valeur"> ');
  }

}
//////////////////





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
}
elseif($role=="FIN"){
include('../menu/menuFinance.php');
}elseif($role=="FIN2"){
include('../menu/menuFin2.php');
}elseif($role=="COM"){
include('../menu/menuCommercial.php');
}
elseif($role=="MAG2"){
include('../menu/menuMagazin2.php');
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


<p class="there">Liste des receptions</p>

<br>

<!-- end -->





<form method="post">

<TABLE BORDER="0">

<tr>
<TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Search : </TH>
<td>


 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="recherche" id="recherche" onChange="afficheZone();" class="custom-dropdown__select custom-dropdown__select--white">

       <option value="item"> Article</option>
       <option value="IDorder"> N° ordre</option>
			 <option value="IDreception"> N° reception</option>
	         <option value="IDshipment"> N° shipment</option>
			 <option value="supplier"> Fournisseur</option>
		     <option value="dateR"> Date reception</option>
			 <option value="dateE"> Date entrée</option>

   </select>
   </span></td>
   <td id="zone">
   <input type="text" name="valeur" id="valeur" size="15" OnFocus="focusZone();">
   </td>
    <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Statut: </TH>
 <td>
  <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="statut" id="statut" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a" selected>ALL</option>
			 <option value="waiting">Attente entrée stock </option>
		     <option value="received"> Reçue</option>
			 <option value="invoiced"> Facturée</option>

   </select>
   </span>

 <input type="button" id="submitbutton" value="OK" onclick="afficheReception();">
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
