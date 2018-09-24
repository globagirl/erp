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



<title>
ADD new Category
</title>
</head>

<body>
<br>

<p class="there">ADD new Category</p>
<form method="post" action="../pages/pop_ajout_category.php">
<table>
	<TR> 
			<TH WIDTH=150 HEIGHT=30  ALIGN="left">Category: </TH> 
			<TD colspan="2"><input type="text"  name="cat" SIZE="28"></TD> 
			
		</TR> 
  
  
<TR> 
 <TH WIDTH=150 HEIGHT=30  ALIGN="left">Description </TH> 
 <TD colspan="2"> <textarea name="desc"  MAXLENGTH="30" rows="4" cols="35" ></textarea></TD>
</TR>


 


</TABLE> 

<input type="submit" value="Ajouter" id="submitbutton"> 


 
<p>

</p>
 
</form>
</body>
</html>
<?php

include('../connexion/connexionDB.php');
$cat = @$_POST['cat'];
$desc = @$_POST['desc'];
$sql= mysql_query("INSERT INTO invoice_category (catName,description) VALUES ('$cat','$desc')");

?>