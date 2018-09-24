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
Double pointage
</title>
<script>
function deleteD(D){


 if(confirm("Voulez-vous vraiment supprimer ce double pointage ?!")){

 $.ajax({
          type: 'POST',
          data : 'D=' + D,
          url: '../php/delete_doubleP.php',
          success: function(data) {
		     	
	       $("#tab").load(location.href + " #tab");
           }});
		   
 }
 }
 
 function verifierNM(){


 var M=document.getElementById("newMat").value;

 $.ajax({
          type: 'POST',
          data : 'D=' + M,
          url: '../php/verif_doubleP.php',
          success: function(data) {
		   if(data==1){
	       alert("Matricule existe déja !!");
		   document.getElementById("newMat").value="";
		   }
           }});
		   

 } 
 function verifierM(){


 var M=document.getElementById("mat").value;

 $.ajax({
          type: 'POST',
          data : 'D=' + M,
          url: '../php/verif_doubleP.php',
          success: function(data) {
		   if(data==1){
	       alert("Matricule existe déja !!");
		   document.getElementById("mat").value="";
		   }
           }});
		   

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


<p class="there">Double pointage</p>


<br>
<hr size=2 />

<form method="POST"  id="form1" name="form1" action="../php/ajout_doubleP.php" >


<TABLE > 

		
			
			<tr><th>N° pointage:</th>
			<td> <input type="text" name="newMat" id="newMat" size="10" placeholder="Nouveau N°" onBlur="verifierNM();">
			</td></tr>
			<tr><th> Matricule :</th>
			<td colspan=5> <input type="text" name="mat" id="mat" size="10" placeholder="Ancien N°"> </td></TR> 
			
			<tr><td></td>
			<td><input type="submit"  value="Submit >> " id="submitbutton"></td>
	        </tr>
	
	
		
  </table>
 
<hr size=2 />
<table id="tab">
<tr><th>N° pointage</th><th>Matricule </th><th> Nom & prenom</th><th>Catégorie</th><th></th></tr>
<?php
$r1=mysql_query("select * from personnel_doublep ");
while($data=mysql_fetch_array($r1)){
$mat=$data['mat'];
$newMat=$data['newMat'];
$r2=mysql_query("select * from personnel_info where matricule='$mat' ");
$data2=mysql_fetch_array($r2);
echo ("<tr><td>".$data["newMat"]."</td><td>".$data["mat"]."</td><td>".$data2["nom"]."</td><td>".$data2["category"]."</td>
<td><center><a href=\"#\" onClick=deleteD('".$newMat."'); ><img src=\"../image/delete.png\" alt=\"delete\" width=\"30\" height=\"30\"></a></center></td></tr>");
}
?>
</table>
</form>

</div>
</div>
</body>
</html>
