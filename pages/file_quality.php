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
Quality Files
</title>
<SCRIPT> 
function listeFiles(){
		 var liste1 = document.getElementById("recherche");
         var val1 = liste1.options[liste1.selectedIndex].value;
		 var liste2 = document.getElementById("dossier");
         var val3 = liste2.options[liste2.selectedIndex].value;
         var val2=document.getElementById("valeur").value;
          $.ajax({
        type: 'POST',
        data : 'recherche=' + val1+'&valeur=' + val2+'&dossier=' + val3,
        url: '../php/file_quality.php',
        success: function(data) {
        $('#div1').html(data);
       }});
	  


}

////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////
function deleteFile(d,f){

 if(confirm("Voulez-vous vraiment supprimer ce fichier?")){
 var t="qualityfiles";
 $.ajax({
          type: 'POST',
          data : 'D=' + d+'&F=' + f +'&T=' + t,
          url: '../php/delete_file.php',
          success: function(data) {
		     	
	         listeFiles();
           }});
 }
 }
////Sous dossier
function locationF2(){

	 var liste1 = document.getElementById("recherche");
     var type1 = liste1.options[liste1.selectedIndex].value;
   if(type1!="a"){
			
			 $.ajax({
			url: '../php/listeLocation2.php',
			type: 'POST',
			data: "T="+type1,
			success:function(data){
				
				$('#dossier').html(data);
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


<p class="there">Quality Files</p>

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
	 <select name="recherche" id="recherche" onChange="locationF2();" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a">ALL</option>
	         <option value="RG45">RG45</option> 
			 <option value="UPM3"> UPM3</option> 
		     <option value="Others"> Others</option> 
			

   </select> 
   </span> 
   <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
	 <select name="dossier" id="dossier" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="a">--Location</option>
	        
			

   </select> 
   </span>
   <input type="text" name="valeur" id="valeur" size="15" placeholder="File ">
 
 <input type="button" id="submitbutton" value="OK" onclick="listeFiles();">  
 </td>
 </tr>
 </table>
 <div id="div1">
 <?php
  $req= "SELECT * FROM qualityfiles ";
    

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
	//<input type=\"button\" id=\"submitbutton\" onClick=afficheFile('".$nameF."'); value=\"View\" >
	
	
    echo"<tr><td style=\"text-align:center\">$nameF</td><td colspan=2 style=\"text-align:center\">$desc</td>
	<td style=\"text-align:center\"> Quality/$dossierF/ </td>
	<td style=\"text-align:center\"><a href=\"../files/managementFiles/Quality/".$dossierF."/".$nameF."\" ><img src=\"../image/viewFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a> </td>
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