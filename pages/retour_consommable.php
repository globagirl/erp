<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
include('../connexion/connexionDB.php');
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
Consumable Return
</title>

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

/*elseif($role=="MAG2"){
include('../menu/menuMagazin2.php');	
}*/
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>

<p class="there"> Consumable Return </p>




<br>

<!-- end --> 


<form  method="post"  id="formD" name="formD" action="../php/retour_consommable.php">


<TABLE > 
      <tr><Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left" >Return date: </Th> 
		<td ><input type="date" size="10" name="dateR" id="dateR" onChange="afficheID();"/></td>
		<th >Operator :  </th>
		<td>
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
		<select name="nom" id="nom"  style="width:150px" class="custom-dropdown__select custom-dropdown__select--white" >
             <option value="s">---Selectionnez</option>
         <?php


$sql = "SELECT * FROM users1 ";	


$res = mysql_query($sql) or exit(mysql_error());

while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["nom"].'">'.$data["nom"].'</option><br/>'; 
}


?>
</select>
</span>
  </td>    
		</tr>
		
		
  
	


<TR> 
 <TH>Consumable ID : </th>
<td>
	<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
  <select name="idCons" id="idCons"  style="width:150px" class="custom-dropdown__select custom-dropdown__select--white" >
             <option value="s">---Selectionnez</option>
<?php
include('../connexion/connexionDB.php');

$sql = "SELECT * FROM article1 where typeA='Consumable'";	


$res = mysql_query($sql) or exit(mysql_error());

while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["code_article"].'">'.$data["code_article"].'</option><br/>'; 
}


?>
</select>
</span>
</td> 
<th> Quantity </th>
 
<td colspan=5><input type="text" name="qty" id="qty" size="15" ></td>	


</tr>
<tr>
<td ></td>
<td colspan=3><input type="submit" value="Submit >> " id="submitbutton" ></td>
</tr>




</table>
</form>
</div>
</div>
</body>
</html>