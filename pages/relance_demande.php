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
Demande relance
</title>
<script>
////////////

//affichage de la liste des articles
function afficheArticle(){
	
	 var PO=document.getElementById('PO').value;
	 var qty=document.getElementById('qty').value;
	 var detail=document.getElementById('detail').value;
	 var liste3 = document.getElementById("cause");
     var cause= liste3.options[liste3.selectedIndex].value;
	 if(PO==""){
	 alert("Donnez un PO SVP !!");
	 }else if (cause=="s"){
	 alert("Donnez la cause du demande SVP !! ");
	 }else if (detail==""){
	 alert("Donnez un detail SVP !! ");
	 }else if (qty==""){
	 alert("Donnez la quantitée SVP !! ");
	 }else{
	 $.ajax({
          type: 'POST',
          data : 'PO=' + PO+'&qty=' + qty,
          url: '../php/relance_afficheA.php',
          success: function(data) {
                    $('#TR1').html(data);
					
					
					
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

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');	
}
elseif($role=="PRD"){
include('../menu/menuProduction.php');	
}elseif($role=="MAG"){
include('../menu/menuMagazin.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Demande de relance </p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>

<form action="../php/relance_demande.php" method="POST" id="form1">
<table>
<?php
  $sql=mysql_query("SELECT * from demande_relance ");
		$max=mysql_num_rows($sql);
		$max++;
		$IDdemande="R".$max;
?>
<tr><TH colspan=2>Demande ID :  <?php echo $IDdemande ; ?> <input type="text" id="IDR" name="IDR" value=<?php echo $IDdemande ; ?> HIDDEN> </TH> </tr>
<tr><TH id="LarTH">N° PO :</TH> 
<td ><input type="text" id="PO" name="PO" placeholder="N° PO"/></td></tr>
<tr><TH>Cause de demande: </TH> 
<td><select  id="cause" name="cause" >
<option value="s">---Selectionnez </option>
<option value="Reliquat suite rebut">Reliquat suite rebut </option>
<option value="Lancement Erroné"> Lancement Erroné </option>
<option value="Sortie magazin erroné">Sortie magazin erroné </option>
</select>
</td></tr>
<tr><TH>Détail: </TH> 
<td><textarea rows="4" cols="30" id="detail" name="detail"></textarea></td></tr>
<tr><TH>QTY à relancer : </TH> 
<td><input type="text" id="qty" name="qty" placeholder="QTY" size=8/> <input type="button" id="submitbutton" value=">>" onclick="afficheArticle();"/></td></tr></table>
<table id="TR1"></table>





 
</form>

</div>
</div>

</body>

</html>