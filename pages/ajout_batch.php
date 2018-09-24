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
Add batch
</title>
<script>
function affiche_paquet(){

   var valeur = document.getElementById("reception").value;
// var valeur = liste.options[liste.selectedIndex].value;
 
	var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
			 
            var ar=document.getElementById("arts");
           ar.innerHTML=req.responseText;
              
         }	
        
      } 
   };
   
   req.open("POST", "../php/affiche_paquet.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("reception=" + escape(valeur)); //envoyer des données 
  

	
}

////////////
function goo(){
	 var recep = document.getElementById("reception").value;
 //var recep = liste.options[liste.selectedIndex].value;
 var valeur = recep;
  var elem=document.getElementById('arts');
	if(elem.hasChildNodes()){
		
		var nbr = elem.childNodes.length;
		var i=1;
		var j=1;
		var val="";
		while(i<nbr){
			if(j<3){
			val=elem.childNodes[i].value;
			valeur=valeur+"|"+val;
			i=i+2;
			j=j+1;
			}
			else{
			
				i=i+2;
				valeur=valeur+"*";
				j=1;
			}
		
				
		}
		var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
            
            document.location.href=req.responseText;
		//var aff= req.responseText;
		 //alert(aff);
		             }  
              
         	
        
      } 
   };
   
   req.open("POST", "../php/ajout_batch.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("reception=" + escape(valeur));
  }
	else{
		alert("Selectionnez un numéro de reception SVP !!");
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

elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<!-- began --> 
<BR>
<p class="there">Add batch</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form method="post"  id="form1">


<TABLE > 

		<TR> 
			<Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left" >N° Reception: </Th> 
			<TD colspan="4">
			<input type="text" name="reception" id="reception" size="20"/>
			
   <input type="button" onclick="affiche_paquet()" id="submitbutton" value="OK">
   
			</TD> 
		
	
		</TR> 
  
  
	


<tr> 

 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left" colspan="7" style="text-align:center">Paquets:  </TH> 
 </tr>
 <tr>
<td colspan="8" style="text-align:center">

<div id="arts"></div>
</td> 
 </tr>




</table>
<input type="button" onclick="goo()" id="submitbutton" value="Valider">
</div>
</div>
</body>
</html>