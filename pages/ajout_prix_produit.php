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
ADD PRICES
</title>
<script>

var i=1;
function add(){
	
	i++;
document.getElementById('nbr').value=i;
var mL="mL"+i;
var mH="mH"+i;
var p="P"+i;
var D="D"+i;
$('#divT').before('<TR id='+D+'><TH >FROM</TH><td><input type="text" id='+mL+' size="8" name='+mL+'></td><th> TO   </th><td> <input id='+mH+' size="8" name='+mH+' type="text"></td><th> PRICE '+i+'  </th><td colspan=2 ><input type="text" id='+p+' name='+p+' size="8"/></td></tr>');


	}



////
function deleteE(){
	

if(i>1){
	var D="#D"+i;
    $(D).remove();
	i--;
   document.getElementById('nbr').value=i;
}

}
///// 
function addP(){
document.getElementById('nbr').value=i;

	var nbr=document.getElementById('nbr').value;
	var mHV=document.getElementById('mH1').value;
		var j=1;
        var v=1;
		while(j<nbr && v==1){
			var lastMHN="mH"+j;
			var lastMH=document.getElementById(lastMHN).value;
			lastMH=parseFloat(lastMH);
			lastMH=lastMH+1;
			j++;
			var mLName="mL"+j;
			var mHName="mH"+j;
			var mLV=document.getElementById(mLName).value;
            mHV=document.getElementById(mHName).value;
			mHV=parseFloat(mHV);
	        mLV=parseFloat(mLV);
	       if(mLV != lastMH){
		     v=0;
		     alert("Verifier vos valeur SVP !!");
		     document.getElementById(mLName).style.backgroundColor='pink'; 
	       }
	       else if(mHV<= mLV){
		    v=0;
		    alert("Verifier vos valeur2 SVP !!");
		    document.getElementById(mHName).style.backgroundColor='pink'; 
	        }
		}
	
	if(nbr>=1){
		var mLF=document.getElementById('mLX').value;
		mHV=parseFloat(mHV);
		mHV=mHV+1;
		mLF=parseFloat(mLF);
				
		if(mHV != mLF){
		    v=0;
		    alert("Verifier vos valeur2 SVP !!");
		    document.getElementById('mLX').style.backgroundColor='pink'; 
	        }
	}
	if(v==1){
	
	document.forms['form1'].submit(); 
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

elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>

<p class="there">ADD PRICES</p>
<br>

<!-- end --> 


<form  method="post"  id="form1" action="../php/ajout_prix_produit.php">


<hr/>
<TABLE > 
<tr >
<th ><b><i>ITEM ID : <?php echo($PRD) ?></i></b></th>
</tr>
</table>
<table>
<tr>
 <TH >FROM:  </TH> 
 <td> <input type="text" id="mL1" size="8" name="mL1" value="1" READONLY> </td>
 <th>TO </th>
 <td><input id="mH1" size="8" name="mH1" type="text"></td>
 <th>PRICE 1 </th>
 <td><input type="text" id="P1" name="P1" size="8"  /></td>
<td><input type="button" onclick="add();" id="submitbutton" value="+">
  <input type="button" onclick="deleteE();" id="submitbutton" value="-">
 </td>
 </tr>

<TR id="divT"> 
 <TH >FROM:  </TH> 
 <td> <input type="text" id="mLX"  size="8" name="mLX"  > </td>
 <th>TO </th>
 <td><input type="text" id="mHX" size="8" name="mHX"  value="XXXXXXXXXXXX" READONLY></td>
 <th>PRICE X </th>
 <td><input type="text" id="PX" name="PX" size="8" ></td>
<td>
  <input type="text" id="nbr" name="nbr" style="visibility:hidden"  />
  
  </td>
 </tr>
 <tr><td></td><td colspan=6><input type="button" onclick="addP();" id="submitbutton" value="Submit >>"></td>
</table>
</div>
</div>
</body>
</html>