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
Ajout Personel
</title>
<script>
var i=1;
//var j=1;
//Ajout Nouvelle zone TEL
function addTel(){
i++;
var T="tel"+i;
var P="P"+i;
$('#telZ').append(' <div id='+T+'><input type="text" size=20  name='+T+' placeholder='+T+'>  <input type="text" size=20  name='+P+' placeholder="Parent"></div>');
document.getElementById('nbr').value=i;
}
//Ajout Nouveau diplome 
function addDiplome(){
j= document.getElementById('nbr2').value;
j++;
var dip="diplome"+j;
var A="dipA"+j;
$('#dip').append('<div id='+dip+'><br><textarea cols="30" rows="2" name='+dip+' ></textarea> <br> <input type="text" size=8  name='+A+' placeholder="Année"></div>');
document.getElementById('nbr2').value=j;
}
//Ajout Nouveau Formation par starz

function addFS(){

var x=document.getElementById('nbr3').value;
x++;

var fs="FS"+x;
var Zfs="ZFS"+x;
var M="mFS"+x;
var dd="dateDF"+x;
var df="dateFF"+x;
$('#divFS').append('<div id='+Zfs+'> <br><span class="custom-dropdown custom-dropdown--white custom-dropdown--small"><select '+fs+' id='+fs+' style="width:150px" onFocus=listeFormation("'+fs+'"); class="custom-dropdown__select custom-dropdown__select--white"><option value="s">Select ...</option></select></span></div>');
document.getElementById('nbr3').value=x;

}

///DELTE diplome
function deleteDiplome(){	
j= document.getElementById('nbr2').value;  
var D1="#diplome"+j; 

if(j>1){

	
	
	$(D1).remove();
	j--;
	document.getElementById('nbr2').value=j;
     }
	 
	
}
///DELTE TEL
function deleteTel(){	   
if(i>1){
	var D="#tel"+i;
	$(D).remove();
	i--;
	document.getElementById('nbr').value=i;
     }
}
///DELTE FS

function deleteFS(){
var x=document.getElementById('nbr3').value;

if(x>1){
	var D="#ZFS"+x;
	$(D).remove();
	x--;
	document.getElementById('nbr3').value=x;
}

}

//verifier tt les champs 
function verifier(){
	
var val=document.getElementById("mat").value;
var val1=document.getElementById("ncin").value;
var val2=document.getElementById("nom").value;
var val21=document.getElementById("prenom").value;
var val4=document.getElementById("dateN").value;
var dateE=document.getElementById("dateE").value;
var val5=document.getElementById("ad1").value;
var val6=document.getElementById("tel1").value;

var val8=document.getElementById("salaire").value;
var liste1 = document.getElementById("contrat");
var val3 = liste1.options[liste1.selectedIndex].value;	 
var liste2 = document.getElementById("cat");
var cat = liste2.options[liste2.selectedIndex].value;
 if(val==""){
	alert("Ajouter un matricule SVP !!");
	document.getElementById('mat').style.backgroundColor='pink'; 
}
		  	
/*else if(val1==""){
	alert("Donnez LE NCIN du personnel  SVP !!");
	document.getElementById('ncin').style.backgroundColor='pink';
          		  
}*/
 else if(val2==""){
	alert("Donnez le nom SVP !!");
	document.getElementById('nom').style.backgroundColor='pink'; 
}else if(val21==""){
	alert("Donnez le prenom SVP !!");
	document.getElementById('prenom').style.backgroundColor='pink'; 
}/* else if(val4==""){
	alert("Donnez la date naissance SVP!!");
	document.getElementById('dateN').style.backgroundColor='pink'; 
}*/
/* else if(val5==""){
	alert("Donnez une adresse SVP !!");
	document.getElementById('ad1').style.backgroundColor='pink'; 
}*/
/*else if(val6==""){
	alert("Donnez un numéro de téléphone SVP !!");
	document.getElementById('tel1').style.backgroundColor='pink'; 
}*/	
else if(val3=="s"){
	alert("Type contrat ?!! ");
	document.getElementById('contrat').style.backgroundColor='pink'; 
}else  if(cat=="s"){
	alert("Catégorie personnel ?!! ");
	document.getElementById('cat').style.backgroundColor='pink'; 
}else if(val8==""){
	alert("Le salaire brut SVP !!");
	document.getElementById('salaire').style.backgroundColor='pink'; 
} else if(dateE==""){
	alert("Date entrée  SVP !!");
	document.getElementById('dateE').style.backgroundColor='pink'; 
}
else {
	document.getElementById('nbr').value=i;
	document.forms['form1'].submit(); 
}
}
///Insertion image personnel
function fileChange(){
   var x = document.getElementById("fileP"); 
   var fReader = new FileReader();
   fReader.readAsDataURL(x.files[0]);
   fReader.onloadend = function(event){
   var img = document.getElementById("imgP");
   img.src = event.target.result;
   }
}
////
function listeFormation(zone){
 var z="#"+zone;
 $.ajax({
	url: '../php/listeFormation.php',
	type: 'POST',			
	success:function(data){
	$(z).html(data);
}});
}

//Vérification de l'existance du matricule
function verifierM(){
  var M=document.getElementById("mat").value;
  $.ajax({
        type: 'POST',
        data : 'D=' + M,
        url: '../php/verif_doubleP.php',
        success: function(data) {
		if(data==1){
	       alert("Matricule existe déja !!");
		   document.getElementById("mat").value="";
		   }
        }});
}
</script>
</head>

<body >
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


<BR>
<p class="there">Ajout Personnel</p>





<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>
<br>
<hr>
<form method="post"  id="form1" action="../php/ajout_personnel.php" enctype="multipart/form-data">


<TABLE > 

		<TR> 
			<Th>Matricule: </Th> 
			<TD><input type="text" id="mat" name="mat" SIZE="20" onBlur="verifierM();"></TD> 
			  <td colspan=2 rowspan=4>
                <center><img src="../image/profil/image_user.png" alt="user" style="width:120px;height:100px;" id="imgP"></center>



			  </td>			
		</TR> 	
		<TR> 
			
		
			<Th>Nom & Prenom: </Th> 
			<TD>
			<input type="text" id="prenom" name="prenom" SIZE="20" placeholder="Prenom">
			<input type="text" id="nom" name="nom" SIZE="20" placeholder="NOM">
			
			</TD> 
			 		
		</TR> 
		<TR> 
		    <Th>CIN: </Th> 
			<TD ><input type="text" id="ncin" name="ncin" SIZE="20"></TD> 
			</tr>
			<tr>
			<Th>Matricule CNSS: </Th> 
			<TD ><input type="text" id="cnss" name="cnss" SIZE="20"></TD> 
			 
			</tr><tr>
			<Th>Date naissance: </Th> 
			<TD ><input type="date" id="dateN" name="dateN" SIZE="20"></TD> 
		    <td colspan=2> 
			
			<center><input type="file" multiple="multiple" name="fileP" id="fileP"  onChange="fileChange();"/></center>
				
			</td>
						
		</TR> 
        <TR> 
			<Th  >Adresse 1: </Th> 
			<TD ><textarea cols=30 rows=2 name="ad1" id="ad1" placeholder="Adresse ... "></textarea></TD>
			
			<Th  >Adresse 2: </Th> 
			<TD ><textarea cols=30 rows=2 name="ad2" id="ad2" placeholder="Adresse ... "></textarea></TD> 
						
		</TR> 
		<TR> 
			<Th  >TEL : </Th> 
			<TD id="telZ"><input type="text" id="tel1" name="tel1" SIZE="20" placeholder="tel1"> 
			<input type="text" id="P1" name="P1" SIZE="20" value="Personnel" READONLY>
			<input type="button" onclick="addTel();" value="+" >
			<input type="button" onclick="deleteTel();" value="-" >
			<input type="text" id="nbr" name="nbr" SIZE="2" value="1" HIDDEN>
			</TD> 
				<Th  >E-mail : </Th> 
			<TD ><input type="text" id="mail" name="mail" SIZE="30" placeholder="exemple@exp.com">		
		</TR> 
		<tr>
		<Th  >Diplome & Formation: </Th> 
			<TD ><div id="dip"><textarea cols=30 rows=2 name="diplome1" id="diplome1" placeholder="Diplome ... "></textarea> 
			<br>
			<input type="text" name="dipA1" id="dipA1"  size="8" placeholder="Année">
			
			</div>
			<br>
			<input type="button" onclick="addDiplome();" value="+" >
			<input type="button" onclick="deleteDiplome();" value="-" >
			<input type="text" id="nbr2" name="nbr2"  value="1" HIDDEN>
			</TD> 
			<Th  >Starz training: </Th> 
			<TD >
			
			<div id="divFS">
			 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="FS1" id="FS1" style="width:150px" onFocus="listeFormation('FS1');" class="custom-dropdown__select custom-dropdown__select--white">			
			<option value="s">Select ...</option>
		
			</select>
			</span>
			</div>
			<br>
			<input type="button" onclick="addFS();" value="+" >
			<input type="button" onclick="deleteFS();" value="-" >
			<input type="text" id="nbr3" name="nbr3"  value="1" HIDDEN>
			</TD> 
  
						
		</TR> 
		<tr>
            <TH>Contrat: </TH> 
            <TD> <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="contrat" id="contrat"  class="custom-dropdown__select custom-dropdown__select--white">
			
			<option value="s">---Selctionnez</option>
			<option value="SIVP">SIVP</option>
			<option value="CDI">CDI</option>
            <option value="CDD">CDD</option>
            <option value="Contrat apprentit">Contrat apprentit</option>
            <option value="Non contractuel">Non contractuel</option>	
			
			</select>
			</span></TD> 

<TH >Catégorie: </TH> 
<td >

  <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="cat" id="cat"  class="custom-dropdown__select custom-dropdown__select--white">
			
			<option value="s">--Selectionnez</option>
			<option value="Ouvrier">Ouvrier</option>
			<option value="Apprentit">Apprentit</option>
			<option value="Saisonier">Saisonier</option>
			<option value="Stagiaire">Stagiaire</option>
			<option value="Technicien">Technicien</option>
			<option value="Technicien supérieur">Technicien supérieur</option>
			<option value="Ingénieur">Ingénieur</option>
			<option value="Cadre">Cadre</option>
			</select>
	 </span>	
</td></tr>
<tr>
           <Th  >Salaire Brut: </Th> 
			<TD><input type="text" id="salaire" name="salaire" SIZE="20">
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="typeS" id="typeS"  class="custom-dropdown__select custom-dropdown__select--white">
			
			<option value="V">Variable</option>
			<option value="F">Fixe</option>
           
			
			</select>
			</span>
			</TD> 	
            <Th  >Date entrée:</Th><td>
			<input type="date" id="dateE" name="dateE" SIZE="20">
		
			</TD>			
		   </TR>
		   <tr>
		   <Th  >Congés accumulés:</Th><td colspan=3>
			<input type="text" id="conge" name="conge" SIZE="20" placeholder="NBR heure">
		
			</TD>			
		   </TR> 
		<tr>
			<Th  >Note: </Th> 
			<TD colspan="3"><textarea cols=30 rows=4 name="note" id="note" placeholder="Commentaire ..."></textarea><br>
			</td>
			</tr>
			<tr><td></td><td colspan=3>
			<input type= "file" name="cv[]"  multiple>
			</TD> 
						
		</TR> 
		
<td ></td><td colspan=3> <input type="button" id="submitbutton" onclick="verifier()" value="AJOUTER >>"></td>
</tr>
</table>


		


 
</form>


</div>
</div>
</body>
</html>
<?PHP 

if(!empty($_GET['status']))
{ 
     $status = $_GET['status']; 
     if  ($status=="sent")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Personnel ajouté avec succès \');</SCRIPT>';
	 //header('Location: ../pages/ajout_fact.php');
	 } else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Fail !! veuillez réessayer SVP \');</SCRIPT>';}
} 
?>