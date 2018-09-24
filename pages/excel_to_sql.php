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
Restriction produit
</title>
<script>


function verifier(){
	
		  document.forms['form1'].submit(); 
		 
}
////

</script>

</head>

<body onLoad="affichelisteC();">



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

else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Produit retriction</p>

<br>
<br>
<hr size=2 />


<form method="POST"  id="form1" name="form1" action="../php/excel_to_mysql.php" enctype="multipart/form-data">


<TABLE > 
<tr>
	
	 <th>
	   Description produit
	 </th>
	 <td>
	 <textarea name="desc"></textarea>
	 </td>
			</tr>
			<tr>
			<td> </td>
			<td>
            <input type= "file" name="fileP" id="fileP" />
            </td>
			</tr>
			<tr><td></td>
			<td><input type="button" onClick="verifier();" value="Submit >> " id="submitbutton"></td>
	        </tr>
	
	
		
  </table>
 
<hr size=2 />
<div id="ComNote"></div>
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
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Produit ajouté avec succès \');</SCRIPT>';
	 //header('Location: ../pages/ajout_fact.php');
	 } else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Fail !! veuillez réessayer SVP \');</SCRIPT>';}
} 
?>