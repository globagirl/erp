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
Stock Entry
</title>
<script>
function affiche_article(){

   var liste = document.getElementById("reception");
 var valeur = liste.options[liste.selectedIndex].value;
 affiche_info();
	var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
			 affiche_info();
			 	  var tab=document.getElementById("add1");
         tab.style.visibility ="visible";
		  
            var ar=document.getElementById("arts");
           ar.innerHTML=req.responseText;
              
         }	
        
      } 
   };
   
   req.open("POST", "../php/affiche_article_recue.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("reception=" + escape(valeur)); //envoyer des données 
  

	
}
/// Affichage des info de la reception
function affiche_info(){

   var liste = document.getElementById("reception");
 var valeur = liste.options[liste.selectedIndex].value;
	var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
			  
            var ar1=document.getElementById("div1");
           ar1.innerHTML=req.responseText;
              
         }	
        
      } 
   };
   
   req.open("POST", "../php/affiche_info_reception.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("reception=" + escape(valeur)); //envoyer des données 
  }

////////////
function goo(){
	 var liste = document.getElementById("reception");
 var recep = liste.options[liste.selectedIndex].value;
 var valeur = recep;
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
			
		 var ar2=document.getElementById('div2');
           ar2.innerHTML=req.responseText;
		     var tab=document.getElementById("add2");
         tab.style.visibility ="visible";
            
            //document.location.href=req.responseText;*/
		//var aff= req.responseText;
		 //alert(aff);
		             }  
              
         	
        
      } 
   };
   
   req.open("POST", "../php/ajout_stock.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("reception=" + escape(valeur));
  }
	else{
		alert("Selectionnez un numéro de reception SVP !!");
	}
	
}


///////////////////////////////////
function goo2(){
	 var liste = document.getElementById("reception");
 var recep = liste.options[liste.selectedIndex].value;
 var valeur = recep;
  var elem=document.getElementById('div2');
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
elseif($role=="MAG"){
include('../menu/menuMagazin.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Stock Entry</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form method="post"  id="form1">


<TABLE > 

		<TR> 
			<Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left" colspan="5">N° Reception: </Th> 
			<TD colspan="2" >
			 <select name="reception" id="reception">
			 <option value="s">---Selectinnez</option>
<?php
$sql = "SELECT * FROM reception_ordre_achat1 where statut='waiting'";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["idRO"].'">'.$data["idRO"].'</option><br/>'; 
}

?>
   </select> 
   <input type="button" onclick="affiche_article()" id="submitbutton" value="OK">
   
			</TD> 
			
			<td></td>
	
	
	
		</TR> 
  </table>
  <div id="div1"></div>
  
	
<table>

<TR> 

 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left" colspan="8" style="text-align:center">Articles:  </TH> 
  
 </tr>
 </table>


<div id="arts" style="text-align:center">
</div>



  <input type="button" onclick="goo()" id="add1" value="Suivant >>" style="visibility:hidden" style="float:right"> 

<hr size=2 />
<div id="div2" style="text-align:center">
</div>
<hr size=2 />
<input type="button" onclick="goo2()" id="add2" value="  Valider " style="visibility:hidden" style="float:right">

</div>
</div>
</body>
</html>