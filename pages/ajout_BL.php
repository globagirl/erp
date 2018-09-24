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
Bon de livraison
</title>
<script>
var x=0;
var i=0;
function afficheBL(){
 var liste1 = document.getElementById("client");
 var valeur = liste1.options[liste1.selectedIndex].value;
 if(valeur=="s"){
 alert("Selectionnez une commandeSVP !!");
	
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
   
   req.open("POST", "../php/affiche_BL.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("client=" + escape(valeur));
 }
 
}
////ADD PO to BL
function ajoutPO(){

 var PO = document.getElementById("PO").value;

 
	$.ajax({
          type: 'POST',
          data : 'PO='+PO+'&nbr='+x,
          url: '../php/affiche_PO_BL.php',
          success: function(data) {
			 
			  $("#TR1").after(data);  
			 var row = document.getElementById('tab').rows;
             var r=row.length;
             r=(r-x)-2;
			x=r+x+i;
               
           }});
	}
//Delete PO/OF  	
function deleteZ(Z){

 var z1="#"+Z;
		$(z1).remove();
   i++;
	}
//
function ajoutBL(){

document.getElementById('nbr').value=x;
var tab =document.getElementById("tab").rows;
var longT = tab.length;
if(longT>2){
document.forms['form1'].submit(); 
}else {
alert("Ajouter une commande SVP ");
}	
}	
//Désactiver enter
function desactiveEnter(){ 
 if (event.keyCode == 13) { 
      event.keyCode = 0; 
      window.event.returnValue = false; 
 } 
} 	
</script>
</head>

<body onKeyDown="desactiveEnter()" >


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

elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
elseif($role=="CONS"){
  include('../menu/menuConsommable.php');	
  }
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<!-- began --> 
<BR>
<p class="there">Bon de livraison</p>




<br>

<!-- end --> 



<form method="post"  id="form1" name="form1" action="../php/ajout_BL.php">


<TABLE >
<tr>
 <th>Client: </th> 
 <td>
  <span class="custom-dropdown custom-dropdown--white custom-dropdown--small" >
	 <select name="client" id="client" class="custom-dropdown__select custom-dropdown__select--white" >
			 <option value="s">---Selectinnez</option>
<?php
include('../connexion/connexionDB.php');
$sql = "SELECT name_client,nomClient FROM client1";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["name_client"].'">'.$data["nomClient"].'</option><br/>'; 
}
mysql_close();
?>
   </select> 
   </span>
 <input type="button" id="submitbutton" value=">>" onclick="afficheBL()"/> 
 <input type="text" id="nbr" name="nbr" hidden> 
 </td>

 

			
		</tr>
 
</TABLE > 
<div id="div1">
</div>
</form>

</div>
</div>

</body>

</html>
