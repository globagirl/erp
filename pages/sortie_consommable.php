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



<title>
Consumable outPut
</title>
<script>


////////////
function afficheCase(v1,v2){
	var val= document.getElementById(v1).value;
	if( $('input[name='+v1+']').is(':checked') ){
		document.getElementById(v2).disabled=false;
		
	}
	else{
		document.getElementById(v2).disabled=true;
		document.getElementById(v2).value="";
		
	}
  
		}


///////////////////////////////////


function verifS(s,v){
	var val1= document.getElementById(s).value;
	val1=parseFloat(val1);
	var val2= document.getElementById(v).value;
	val2=parseFloat(val2);
	if(val1<val2){
		alert("Vous n'avez pas un stock suffisant");
		document.getElementById(v).value="";
	}
	
	
}

	

function addS(){

		document.forms['form1'].submit(); 
	
}
//////////////	

///////////////


/////////////
function affichelisteC(){
	var liste = document.getElementById("idD");
    var valeur = liste.options[liste.selectedIndex].value;
	$.ajax({
          type: 'POST',
          data : 'demande=' + valeur,
          url: '../php/afficheDemandeC.php',
          success: function(data) {
                    $('#arts').html(data);
           }});
}
//
function desactiveEnter(){ 
 if (event.keyCode == 13) { 
      event.keyCode = 0; 
      window.event.returnValue = false; 
 } 
} 

</script>

</head>

<body onKeyDown="desactiveEnter()" >



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
elseif($role=="MAG"){
include('../menu/menuMagazin.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Consumable outPut</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form method="post"  id="form1" action="../php/sortie_consommable.php">


<TABLE > 

		<TR> 
	<TH Wcode_articleTH=150 HEIGHT=30  ALIGN="left">Request ID: </TH> 
			<TD >
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
            <select name="idD" id="idD"  style="width:150px" class="custom-dropdown__select custom-dropdown__select--white" >
             <option value="s">---Selectionnez</option>
            <?php
              $sql = "SELECT * FROM demande_consommable where statut='D'";	
			  $res = mysql_query($sql) or exit(mysql_error());
			  
			  while($data=mysql_fetch_array($res)) {
			  echo '<option value="'.$data["IDdemande"].'">'.$data["IDdemande"].'</option><br/>'; 
              }


            ?>
            </select> 
            </span>
			</TD> 
		
		   
		   <td>
           <input type="button" onclick="affichelisteC()" id="submitbutton" value="OK">
  
			</TD> 
			
		
	
	
	
		</TR> 
  </table>
<div id="arts" style="text-align:center">
</div>





<hr size=2 />

</div>
<hr size=2 />


</div>
</div>
</body>
</html>