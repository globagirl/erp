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
Check receipt order
</title>
<script>
function affiche_article(){

   var liste = document.getElementById("reception");
 var valeur = liste.options[liste.selectedIndex].value;
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
   
   req.open("POST", "../php/affiche_article_reception.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("reception=" + escape(valeur)); //envoyer des données 
  

	
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
include('../menu/menuAdmin.php');
?>
</div>
<div id='contenu'>
<br>


<p class="there">Check receipt order</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form method="post"  id="form1" action="../php/verification_reception_ordre.php">


<TABLE > 

		<TR> 
			<Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left" >N° reception: </Th> 
			<TD colspan="4">
			 <select name="reception" id="reception">
			 <option value="s">--Selectinnez</option>
<?php
$sql = "SELECT * FROM reception_ordre_achat1 where statut='received'";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["idRO"].'">'.$data["idRO"].'</option><br/>'; 
}

?>
   </select> 
   <input type="button" onclick="affiche_article()" id="submitbutton" value="OK">
   
			</TD> 
		<td> <input type="submit" id="submitbutton" value="Valider"></td>
	
		</TR> 
  

</table>
<div id="arts"></div>
</div>
</div>
</body>
</html>