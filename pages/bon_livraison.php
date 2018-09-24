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
function afficheBL(){
 var liste1 = document.getElementById("PO");
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
   
   req.open("POST", "../php/afficheBL.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("PO=" + escape(valeur));
 }
 
}

function ajoutBL(F,t){
	var OF=F;
 
	$.ajax({
          type: 'POST',
          data : 'OF='+OF,
          url: '../php/ajoutBL.php',
          success: function(data) {
			  if(data=="OK"){
				  var tab= "#"+t;
			  $(tab).remove();  
			  }else{
				  alert(data);
			  }
			 
			
               
           }});
	
}
</script>
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

elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
?>
</div>
<div id='contenu'>
<!-- began --> 
<BR>
<p class="there">Bon de livraison</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form method="post"  id="form1">


<TABLE >
<tr>
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">N° PO: </TH> 
 <td>
	 <select name="PO" id="PO">
			 <option value="s">---Selectinnez</option>
<?php
$sql = "SELECT PO FROM commande2 where statut='shipped' or statut='incomplete'";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["PO"].'">'.$data["PO"].'</option><br/>'; 
}

?>
   </select> 
 <input type="button" id="submitbutton" value="OK" onclick="afficheBL()"/> 
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
