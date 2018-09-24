<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
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
Dupliquer Produit
</title>
<script>
function afficheProduit(){
		 var produit = document.getElementById("produit").value;

 if(produit==""){
	 alert("Entrez un produit SVP !!");
	
 }
 else{
var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
           var prd=document.getElementById("dup");
           prd.innerHTML=req.responseText;
		  
         }	
        
      } 
   };
   
   req.open("POST", "../php/afficheProduitD.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("produit=" + escape(produit));
 }
}
///
//afficher Taille du lot selon longueur 
function verifierL(){
var val=document.getElementById('long').value;
	var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
            
          var R=req.responseText;
		  if(R=="0"){
			  alert("Cette longueur n'exite pas , veillez l'ajouter SVP !!");
			  document.getElementById('long').style.backgroundColor='pink'; 
   }
   else{
	   var x = R.indexOf("|");
	   var nbr=R.substr(0,x);
	   var l=R.length;
	   var lot=R.substr(x+1,l);
	   document.getElementById("nbrB").value=nbr;
	   document.getElementById("tlot").value=lot;
   }
  
		   
              
         }	
        
      } 
   };
   
   req.open("POST", "../php/verifierLongProduit.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("long=" + escape(val));
} 

///
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
}elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>



<!-- began --> 
<BR>
<p class="there">Dupliquer Produit</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>
<br>
<br>

<form  id="form1" name="form" method="POST" action="../php/dupliquer_produit.php">


<TABLE >
<tr>
 <TH>Code Produit: </TH> 
 <td>
	<input type="text" name="produit" id="produit" size="20" placeholder="Code produit"/>
 <input type="button" id="submitbutton" value=">>" onclick="afficheProduit()"/> 
 </td>
		
		</tr>
 
</TABLE > 
<div id="dup">
</div>
</form>
</div>
</div>


</body>

</html>
