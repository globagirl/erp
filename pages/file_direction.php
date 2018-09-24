<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
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
Direction Files
</title>
<SCRIPT> 
function listeFiles(){
		 var liste1 = document.getElementById("recherche");
         var val1 = liste1.options[liste1.selectedIndex].value;
         var val2=document.getElementById("valeur").value;
          $.ajax({
        type: 'POST',
        data : 'recherche=' + val1+'&valeur=' + val2,
        url: '../php/file_direction.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	  // alert("chafamma ?")


}

////////////////////////////////////////////////////////////////
function afficheZone(){
		 var liste1 = document.getElementById("recherche");
 var val1 = liste1.options[liste1.selectedIndex].value;
  if(val1=='Procedure'){
	 document.getElementById('valeur').disabled = true;
 }

 else if(val1=='Process'){
	 document.getElementById('valeur').disabled = true;
	 
 }  else if(val1=='Registry'){
	 document.getElementById('valeur').disabled = true;
	 
 }else if(val1=='Others'){
	 document.getElementById('valeur').disabled = true;
	 
 } else{
	 document.getElementById('valeur').disabled = false;
	 document.getElementById("valeur").value="";
 }
 
}

function deleteFile(d,f){

 if(confirm("Voulez-vous vraiment supprimer ce fichier?")){
 var t="directionfiles";
 $.ajax({
          type: 'POST',
          data : 'D=' + d+'&F=' + f +'&T=' + t,
          url: '../php/delete_file.php',
          success: function(data) {
		     	
	         listeFiles();
           }});
 }
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

elseif($role=="MAN"){
include('../menu/menuManagement.php');	
}
elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Direction Files</p>

<br>

<!-- end --> 





<form method="post" action="../php/file_quality.php">
<?php
include('../connexion/connexionDB.php');
?>

<TABLE BORDER="0"> 

<tr>
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Recherche: </TH> 
 <td>
 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="recherche" id="recherche" onChange="afficheZone();" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a">ALL</option>
	         <option value="Procedure">Procedure</option> 
			 <option value="Process"> Process</option> 
			 <option value="Registry"> Registry</option> 
		     <option value="Others"> Others</option> 
			

   </select> 
   </span>
   <input type="text" name="valeur" id="valeur" size="15" placeholder="File ">
 
 <input type="button" id="submitbutton" value="OK" onclick="listeFiles();">  
 </td>
 </tr>
 </table>
 <div id="div1">
 <?php
         $req= "SELECT * FROM directionfiles";
     

  $r=mysql_query($req) or die(mysql_error());
 
   echo"<table border=\"1\" bordercolor=\"BLUE\" ><tr>
  <td style=\"text-align:center\" width=250><b>File name</b> </td>
  <td colspan=2 style=\" text-align:center\" width=250><B>Description</b></td>
  <td style=\" text-align:center\"><b>Path</b></td>
  <td colspan=2></td>
 
  </tr>";
  while($a=mysql_fetch_object($r))
    {
    $nameF = $a->nameF;
    $desc = $a->description;
	$dossierF= $a->dossierF;
	$dataF= $a->dataF;
	
    echo"<tr><td style=\"text-align:center\">$nameF</td><td colspan=2 style=\"text-align:center\">$desc</td>
	<td style=\"text-align:center\"> Direction/$dossierF/ </td>
	<td style=\"text-align:center\"><a href=\"../files/managementFiles/Direction/".$dossierF."/".$nameF."\" ><img src=\"../image/viewFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a> </td>
	<td style=\"text-align:center\"><a href=\"#\" onClick=deleteFile('".$dataF."','".$nameF."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>";
    }
  echo '</table>';
  ?>
 </div>
 
</form>


</div>


</div>
</body>

</html>