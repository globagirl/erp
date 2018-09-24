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
Jours fériés
</title>
<script>
function deletePH(D){


 if(confirm("Voulez-vous vraiment supprimer ce jour ferié ?!")){

 $.ajax({
          type: 'POST',
          data : 'PH=' + D,
          url: '../php/delete_publicH.php',
          success: function(data) {
		     	
	       $("#tab").load(location.href + " #tab");
           }});
		   
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
}elseif($role=="DIR"){
include('../menu/menuDirecteur.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Jours fériés</p>


<br>
<hr size=2 />

<form method="POST"  id="form1" name="form1" action="../php/public_holidays.php" >
<table> 

		
			
			<tr><th>Occasion:</th>
			<td> <textarea  name="desc" id="desc" rows="2" cols="50" placeholder="Occasion ....." ></textarea>
			</td></tr>
			<tr><th>Type:</th>
			<td> 
			<input type="radio" name="typePH" id="typePH1" value="FP" checked>Ferié payé
            <input type="radio" name="typePH" id="typePH2" value="CP">Congé payé
			</td></tr>
			<tr><th> Date debut :</th>
			<td colspan=5> <input type="date" name="dateD" id="dateD" size="10"> </td></TR> 
			<tr><th> Date Fin :</th>
			<td colspan=5> <input type="date" name="dateF" id="dateF" size="10"> </td></TR> 
			
			<tr><td></td>
			<td><input type="submit"  value="Submit >> " id="submitbutton"></td>
	        </tr>
	
	
		
  </table>
 
<hr size=2 />
<table id="tab">
<tr><th>Occasion</th><th>Date debut</th><th> Date fin</th><th>Type</th><th></th></tr>
<?php
$r1=mysql_query("select * from public_holiday order by idPH DESC");

while($data=@mysql_fetch_array($r1)){
$id=$data["idPH"];
$typePH=$data["typePH"];
if($typePH=='FP'){
$typePH="Ferié payé";
}else{
$typePH="Congé payé";
}
echo ("<tr><td>".$data["description"]."</td><td>".$data["dateD"]."</td><td>".$data["dateF"]."</td><td>".$typePH."</td>
<td><center><a href=\"#\" onClick=deletePH('".$id."'); ><img src=\"../image/delete.png\" alt=\"delete\" width=\"30\" height=\"30\"></a></center></td></tr>");
}
?>
</table>
</form>

</div>
</div>
</body>
</html>
