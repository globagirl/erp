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
Consumable Request
</title>
<script>






var i=0;
function add(){
	
	 if(dateD ==""){
		
		alert("Selectionnez la date de la demande SVP!!");
	
	}else{
	     
     
	      i++;
	      document.getElementById('nbr').value=i;
          var consN="C"+i;
          
          var qtyN="Q"+i;
          var dN="d"+i;
          var pN="p"+i;
          $('#items').append('<div id='+dN+'> Consumable  :  <select id='+consN+' name='+consN+' style="width:150px" ></select>  Quantity : <input type="text" id='+qtyN+' name='+qtyN+' size="8"  /><hr></div>');
          var consA="#"+consN;


            $.ajax({
              type: 'POST',
			  
              url: '../php/listeConsommable.php',
              success: function(data) {
              $(consA).html(data);
		      }});
	}	
}

////
function deleteE(){
	

if(i>0){
	var D="#d"+i;
    $(D).remove();
	i--;
    document.getElementById('nbr').value=i;
}

}



////// 
function submitD(){
	
	
	
	var dateD=document.getElementById('dateD').value;
	
	
	
	if(dateD == "") {
			alert("Donnez la date de la demande SVP¨!!");
	
	}else{
		document.formD.submit(); 
		}
}
////////
function afficheID(){

	var dateD=document.getElementById('dateD').value;
	var D=document.getElementById('demande').value;
	var x=dateD.substr(5,9);
	var dem=D+"/"+x;
	document.getElementById('demande').value=dem;
	
}
function clearZone(){
	$('#items').empty();
	
	
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

elseif($role=="CONS"){
include('../menu/menuConsommable.php');	
}
else{
session_unset();
   session_destroy();
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>

<p class="there"> Consumable Request </p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form  method="post"  id="formD" name="formD" action="../php/ajout_demande.php">
<?php 
		$sql=mysql_query("select IDdemande from demande_consommable");
		$nbr=mysql_num_rows($sql);
		$nbr++;
		$demande="D".$nbr;
		?>

<TABLE > 
      <tr><Th Wcode_articleTH=150 HEIGHT=30  ALIGN="left" >Request date: </Th> 
		<td ><input type="date" size="10" name="dateD" id="dateD" onChange="afficheID();"/></td>
		<th >
		
		
		Request ID : </th><td colspan=5><input type="text" name="demande" id="demande" size="15" value="<?php echo($demande);?>" READONLY></td>	
      
		</tr>
		
		
  
	


<TR> 
 <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left" colspan="7" style="text-align:center">Consumable:  
 <input type="text" size="5" name="nbr" id="nbr" HIDDEN>
 
 </TH> 
 <td>
 <input type="button" onclick="add();" id="submitbutton" value="+">
  <input type="button" onclick="deleteE();" id="submitbutton" value="-">
 </td>
 </tr>
 <tr>
<td colspan="8" style="text-align:center">

<div id="items"></div>
</td>


 
 </tr>
 <tr><th colspan="7"></th><td>  <input type="button" onclick="submitD();" id="submitbutton" value="Submit >>"> </td></tr>




</table>
</form>
</div>
</div>
</body>
</html>