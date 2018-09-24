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
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<title>
Consulter Paquet
</title>
<SCRIPT > 
function affichePaquet(){

  var valeur=document.getElementById("valeur").value;
 
	 
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
   
   req.open("POST", "../php/consult_paquet.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("paq=" + escape(valeur));

}

			   
</SCRIPT> 
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


<p class="there">Consulter Paquet</p>

<br>

<!-- end --> 





<form method="post">
<?php
include('../connexion/connexionDB.php');
?>

<TABLE BORDER="0"> 

<tr>
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Paquet: </TH> 
 <td>
 
   <input type="text" name="valeur" id="valeur" size="30" >
   
	
 <input type="button" id="submitbutton" value="OK" onclick="affichePaquet();">  
 </td>
 </tr>
 </table>
 <div id="div1">
 <?php
 echo(" <TABLE >

<tr><td> Code paquet</td>
<td> Code article</td>
<td>Batch  </td>
<td>Stock </td></tr>");
	
$sql = mysql_query("SELECT * FROM paquet2 where qte_res>0 ");
 while($data=mysql_fetch_array($sql)){
	 
	  $art=$data['IDarticle'];
	 $sql1 = mysql_query("SELECT * FROM article1 where code_article='$art'");
	$data1=mysql_fetch_array($sql1);
	
	echo("<TR>
	<td  HEIGHT=30> ".$data['IDpaquet']."</td><td>".$data['IDarticle']." </td>
<td>".$data['batch']." </td>
<td style=\"background-color:pink\" >".$data['qte_res']." ".$data1['unit']."</td>
</tr>"); 
 }
echo("</table>");
?>	
 </div>
 
</form>


</div>


</div>
</body>

</html>