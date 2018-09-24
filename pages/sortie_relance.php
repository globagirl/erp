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
Sortie Stock
</title>
<script>
//affichage de la liste des articles
function afficheDemande(){
	
	 var liste3 = document.getElementById("demande");
     var demande= liste3.options[liste3.selectedIndex].value;
	 if (demande=="s"){
	 alert("Selectionnez une demande SVP !! ");
	 }else{
	 $.ajax({
          type: 'POST',
          data : 'demande=' + demande,
          url: '../php/relance_afficheA2.php',
          success: function(data) {
                    $('#zone').html(data);
					document.getElementById("tabX").style.visibility ="visible";
					
					
           }});
	 
	 }
	 
 }

//affichage de la liste des articles
/*function afficheDemande(){
	
 var valeur = document.getElementById("OF").value;
 if(valeur==""){
 alert("Selectionnez un ordre de fabrication SVP !!");
 }
 else{
	 var nbr=document.getElementById('nbr').value;
	 $.ajax({
          type: 'POST',
          data : 'OF=' + valeur,
          url: '../php/sortie_affiche_article.php',
          success: function(data) {
                    $('#divProd').html(data);
					if(nbr==0){
						document.getElementById("tabX").style.visibility ="visible";
					}else{
						while(i>0){
	                          var D="#TR"+i;
                              $(D).remove();
	                          i--;
                               }
							   
					document.getElementById('nbr').value=i;
					document.getElementById("tabX").style.visibility ="visible";
					}
					
           }});
	 
	 
	 
 }
 
}*/
//////Affichage des listes des articles
function affichelisteA(art){
 var a='#'+art;
var liste3 = document.getElementById("demande");
     var demande= liste3.options[liste3.selectedIndex].value;
	 if (demande=="s"){
	 alert("Selectionnez une demande SVP !! ");
	 }else{
	 $.ajax({
          type: 'POST',
          data : 'demande=' + demande,
          url: '../php/relance_afficheA3.php',
          success: function(data) {
                    $(a).html(data);
					
					
					
           }});
	 
	 }
 
}

///////////////Affichage des listes des paquets 
function affichelisteP(art,p){
	
var liste = document.getElementById(art);
 var valeur = liste.options[liste.selectedIndex].value;
 if(valeur=="0"){
	 alert("Selectionnez un article SVP !!");
 }
 else{
	var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
            var prd=document.getElementById(p);
           prd.innerHTML=req.responseText;
		   
              
         }	
        
      } 
   };
   
   req.open("POST", "../php/sortie_liste_paquet.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("article=" + escape(valeur));
 }
 //alert(valeur);
}

////////////////////////////////////////////////
//Stock paquet
function stockP(p,s,x){	 
var v=0;
var n=1;


var liste = document.getElementById(p);
 var valeur = liste.options[liste.selectedIndex].value;
 if(valeur==""){
	 alert("Selectionnez un paquet SVP !!");
 }else{
     if (x>1){
     while((n<x )&& (v==0)){
	 var P1="P"+n;
	 var L1 = document.getElementById(P1);
     var val1 = L1.options[L1.selectedIndex].value;
	 if(val1==valeur){
	 v=1;
	 }else{
	 n++;
	 }}}
	 if(v==0){
	 $.ajax({
          type: 'POST',
          data : 'paq=' + valeur,
          url: '../php/sortie_stock_paquet.php',
          success: function(data) {
	      document.getElementById(s).value=data;
          
	  }});
	  }else{
	  alert("Ce paquet existe déja ");
	  }
	

}}
///////////////
function verifier(){	 
var nbr=document.getElementById('nbr').value;
var v=0;
var j=1;
while ((j<=nbr)&&(v==0)){
	
	var s="S"+j;
	var q="Q"+j;
	var st=document.getElementById(s).value;
	var qt=document.getElementById(q).value;
	st=parseFloat(st);
	qt=parseFloat(qt);
	if(st<qt){
		v=1;
		document.getElementById(q).style.backgroundColor='pink'; 
	}
	else{
		j++;
	}
}
 if(v==0)
   {
      document.getElementById('form1').submit();
	  //alert(nbr);
	  
   }else{
   alert("Vérifier vos valeur SVP !!");
   }
   
    
}

////////////////////////
var i=0;
function add(){
var demande=document.getElementById('demande').value;
i++;
document.getElementById('nbr').value=i;
var A="A"+i;
var A2="#A"+i;
var P="P"+i;
var S="S"+i;
var Q="Q"+i;
var TR="TR"+i;
$('#trB').before('<TR id='+TR+'><TH >Article '+i+' </TH><td><select id='+A+' name='+A+' style="width:200px" onChange=affichelisteP("'+A+'","'+P+'");   ><option value="1">---Selectionnez</option></select><th> Paquet  </th><td > <select id='+P+' name='+P+' style="width:200px" onChange=stockP("'+P+'","'+S+'","'+i+'");><option value="1">---Selectionnez</option></select><input type="text" id='+S+' name='+S+' size="8" READONLY></td><td><input type="text" style="float:left" id='+Q+'  name='+Q+' size="8" placeholder="QTY"/></td><td></td></tr>');
 $.ajax({
           type: 'POST',
		   data:'demande=' +demande, 
           url: '../php/relance_afficheA3.php',
           success: function(data) {
           $(A2).html(data);

           }});
			  
	       
		   
 

	}



////
function deleteZ(){
	

if(i>1){
	var D="#TR"+i;
    $(D).remove();
	i--;
   document.getElementById('nbr').value=i;
}

}
///// 
function desactiveEnter(){ 
 if (event.keyCode == 13) { 
      event.keyCode = 0; 
      window.event.returnValue = false; 
 } 
} 
</script>
</head>

<body onKeyDown="desactiveEnter()">


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


<p class="there">Sortie Relance</p>




<br>

<!-- end --> 
<?php
include('../connexion/connexionDB.php');
?>

<form action="../php/relance_sortie.php" method="POST" id="form1">
<table>
<tr>
 <TH colspan="2">Demande relance N°: </TH> 
 <td colspan=4>

<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
<select id="demande" name="demande" class="custom-dropdown__select custom-dropdown__select--white">
<option value="s">---Selectionnez</option> 
<?php
  $sql=mysql_query("SELECT * from demande_relance where statut='C2'");
  while($data=mysql_fetch_array($sql)) {
  echo '<option value="'.$data["IDrelance"].'">'.$data["IDrelance"].'</option><br/>'; 
}
?>
</select>
</span> 
 
<input type="button" id="submitbutton" value="OK" onclick="afficheDemande()"/>

  </td>

 </tr></table>

 <table id="zone" ></table>
<table style="visibility:hidden" id="tabX">
 <tr >
 <TH Wcode_articleTH=100 HEIGHT=30 colspan="5"  ALIGN="left">Gerer les paquets: <input type="text" id="nbr" name="nbr" size="8" style="visibility:hidden"></TH> 
 <td>
 <input type="button" id="submitbutton" value="+" onclick="add()"/>
  <input type="button" id="submitbutton" value="-" onclick="deleteZ()"/>
 </td>
 </tr>
 <tr id="trB"> <td></td><td colspan=6><input type="button" id="submitbutton" value="Valider" onclick="verifier()"/>
 </td></tr>
</table>
<div>	


 
</form>

</div>
</div>

</body>

</html>