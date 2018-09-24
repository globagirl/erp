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
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link rel='stylesheet' type='text/css' href="../CSS/styles.css" />
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
 
<title>
STARZ ELECS ERP
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

else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>
<br>

<p class="there">Historique</p>
<br><br>
<form method="POST" action="historique.php" name='form' >
<table>
<tr><th>
From </th><td> <input  type="date" name="dateF" SIZE="20"></td><th>
TO </th><td><input  type="date" name="dateT" SIZE="20" >
 <select name="user">
<option>All</option>
<?php
include('../connexion/connexionDB.php');
$sql = "SELECT * FROM users1";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["ID"].'">'.$data["login"].'</option><br/>'; 
}

?>
   </select>
<input  type="submit" name="search" id="submitbutton"  value=">>" /></td></tr>

</table>


<div id="div1">
<table><tr><td>
<!--affichage -->
<?php
if(isset($_POST["dateF"]) or isset($_POST["dateT"]) or isset($_POST["user"])){
if(($_POST["dateF"] != "") and ($_POST["dateT"] != "")){
	$dateF=$_POST["dateF"];
	$dateT=$_POST["dateT"];
	
}
else if(($_POST["dateF"] != "") and !($_POST["dateT"] !="")){
	$dateF=$_POST["dateF"];
	//$dateF=date_format($dateF,"Y-m-d");
	$dateT=date("Y-m-d H:i:s");
	
}
else if(!($_POST["dateF"] != "") and ($_POST["dateT"] != "")){
	$sql=mysql_query("select min(date_heure) from historique");
	$dateF=mysql_result($sql,0);
	$dateT=$_POST["dateT"];
	
}
else {
	$sql=mysql_query("select min(date_heure) from historique");
	$dateF=mysql_result($sql,0);
	$sql1=mysql_query("select max(date_heure) from historique");
	$dateT=mysql_result($sql1,0);
	}
$userID=$_POST['user'];

if($userID!= "All"){
$sql="SELECT * FROM historique where (user_id = '$userID') and (date_heure >='$dateF') and (date_heure <'$dateT') ORDER BY date_heure DESC";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
	$user=$data["user_id"];
	$req=mysql_query("SELECT login FROM users1 where (ID = '$user')");
	$userLog=mysql_result($req,0);
	if($data["action"]=="connect"){
		echo $data["date_heure"]." : ".$userLog." was connected ".'<br>';
	}else if($data["action"]=="disconnect"){
		echo $data["date_heure"]." : ".$userLog." was disconnected ".'<br>';
	}
	else {
		echo $data["date_heure"]." : ".$userLog.' '.$data["action"]."<br>";
	}
	
   
}
}
else{
	$sql="SELECT * FROM historique where (date_heure >='$dateF') and (date_heure <'$dateT') ORDER BY date_heure DESC";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
	$user=$data["user_id"];
	$req=mysql_query("SELECT login FROM users1 where (ID = '$user')");
	$userLog=mysql_result($req,0);
	if($data["action"]=="connect"){
		echo $data["date_heure"]." : ".$userLog." was connected ".'<br>';
	}else if($data["action"]=="disconnect"){
		echo $data["date_heure"]." : ".$userLog." was disconnected ".'<br>';
	}else{
	echo $data["date_heure"]." : ".$userLog.' '.$data["action"]."<br>";
   }
	
}
}
} else {
		$sql="SELECT * FROM historique ORDER BY date_heure DESC LIMIT 200";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
	$user=$data["user_id"];
	$req=mysql_query("SELECT login FROM users1 where (ID = '$user')");
	$userLog=mysql_result($req,0);
	if($data["action"]=="connect"){
		echo $data["date_heure"]." : ".$userLog." was connected ".'<br>';
	}else if($data["action"]=="disconnect"){
		echo $data["date_heure"]." : ".$userLog." was disconnected ".'<br>';
	}
	
	else{
		echo $data["date_heure"]." : ".$userLog.' '.$data["action"]."<br>";
	
}
}
}
mysql_close();
?>
</td></tr></table>
</div>
</form>
</div>

</div>

</body>

</html>