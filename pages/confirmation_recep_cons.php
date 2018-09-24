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
Confirmation of receipt consumables
</title>
<script>
////////////

//affichage de la liste des articles
function afficheDemande(){
	 var liste1 = document.getElementById("demande");
 var valeur = liste1.options[liste1.selectedIndex].value;

 if(valeur=="S"){
 alert("Selectionnez un code de  reception SVP !!");
 }
 else{
	 
	 $.ajax({
          type: 'POST',
          data : 'demande=' + valeur,
          url: '../php/reception_cons_items.php',
          success: function(data) {
                    $('#divProd').html(data);
					
					
           }});
	 
	 
	 
 }

}

///////////////
function confirmS(){
	var v=1;	
	var nbr= document.getElementById('nbr').value;
	var ch="";
	var i=1;
	while (i<= nbr && v==1) {
		ch="ch"+i;
	
	if ($('input[name='+ch+']').is(':checked') ){
	    i++;
		
	}else{
		v=0;
	}
	
	}
	if(v==0){
		alert("Si vous avez un probléme avec la quantité entrée veillez contactez le RESPONSABLE SVP ! ");
	}else{
		document.forms['form1'].submit(); 
	}
}

////////////////////////


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
elseif($role=="CONS"){
include('../menu/menuConsommable.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Confirmation of receipt CONS</p>





<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>

<form action="../php/confirmation_recep_cons.php" method="POST" id="form1">
<table>
<tr>
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left" colspan="2">Demande ID: </TH> 
 <td colspan=4>
 <select id="demande" name="demande" style="width:200px">
 <option value="S" selected>---Selectionnz </option>
<?php
$sql = "SELECT * FROM demande_consommable where statut='T' ";
$res = mysql_query($sql) or exit(mysql_error());
while($data=mysql_fetch_array($res)) {
   echo '<option value="'.$data["IDdemande"].'">'.$data["IDdemande"].'</option><br/>'; 
}
?>
   </select> 
 
<input type="button" id="submitbutton" value="OK" onclick="afficheDemande()"/>
  </td>
 
 </tr></table>

 <div id="divProd" ></div>


 
</form>

</div>
</div>

</body>

</html>