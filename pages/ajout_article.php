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
New primary material
</title>

<script>
function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=700,height=700,directories=no,location=no') 
}
function afficheCase(){
    
		document.getElementById('add1').disabled=false;
		document.getElementById('typeA').disabled=false;
		
		
}	
function hideCase(){
    
		document.getElementById('add1').disabled=true;
		document.getElementById('typeA').disabled=true;
		
		
}		
		
function afficheliste(){

	var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
            var prd=document.getElementById("typeA");
           prd.innerHTML=req.responseText;
		   
              
         }	
        
      } 
   };
   
   req.open("POST", "../php/liste_typeA.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send(null);
 
}
</script>
</head>

<body onload="afficheliste()">



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
elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
else{
session_unset();
   session_destroy();
	 header('Location: ../deny.php');
}

?>
</div>
<div id='contenu'>
<br>

<p class="there">New primary material</p>




<br>

<!-- end --> 

<form method="post" action="../php/ajout_article.php">
<?php

include('../connexion/connexionDB.php');
?>

<TABLE BORDER="0"> 

		<TR> 
			<Th WIDTH=150 HEIGHT=30  ALIGN="left" >Primary material ID: </Th> 
			<TD colspan="3"><input type="text" name="code_article" SIZE="20"  colspan="2" placeholder="ID"></TD> 
			
		</TR> 
		<TR> 
			<TH WIDTH=150 HEIGHT=30  ALIGN="left">Description : </TH> 
			<TD colspan="3"><textarea placeholder="Description" name="desc" rows="4" cols="30"></textarea></TD> 
			
		</TR> 
  <TR> 
			<TH WIDTH=150 HEIGHT=30  ALIGN="left">Supplier : </TH> 
			<TD colspan="3"><span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
            <select name="four" id="four"  style="width:200px" class="custom-dropdown__select custom-dropdown__select--white">
               <option value="s">---Selectionnez</option>

<?php


$sql = "SELECT * FROM fournisseur1 ";
$res = mysql_query($sql) or exit(mysql_error());

while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["nom"].'">'.$data["nom"].'</option><br/>'; 
}


?>
            </select> 
            </span></TD> 
			
		</TR> 
		<tr>
  	<Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left">Type: </Th> 
			<TD>
			<input type="radio" name="catA" id="catAC" value="Consumable" onclick="hideCase();"  checked> Consumable<br>
			<input type="radio" name="catA" id="catAP" value="Production" onclick="afficheCase();"> Production 
 			
		    <select name="typeA" id="typeA" onFocus="afficheliste()" DISABLED><option value="s">---Selectionnez</option>
             </select> 
			 <input type="button" value="+" id="add1" onclick="pop_up('../pages/pop_ajout_type.php');" DISABLED><br> 
              
			 
			 
  </td>
  </tr>
		
  
<TR> 
 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Unit: </TH> 
 <TD colspan="3"> 
  <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="unit" id="unit" type="text" class="custom-dropdown__select custom-dropdown__select--white">
			<option value="pc">pc</option>
			<option value="Kg">Kg</option>
			<option value="m">m</option>
			<option value="g">g</option>
			<option value="L">L</option>
			</select>
			</span>	
 </TD>
</TR>
<TR> 
 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Price: </TH> 
 <TD colspan="3"> <input type="text" name="prix" SIZE="4" MAXLENGTH="30" placeholder="Price">
 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="dev" id="dev" type="text" class="custom-dropdown__select custom-dropdown__select--white">
			
			<option value="Euro">Euro</option>
			<option value="Dollar">Dollar</option>
			<option value="TND">TND</option>
			</select>
			</span>	
 </TD>
</TR>
<tr><td></td>
<td colspan=3>
 <input type="submit" value="Ajouter" id="submitbutton"> 
</td>

</TABLE> 




 
<p>

</p>
 
</form>


</div>

</div>

</body>

</html>