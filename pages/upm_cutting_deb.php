<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
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
UPM Crimping
</title>
<SCRIPT LANGUAGE="javascript"> 
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
   
   req.open("POST", "../php/affichePlanUPM_CUT.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("plan=" + escape(valeur));
	 
 }
}

////////////////////////////////////////////////////////////////
function ajoutUPMcutting1(){
		  var valeur1 = document.getElementById("plan").value;
		 var valeur2=document.getElementById("IDupmCUT").value;
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
   
   req.open("POST", "../php/ajoutUPMcutting1.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("valeur=" + escape(valeur));
	 
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
elseif($role=="UPM-CUT"){
include('../menu/menuUPM_CUT.php');	
}
elseif($role=="PRD"){
include('../menu/menuProduction.php');	
}elseif($role=="UPM3"){
include('../menu/menuUPM3.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Cutting</p>

<br>

<!-- end --> 





<form method="post">


<TABLE BORDER="0"> 

<tr>
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">N° Plan: </TH> 
 <td>
	  <input name="plan" id="plan" type="text" size="20" placeholder="Plan N°"> 
 <input type="button" id="submitbutton" value="OK" onclick="affichePlan()">  
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