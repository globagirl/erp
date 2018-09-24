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



<title>Pointage</title>
<script>
var V=1;


/////////////

////////////////
function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=768,height=600,directories=no,location=no') 
}

function verifier(){
	
var val=document.getElementById("pause").value;
          if(V != 1){
		   alert("Vérifier les horaires SVP !!");
		  }
		  else if(val==""){
			  alert("Donnez le temp de pause SVP !!");
			  document.getElementById('pause').style.backgroundColor='pink'; 	 
          		  
          } else {		
		  document.forms['form1'].submit(); 
		 }
}
////
function verifierH(x){
	
var val=document.getElementById(x).value;
l=val.length;
		  if(l!=2){
			  alert("Exemple : 07 !!");
			  document.getElementById(x).style.backgroundColor='pink'; 	 
          	 V=0;  
          }else{
		  V=1;
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
elseif($role=="GRH"){
include('../menu/menuGRH.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Pointage</p>


<br>
<hr size=2 />




<form method="POST"  id="form1" name="form1" action="../php/lecture_pointage.php" enctype="multipart/form-data">


<TABLE > 

	<tr>
		<th rowspan=2> Horaire journaliére</th>
		<td colspan=2> 
		    <input type="text" value="08" name="hd" id="hd" size="1" onBlur="verifierH('hd');">:			    
		    <input type="text" value="00" name="md" id="md" size="1" onBlur="verifierH('md');"> 
		    <b> >> </b>
		    <input type="text" value="16" name="hf" id="hf" size="1" onBlur="verifierH('hf');">:
		    <input type="text" value="30" name="mf" id="mf" size="1" onBlur="verifierH('mf');">
		</td>
	</tr>
	<tr>  
		<td colspan=2>Pause : <input type="text" value="30" name="pause" id="pause" size="1"> mn </td>
	</tr> 
	<tr>
		<th rowspan=2> Horaire du samedi </th>
		<td colspan=2> 
			<input type="text" value="08" name="hdS" id="hdS" size="1" onBlur="verifierH('hdS');">:
			<input type="text" value="00" name="mdS" id="mdS" size="1" onBlur="verifierH('mdS');">
			<b> >> </b>
			<input type="text" value="12" name="hfS" id="hfS" size="1" onBlur="verifierH('hfS');">:
			<input type="text" value="30" name="mfS" id="mfS" size="1" onBlur="verifierH('mfS');">
		</td>
	</tr>
    <tr>
		<td colspan=2>Pause : <input type="text" value="0" name="pauseS" id="pauseS" size="1"> mn </td>
	</tr>
	<tr>
		<th > Poste Nuit </th>
		<td colspan=2> 
			<input type="text" value="21" name="hdN" id="hdN" size="1" onBlur="verifierH('hdN');">:
			<input type="text" value="00" name="mdN" id="mdN" size="1" onBlur="verifierH('mdN');">
			<b> >> </b>
			<input type="text" value="23" name="hfN" id="hfN" size="1" onBlur="verifierH('hfN');">:
			<input type="text" value="59" name="mfN" id="mfN" size="1" onBlur="verifierH('mfN');">
		</td>
	</tr>	
	<tr>
		<th></th>
		<td colspan=5>
            <input type= "file" name="fileP" id="fileP" />
        </td>
	</tr>
	<tr>
	    <td></td>
	    <td><input type="button" onClick="verifier();" value="Submit >> " id="submitbutton"></td>
	</tr>
</table>
 
<hr size=2 />
</form>

</div>
</div>
</body>
</html>
<?PHP 

if(!empty($_GET['status']))
{ 
     $status = $_GET['status']; 
     if  ($status=="sent")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Pointage ajouté avec succès \');</SCRIPT>';
	 //header('Location: ../pages/ajout_fact.php');
	 } else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Fail !! veuillez réessayer SVP \');</SCRIPT>';}
} 
?>