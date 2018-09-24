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
	
<script type="text/javascript" src="affichelisteA.js"></script>


<title>
Confirmer demande
</title>
<script>
////////////

//affichage de la liste des articles
function afficheDemande(){
	
	 var liste3 = document.getElementById("demande");
     var demande= liste3.options[liste3.selectedIndex].value;
	 if (demande=="s"){
	 alert("Selectionnez une demande SVP !! ");
	 }else{
	 $.ajax({
          type: 'POST',
          data : 'demande=' + demande,
          url: '../php/relance_afficheConf1.php',
          success: function(data) {
                    $('#zone').html(data);
					
					
					
           }});
	 
	 }
	 
 }
 
 //Refuser demande
 function refuser(){
	
	 var liste3 = document.getElementById("demande");
     var demande= liste3.options[liste3.selectedIndex].value;
	 if (demande=="s"){
	 alert("Donnez un ID demande SVP !! ");
	 }else{
	    document.form1.action="../php/relance_refuser.php";
		document.form1.submit();
	 
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

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');	
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


<p class="there">Confirmer demande </p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>

<form action="../php/relance_confirmation1.php" method="POST"  id="form1" name="form1">
<table>

<tr><TH id="LarTH">Relance ID : </th>
<td>
<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
<select id="demande" name="demande" class="custom-dropdown__select custom-dropdown__select--white">
<option value="s">---Selectionnez</option> 
<?php
  $sql=mysql_query("SELECT * from demande_relance where statut='D'");
  while($data=mysql_fetch_array($sql)) {
  echo '<option value="'.$data["IDrelance"].'">'.$data["IDrelance"].'</option><br/>'; 
}
?>
</select>
</span> 
<input type="button" id="submitbutton" value=">>" onclick="afficheDemande();"/></td></tr>

</table>
<table id="zone"></table>


 
</form>

</div>
</div>

</body>

</html>