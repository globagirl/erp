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
//les variables global
var i=0;
///////Auto Complete //////
function autoComplete(){
var min_length =1; 
	var keyword = $('#PO').val();	
	if (keyword.length >= min_length) {
	var zoneC="#PO";
		$.ajax({
			url: '../php/autoL_planned_po.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC,
			success:function(data){
				$('#listePO').show();
				$('#listePO').html(data);
			}});
	}else {
		$('#listePO').hide();
	}
}
//
function hideListe() {
	
    
	$('#listePO').hide();
	}
//	
function choixListe(p,z) {
	$(z).val(p);
}
////////////////////////////////////FIN///////////////

//affichage de la liste des articles
function afficheArticle(){
	
 var valeur = document.getElementById("PO").value;
 if(valeur==""){
 alert("Selectionnez un PO SVP !!");
 }
 else{
	 var nbr=document.getElementById('nbr').value;
	 $.ajax({
          type: 'POST',
          data : 'PO=' + valeur,
          url: '../php/sortie_affiche_article.php',
          success: function(data) {
		  if(data != "0"){
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
			}else{
			alert("verifier le PO svp ");
            }			
           }});
	 
	 
	 
 }
 
}
//////Affichage des listes des articles
function affichelisteA(art){

	var req = new XMLHttpRequest();
	req.onreadystatechange = function()
   { 
      if(req.readyState == 4)
      {
         if(req.status == 200)
         {
            var prd=document.getElementById(art);
            prd.innerHTML=req.responseText;
		   
              
         }	
        
      } 
   };
   
   req.open("POST", "../php/sortie_liste_article.php",true);
   req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
   req.send("commande=" + escape(valeur));
 
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

function add(){
var PRD=document.getElementById('PRD').value;
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
		   data:'produit=' +PRD, 
           url: '../php/sortie_liste_article.php',
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
///// Désactiver l entrée 
function desactiveEnter(){ 
 if (event.keyCode == 13) { 
      event.keyCode = 0; 
      window.event.returnValue = false; 
 } 
} 
</script>
</head>

<body onKeyDown='desactiveEnter()'>


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


<p class="there">Sortie Stock</p>
<br>

<form action="../php/sortie_stock.php" method="POST" id="form1">
<table>
<tr>
 <th ALIGN="left" colspan="2">N° PO: </th> 
 <td colspan=4>

<input type="text" id="PO" name="PO" SIZE="20" placeholder="PO client " onKeyup="autoComplete();" onFocus="autoComplete()"  onBlur="hideListe();">
 
<input type="button" id="submitbutton" value="OK" onclick="afficheArticle()"/>
<div class="divAuto2"><ul id="listePO" ></ul></div>
  </td>
 <td></td>
 </tr></table>

 <div id="divProd" ></div>
<table style="visibility:hidden" id="tabX">
 <tr >
 <th>Gerer les paquets: <input type="text" id="nbr" name="nbr" size="8" style="visibility:hidden"></th> 
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
<?PHP 

if(!empty($_GET['status']))
{ 
     $status = $_GET['status']; 
     if  ($status=="sent")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Stock sortie avec succès \');</SCRIPT>';
	 //header('Location: ../pages/ajout_fact.php');
	 } else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Fail !! veuillez réessayer SVP \');</SCRIPT>';}
} 
?>