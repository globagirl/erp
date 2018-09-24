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
Mise à pied
</title>
<script>
var i=1;
////////////////////////LISTE LIKE GOOGLE :) /////////////
function autoComplete(c,l){
var liste = document.getElementById('recherche');
    var R = liste.options[liste.selectedIndex].value;
var zoneC="#"+c;
var zoneL="#"+l;
var min_length =1; 
	var keyword = $(zoneC).val();	
	if (keyword.length >= min_length) {
	
		$.ajax({
			url: '../php/auto_liste_personnel.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC+"&R="+R,
			success:function(data){
				$(zoneL).show();
				$(zoneL).html(data);
			}});
	}else {
		$(zoneL).hide();
	}
}
///
function hideListe(l) {
	
    var zoneL="#"+l;
	$(zoneL).hide();
	}

function choixListe(p,z) {
var ch=p.replace("|"," ");
	$(z).val(ch);
	
}
////////////////////////////////////FIN///////////////

function addP(){      
		i++;
		document.getElementById('nbr').value=i;
		var P="P"+i;
		var T="TR"+i;
     
		var listeP="listeP"+i;
       $('#TRF').before('<tr id='+T+'><td></td><td><input type="text" size="25"  id='+P+' name='+P+' onBlur=hideListe("'+listeP+'"); onKeyup=autoComplete("'+P+'","'+listeP+'"); onFocus=autoComplete("'+P+'","'+listeP+'")> <div class="divAuto2"><ul id='+listeP+' ></ul></div></td></tr>');



	}
///DElete personnel	
	
	function deleteP(){
	   
    if(i>1){
		var D="#TR"+i;
	    var P="P"+i;
		
		
		$(D).remove();
		 i--;
         document.getElementById('nbr').value=i;
		 }
	}


function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no') 
}

function addAvance(){
	document.getElementById('nbr').value=i;
  
	 var liste = document.getElementById('recherche');
    var R = liste.options[liste.selectedIndex].value;
	var montant = document.getElementById('montant').value;
	var dateA = document.getElementById('dateM').value;
    if(dateA==""){
      alert("selectionez une date SVP !! ");
   }else if(montant==""){
      alert("donnez le montant SVP !! ");
   } else if(R=="R"){
      alert("selectionez un mode de recherche SVP  !!");
   }
   else{
	   document.getElementById('form1').submit();
   }
    
}
</script>
</head>

<body onLoad="affichelisteF();">
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
session_unset();
   session_destroy();
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


<!-- began --> 
<BR>
<p class="there">Mise à pied</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>


<form method="post"  id="form1" action="../php/ajout_mise.php">


<TABLE > 

		<TR> 
			<Th >Date: </Th> 
			
			<TD>
			
			<input type="date" name="dateM"  id="dateM"  ></TD> 
			</td>
			
		</TR> 	
		<TR> 
			<Th >Montant: </Th> 
			
			<TD>
			
			<input type="text" name="montant"  id="montant" size="8" ></TD> 
			</td>
			
		</TR> 


<TR> 
 <TH>Personnel: </th>
 <td> 
   <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="recherche" id="recherche" type="text" class="custom-dropdown__select custom-dropdown__select--white">
			
			
			<option value="nom">Nom</option>
			<option value="matricule">Matricule</option>
			<option value="NCIN">NCIN</option>
			</select>
	 </span>
 </Td> 
 </tr>
 <tr>
 
<td></td>
<td>
<input type="text" id="P1" name="P1" size="25" onBlur="hideListe('listeP1');" onKeyup="autoComplete('P1','listeP1'); " onFocus="autoComplete('P1','listeP1')"> 

<input type="button" onclick="addP();" id="submitbutton" value="+">
<input type="button" onclick="deleteP();" id="submitbutton" value="-">
<div class="divAuto2"><ul id="listeP1" ></ul></div>
</td>
 </tr>
 <tr id="TRF">
 <td></td>		

 <td><input type="button" onclick="addAvance();" id="add1" value="Submit >> ">
 <input type="text" name="nbr" id="nbr" HIDDEN></Td></tr>



</table>

</form>
</div>
</div>
</body>
</html>
