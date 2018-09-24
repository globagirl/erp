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
Receipt purchase order
</title>
<script>

/// derterminer le num"ro de la reception
function codeReception(){
var liste = document.getElementById("ordre");
 var valeur = liste.options[liste.selectedIndex].value;
	var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
            
          var R=req.responseText;
		  
 
	   document.getElementById("idRO").value=R;
   }

		   
              
         }	
        
       
   };
   
   req.open("POST", "../php/code_reception.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("ordre=" + escape(valeur));
 
}
function affiche_article(){
 var d = document.getElementById("dateR").value; 
 var liste = document.getElementById("ordre");
 var valeur = liste.options[liste.selectedIndex].value;
 if(valeur=="s"){
	 alert("Choisissez un ordre d'achat  SVP !!")
 }
 else if(d==""){
	 alert("Donnez la date Reception de l'ordre d'achat SVP !!")
 }
 else{

   
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
   
   req.open("POST", "../php/affiche_article_ordre.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("ordre=" + escape(valeur)); //envoyer des données 
   	 
 }
}
function goo(){
	 var liste = document.getElementById("ordre");
 var valeur = liste.options[liste.selectedIndex].value;

 var codeC=document.getElementById("codeC").value;
 var idRO = document.getElementById("idRO").value;
 var dateR=document.getElementById("dateR").value;
	valeur=valeur+"|"+idRO+"|"+codeC+"|"+dateR;
  var elem=document.getElementById('arts');
	if(elem.hasChildNodes()){
		
		var nbr = elem.childNodes.length;
		var i=1;
		var j=1;
		var val="";
		while(i<nbr){
			if(j<5){
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
		// alert(aff);
		  
		             }  
              
         	
        
      } 
   };
   
   req.open("POST", "../php/ajout_reception_ordre.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("ordre=" + escape(valeur));
  }
	else{
		alert("Selectionnez un ordre d'achat SVP !!");
	}
}
////////////

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
include('../menu/menuAdmin.php');
?>
</div>
<div id='contenu'>
<br>

<p class="there"> Receipt purchase order </p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form method="post"  id="form1">


<TABLE > 

		<TR> 
			<Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left" >N° ordre d'achat: </Th> 
			<TD colspan="4">
			 <select name="ordre" id="ordre" onChange="codeReception();">
			 <option value="s">---Selectinnez </option>
<?php
$sql = "SELECT * FROM ordre_achat2 where (statut='waiting') OR (statut='waitingS') OR (statut='waitingE')";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["IDordre"].'">'.$data["IDordre"].'</option><br/>'; 
}

?>
   </select> 
   
  
			</TD> 
			<Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left" >N° reception: 
		 
		</Th> 
		<td><input type="text" name="idRO" id="idRO" readonly /></td>
		
		<td><input type="button" onclick="affiche_article()" id="submitbutton" value="OK"></td>
	
		</TR> 
		<tr>
		<Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left" colspan="2">N°expedition client: </Th> 
		<td colspan="2"><input type="text" size="15" name="codeC" id="codeC"/></td>
		<Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left" colspan="2">Date reception: </Th> 
		<td colspan="2"><input type="date" size="10" name="dateR" id="dateR"/></td>
		
		</tr>
  
  
	


<TR> 
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left" colspan="8" style="text-align:center">Articles:  </TH> 
 
 </tr>
 <tr>
<td colspan="8" style="text-align:center">

<div id="arts"></div>
</td>


 
 </tr>
 <tr><th colspan="7"></th><td>  <input type="button" onclick="goo()" id="submitbutton" value="Valider"> </td><tr>




</table>
</div>
</div>
</body>
</html>