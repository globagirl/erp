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
Découpage
</title>
<SCRIPT> 
function affichePlan(){

 var valeur = document.getElementById("plan").value;
 if(valeur==""){
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
   
   req.open("POST", "../php/affichePlan.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("plan=" + escape(valeur));
	 
 }
}

////
function verifierPlan(){
   
var p = document.getElementById("plan").value;

$.ajax({
        type: 'POST',
        data: 'plan='+p,
        url: '../php/verif_plan_decoup.php',
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
elseif($role=="DEC"){
include('../menu/menuDEC.php');	
}
elseif($role=="PRD"){
include('../menu/menuProduction.php');	
}
else{
	 //header('Location: ../deny.php');
	 include('../menu/menuDEC.php');
}
?>
</div>
<div id='contenu'>
<br>
<p class="there">Découpage</p>

<br>

<!-- end --> 





<form  name="pro_decoup" method="post" action="../php/ajoutDecoup1.php">
<table> 

<tr>
 <th>N° Plan: </th> 
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