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
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<title>
Update contrat
</title>
<SCRIPT> 

function changePage(){
	document.location.href="../pages/consult_contrat.php";
}			   
</SCRIPT> 
</head>

<body onLoad="afficheContrat();">

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



<p><img src="../image/change.png" onclick="changePage();" style="float:right;cursor:pointer;" alt="Print" width="60" height="50"  /></p>
<br>
<form role="form" method="post" name="form1" id="form1" action="../php/update_contrat.php">
<?php
include('../connexion/connexionDB.php');
if(isset($_POST['idC'])){
$idC=$_POST['idC'];
$_SESSION['idC']=$idC;	
}else{
    $idC=$_SESSION['idC'];
	$sql = mysql_query("SELECT * FROM personnel_contrat where idC='$idC'");
	$data=mysql_fetch_array($sql);	
?>
<table>
<tr>
    <th colspan=2>
     	Matricule : <?php echo $data['matricule']; ?>
		<input type="text" name="idC" value="<?php echo $data['idC']; ?>" HIDDEN>
	
	</th>
</tr>
<tr>
    <th>N° contrat  </th>
    <td> <input type="text" name="numC" value="<?php echo $data['numContrat']; ?>"></td>
</tr>
<tr>
    <th>Type Contrat:</th> 
    <td>
	<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
		<select name="contratT" id="contratT"  class="custom-dropdown__select custom-dropdown__select--white">			
			<option value="<?php echo $data['typeContrat']; ?>"><?php echo $data['typeContrat']; ?></option>
			<option value="SIVP">SIVP</option>
			<option value="CDI">CDI</option>
            <option value="CDD">CDD</option>
            <option value="Apprentissage">Apprentissage</option>
        </select>
	</span>
    </td>
</tr>
<tr> 
	<th >Date: </th> 
	<td>
		<b>Du</b>
		<input type="date" name="date1"  id="date1" value="<?php echo $data['dateD']; ?>" >
		<b> Au </b>
		<input type="date" name="date2"  id="date2" value="<?php echo $data['dateF']; ?>" >
	</td> 
</tr> 	
<tr> 
	<th>Société: </th> 			
	<td>
		<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="comp" id="comp"  class="custom-dropdown__select custom-dropdown__select--white">			
			<option value="<?php echo $data['company']; ?>"><?php echo $data['company']; ?></option>
			<option value="STARZ">STARZ</option>
			<option value="SESI">SESI</option>  	
			
			</select>
		</span>
	</td> 
</tr>
<tr>
    <td></td>
	<td><input type="submit"  id="add1" value="Update >> "></td>
</tr>
<?php }?>
</form>


</div>


</div>
</body>

</html>