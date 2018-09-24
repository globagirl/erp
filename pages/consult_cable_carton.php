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
cable par cartons
</title>
<SCRIPT LANGUAGE="javascript"> 
function afficheListe(){
		 var liste1 = document.getElementById("recherche");
 var val1 = liste1.options[liste1.selectedIndex].value;
  var val2=document.getElementById("valeur").value;

 var valeur=val1+"|"+val2;
 
 if(val1=="s"){
	 alert("Selectionnez un mode de recherche SVP !!");

	
 }
 else{
	 
	 var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
          var prd=document.getElementById("div1");
          prd.innerHTML=req.responseText;
		   //var vvv=req.responseText;
		   //alert(vvv);
		  
         }	
        
      } 
   };
   
   req.open("POST", "../php/consult_cable_carton.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("valeur=" + escape(valeur));
	 
 }
 //alert(valeur);
}

////////////////////////////////////////////////////////////////
function afficheZone(){
		 var liste1 = document.getElementById("recherche");
 var val1 = liste1.options[liste1.selectedIndex].value;
  if(val1=='a'){
	 document.getElementById('valeur').disabled = true;
 }
 else {
	 document.getElementById('valeur').disabled = false;
	 document.getElementById("valeur").value="";
 }
 
}
function print(){
document.forms['form1'].submit(); 
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

elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}
elseif($role=="PRD"){
include('../menu/menuProduction.php');	
}else if($role=="QLT"){
include('../menu/menuQualite.php');	
}

else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Qunatité de cable par cartons</p>

<br>

<!-- end --> 





<form method="post" id="form1" action="../tcpdf/cable_par_carton.php">

<p style="float:right"><img src="../image/print.png" onclick="print();" alt="Print" style="cursor:pointer;" width="60" height="50"  /></p>
<TABLE BORDER="0"> 

<tr>
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Recherche: </TH> 
 <td>
 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="recherche" id="recherche" onChange="afficheZone();" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a"> ALL</option>
	         <option value="long"> Longeur</option> 
			 <option value="qteB">Quantité par box </option> 
			 <option value="tlot"> Taille de lot</option> 
		     <option value="nbrP"> Nombre paquet</option> 
			 

   </select> 
   </span>
   <input type="text" name="valeur" id="valeur" size="15" OnFocus="focusZone();" disabled>
    
 <input type="button" id="submitbutton" value="OK" onclick="afficheListe()">  
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