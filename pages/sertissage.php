<?php
session_start ();
$role=@$_SESSION['role'];
$userID=@$_SESSION['userID'];
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
Sertissage
</title>
<SCRIPT> 
function affichePlan(){
		 
 var valeur = document.getElementById("plan").value;
 if(valeur=="s"){
	 alert("Selectionnez un plan SVP !!");

	
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
		  
         }	
        
      } 
   };
   
   req.open("POST", "../php/affichePlanSE.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("plan=" + escape(valeur));
	 
 }
}

////////////////////////////////////////////////////////////////
function ajoutSertissage1(){
	var valeur1 = document.getElementById("plan").value;
		 var valeur2=document.getElementById("IDsert").value;
		  var valeur3=document.getElementById("dateH").value;
		   var valeur4=document.getElementById("PO").value;
		   var valeur5=document.getElementById("qtE").value;
		  var valeur=valeur1+"|"+valeur2+"|"+valeur3+"|"+valeur4+"|"+valeur5;
 
 if(valeur=="s"){
	 alert("Selectionnez un plan SVP !!");

	
 }
 else{
	 var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
          document.location.href=req.responseText;
		  
         }	
        
      } 
   };
   
   req.open("POST", "../php/ajoutSertissage1.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("valeur=" + escape(valeur));
	 
 }
}

////
function verifierPlan(){
   
var p = document.getElementById("plan").value;

$.ajax({
        type: 'POST',
        data: 'plan='+p,
        url: '../php/verif_plan_sertiss.php',
        success: function(data) {
		
        if(data=="0"){
		alert("Plan existe déja !!");
		}else{
		affichePlan();
		}
       }});
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
elseif($role=="SRT"){
include('../menu/menuSRT.php');	
}
elseif($role=="PRD"){
include('../menu/menuProduction.php');	
}
else{
	 //header('Location: ../deny.php');
	 include('../menu/menuSRT.php');	
}
?>
</div>
<div id='contenu'>
<br>

<p class="there">Sertissage</p>

<br>

<!-- end --> 





<form  name="pro_decoup" method="post">
<?php
include('../connexion/connexionDB.php');
?>

<TABLE BORDER="0"> 

<tr>
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">N° Plan: </TH> 
 <td>
	<input name="plan" id="plan" type="text" size="20" placeholder="Plan N°">
 <input type="button" id="submitbutton" value="OK" onclick="verifierPlan()"/></div>  
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