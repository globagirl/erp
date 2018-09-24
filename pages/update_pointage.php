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
<title>Pointage Non valide </title>
<SCRIPT>
var V=1;
function affichePointage(){
var d1 = document.getElementById("date1").value;
var d2 = document.getElementById("date2").value;

$.ajax({
        type: 'POST',
        data: 'date1='+d1 +'&date2='+d2 ,
        url: '../php/affiche_pointageN.php',
        success: function(data) {
        $('#div1').html(data);
       }});

}
function updateP(i){
    var B="B"+i;
    var matN="mat"+i;
	var dateN="D"+i;
	var hND="HD"+i;
	var hNF="HF"+i;
	var mat = document.getElementById(matN).value;
	var D = document.getElementById(dateN).value;
	var hd = document.getElementById(hND).value;
	var hf = document.getElementById(hNF).value;
	var pause = document.getElementById('pause').value;
	var Hdebut = document.getElementById('Hdebut').value;
	var Hfin = document.getElementById('Hfin').value;
	var Mdebut = document.getElementById('Mdebut').value;
	var Mfin = document.getElementById('Mfin').value;
	$.ajax({
        type: 'POST',
        data: 'mat='+mat +'&D='+D +'&hd='+hd +'&hf='+hf +'&Hdebut='+Hdebut+'&Hfin='+Hfin+'&Mdebut='+Mdebut+'&Mfin='+Mfin+'&pause='+pause ,
        url: '../php/update_pointage.php',
        success: function(data) {
        if(data=="OK"){
		    document.getElementById(B).disabled = true;
		}else{
		    alert(data);
		}
    }});
}


function updateALL(){
	document.form1.action="../php/update_pointageALL.php";
    document.form1.submit();
}

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
</SCRIPT>
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


<p class="there">Pointage Non validé</p>

<br>

<!-- end -->





<form method="post" name="form1" id="form1">

<p style="float:right"><img src="../image/print.png" onclick="printPointage();" alt="Print" style="cursor:pointer;" width="60" height="50" />
<img src="../image/excel.png" onclick="excelPointage();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p>
<table>
    <tr>
        <th> Search: </th>
        <td colspan=3>
            <input type="date" name="date1" id="date1" size="10" >  <b> TO </b>
            <input type="date" name="date2" id="date2"  size="10">
        </td>
    </tr>
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
        <td></td>
        <td colspan=2>
		    <input type="button" id="submitbutton" value=">>" onclick="affichePointage()">
        </td>
    </tr>
</table>
<div id="div1"> </div>
</form>
</div>
</div>
</body>
</html>
