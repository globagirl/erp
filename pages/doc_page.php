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


<!-- DOC --> 
<title>
ADD FILES
</title>



<script>
function addFile(){
	 var nameF=document.getElementById("nameF").value;
     var desc=document.getElementById("desc").value;
	 var liste1 = document.getElementById("type1");
     var type1 = liste1.options[liste1.selectedIndex].value;
     var liste1 = document.getElementById("type2");
     var type2 = liste1.options[liste1.selectedIndex].value;
         if(nameF==""){
			  alert("Selectionnez un fichier SVP!!");
			  
          } else if(desc==""){
			  alert("Donnez une description SVP!!");
			 
          } else if(type1=="s"){
			  alert("Selectionnez un type  SVP !!");
			  
          } else if(type2=="s"){
			  alert("Selectionnez un type  SVP !!");
			  
          }else{
			  document.forms['form1'].submit(); 
		  }
}
function locationF(){

	 var liste1 = document.getElementById("type1");
     var type1 = liste1.options[liste1.selectedIndex].value;
   if(type1=="s"){
			  alert("Selectionnez un type  SVP !!");
			  
          		  
          }else{
			 $.ajax({
			url: '../php/listeLocation.php',
			type: 'POST',
			data: "T="+type1,
			success:function(data){
				
				$('#tdL').html(data);
			}});
		  }
		
}
function locationF2(){

	 var liste1 = document.getElementById("typeX");
     var type1 = liste1.options[liste1.selectedIndex].value;
   if(type1=="s"){
			  alert("Selectionnez un type  SVP !!");
			  
          		  
          }else{
			 $.ajax({
			url: '../php/listeLocation2.php',
			type: 'POST',
			data: "T="+type1,
			success:function(data){
				
				$('#type2').html(data);
			}});
		  }
		
}
</script>
</head>

<body onload="afficheliste()">



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
}elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}

else{
	 header('Location: ../deny.php');
}

?>
</div>
<div id='contenu'>
<br>

<p class="there">ADD Page Documentation</p>




<br>



<form method="post" name="form1" id="form1" action="../php/add_files.php" >
<?php

include('../connexion/connexionDB.php');
?>

<TABLE BORDER="0"> 

		<TR> 
			<Th WIDTH=150 HEIGHT=30  ALIGN="left" >Page: </Th> 
			<TD colspan="3"><input type="text" name="page" id="page" /></TD> 
			
		</TR> 
		
		<TR> 
			<TH WIDTH=150 HEIGHT=30  ALIGN="left">Description : </TH> 
			<TD colspan="3"><textarea placeholder="Description" name="desc" id="desc" rows="4" cols="30"></textarea></TD> 
			
		</TR> 	
		<TR> 
			<TH WIDTH=150 HEIGHT=30  ALIGN="left">Note : </TH> 
			<TD colspan="3"><textarea placeholder="Note" name="note" id="note" rows="4" cols="30"></textarea></TD> 
			
		</TR> 
  <tr>
  	<Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left">File: </Th> 
			<TD>
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			 <select name="dossier" id="dossier" class="custom-dropdown__select custom-dropdown__select--white" onChange="locationF();" >
			 <option value="pages">Pages</option>
             <option value="php">Php</option>
			 <option value="tcpdf">Tcpdf</option>
			 <option value="files">Files</option>
			 <option value="menu">Menu</option>
			 <option value="include">Include</option>
			 <option value="image">Image</option>
			 <option value="css">Css</option>
			 <option value="Maintenance">Maintenance</option>
             </select> 
			 	</span>	
  
  </td>
  </tr>

 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Location : </TH> 
 <TD colspan="3" id="tdL"> <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="type2" id="type2" type="text" class="custom-dropdown__select custom-dropdown__select--white">
			 <option value="s">---Selectionnez</option>
             
		
			
			</select>
			</span>	
 </TD>
</TR>

 <tr><td></td><td>
<input type="button" onClick="addFile();" value="ADD >>" id="submitbutton"> </td>
</tr>
</TABLE> 

 
</form>


</div>

</div>

</body>

</html>