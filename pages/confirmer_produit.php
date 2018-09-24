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
Confirmer un produit
</title>
<script>
function afficheProduit(){
		 var liste = document.getElementById("PRD");
    var valeur = liste.options[liste.selectedIndex].value;

 if(produit==""){
	 alert("Entrez un produit SVP !!");
	
 }else{
$.ajax({
          type: 'POST',
          data : 'PRD=' + valeur ,
          url: '../php/produit_non_conf.php',
          success: function(data) {
		        
                $("#div1").html(data);   
           }});
 }
}


function ajout(){
	
document.forms['form1'].submit(); 	
 
}

function afficheCase(){
	
	if( $('input[name=check]').is(':checked') ){
		
	    document.getElementById('prix').style.backgroundColor='grey'; 
		document.getElementById('prix').disabled=true;
		
		
	}
	else{
		    document.getElementById('prix').style.backgroundColor='white'; 
			document.getElementById('prix').disabled=false;
	}
  
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

elseif($role=="FAB"){
include('../menu/menuFabriquation.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>



<!-- began --> 
<BR>
<p class="there">Confirmer un produit</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form  id="form1" name="form" method="POST" action="../php/dupliquer_produit.php">


<TABLE >
<tr>
 <TH >Produit NON Confirmée: </TH> 
 <td>
	<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
            <select name="PRD" id="PRD"  style="width:150px" class="custom-dropdown__select custom-dropdown__select--white" >
             <option value="s">---Selectionnez</option>
	<?php

   $sql=mysql_query("select  code_produit from  produit1 where statut='N'");
   while($data=mysql_fetch_array($sql)) {
  echo '<option value="'.$data["code_produit"].'">'.$data["code_produit"].'</option><br/>'; 
              }
?>
	</select>
	</span>
	
 <input type="button" id="submitbutton" value=">>" onclick="afficheProduit()"/> 
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
