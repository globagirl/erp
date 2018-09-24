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
Dupliquer produit
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
           var prd=document.getElementById("div1");
           prd.innerHTML=req.responseText;
		  
         }	
        
      } 
   };
   
   req.open("POST", "../php/afficheProduitD.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("produit=" + escape(produit));
 }
}


function dupliquerProduit(){
	
		 var val1 = document.getElementById("code_produit").value;
		 var val2 = document.getElementById("desc").value;
		 var val3 = document.getElementById("cat").value;
		 var val4 = document.getElementById("rev").value;
		 var val5 = document.getElementById("prix").value;
		 var val6 = document.getElementById("devise").value;
		 var val7 = document.getElementById("tlot").value;
		 var val8 = document.getElementById("nbrB").value;
		 var val9 = document.getElementById("r").value;
		 var val10 = document.getElementById("v").value;
		 var val11 = document.getElementById("b").value;
		 var val12 = document.getElementById("long").value;
		var nbr=document.getElementById("nbrA").value;
		 var valeur1=val1+"|"+val2+"|"+val3+"|"+val4+"|"+val5+"|"+val6+"|"+val7+"|"+val8+"|"+val9+"|"+val10+"|"+val11+"|"+val12;
		
		 var valeur2="";
		   
			
		for (var i = 1; i<= nbr; i++) {
            var art="ar"+i;
            var qte="qte"+i;
            var article = document.getElementById(art).value;
	        var qtA = document.getElementById(qte).value;
	        valeur2=valeur2+"|"+article+"|"+qtA;
           }
         var valeur=valeur1+"|"+valeur2;
      if(valeur==""){
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
             window.close();
		  
         }	
        
      } 
   };
   
   req.open("POST", "../php/dupliquerProduit.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("valeur=" + escape(valeur));
 }
 
}

</script>
</head>

<body>


<!-- began --> 
<BR>
<p class="two">Dupliquer Produit</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form >


<TABLE >
<tr>
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Code Produit: </TH> 
 <td>
	<input type="text" name="produit" id="produit" size="10" />
 <input type="button" id="submitbutton" value="OK" onclick="afficheProduit()"/> 
 </td>

 
	<td ALIGN="right">
	  <input type="button" id="submitbutton" value="Dupliquer" onclick="dupliquerProduit()"/> 
</td>	
			
		</tr>
 
</TABLE > 
<div id="div1">
</div>
</form>



</body>

</html>
