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
<script type="text/javascript" src="tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<title>
Invoice payment
</title>
<SCRIPT>
 ///////Auto Complete //////
function autoComplete(){
   var min_length =2; 
	var keyword = $('#supplier').val();	
	if (keyword.length >= min_length) {
	var zoneC="#supplier";
		$.ajax({
			url: '../php/auto_liste_Finvoice.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC,
			success:function(data){
				$('#listeF2').show();
				$('#listeF2').html(data);
			}});
	}else {
		$('#listeF2').hide();
	}
	
}
//
function hideListe() {
	
    
	$('#listeF2').hide();
	}
//	
function choixListe(p,z) {
    var ch=p.replace("|"," ");
    ch=ch.replace("|"," ");
    ch=ch.replace("|"," ");
    ch=ch.replace("|"," ");
	$(z).val(ch);
	
}
 
 //
function afficheInvoice(){
	var liste1 = document.getElementById("recherche");
    var val1 = liste1.options[liste1.selectedIndex].value;    	
    if(val1=="s" || val1=="s2"){//Payment par fournisseur
        if(val1=="s" ){
	        var liste2 = document.getElementById("supplier");
			var valeur = liste2.options[liste2.selectedIndex].value;
	    }else {
	        var valeur = document.getElementById("supplier").value;
	    }
	    $.ajax({
            type: 'POST',
			data : 'supplier=' + valeur ,
			url: '../php/affiche_supplier_invoice.php',
			success: function(data) {	   
         		$('#divTT').html(data);    
	        }
		});
    }else if(val1=="m"){//Payment par mode de payment
	    var valeur = document.getElementById("invoice").value;	  
	    var modePay = document.getElementById("modeP").value;	  
	    $.ajax({
            type: 'POST',
            data : 'invoice=' + valeur+'&modeP=' + modePay ,
            url: '../php/affiche_supplier_invoice3.php',
            success: function(data){ 
				$('#divTT').html(data); 
                if(modePay=="Cheque" || modePay=="Virement"){
				    listeBanque();
                }				
            }
		});
    }else{//Payment par N° d'invoice
	    var valeur = document.getElementById("invoice").value;	  
	    $.ajax({
            type: 'POST',
            data : 'invoice=' + valeur ,
            url: '../php/affiche_supplier_invoice2.php',
            success: function(data){ 
				$('#divTT').html(data);              
            }
		});
    }
}
//Payment d'une facture
function closeInvoice(x,i){
    var tab="#tab"+i;
	var dateP="dateP"+i;
	var modeP="modeP"+i;
	var liste = document.getElementById(modeP);
	modeP = liste.options[liste.selectedIndex].value;
	dateP = document.getElementById(dateP).value;
    if(modeP !='S'){
        if(modeP=='Virement' || modeP=='Cheque'){
	        var ref="ref"+i;			
			var NC="NC"+i;
			ref = document.getElementById(ref).value;		
			NC = document.getElementById(NC).value;
			$.ajax({
                type: 'POST',
				data : 'invoice=' +x+'&dateP=' +dateP+'&ref=' +ref+'&NC='+NC+'&modeP=' +modeP ,
				url: '../php/invoice_payment.php',
				success: function(data) {		 
			        $(tab).remove();            	 
                }
			});
	    } else if(modeP=='Autre'){
	        var ref="ref"+i;			
			ref = document.getElementById(ref).value;
			if(ref == ""){
			ref=modeP;
			}
			$.ajax({
                type: 'POST',
				data : 'invoice=' +x+'&dateP=' +dateP+'&modeP='+ref ,
				url: '../php/invoice_payment.php',
				success: function(data) {		 
			        $(tab).remove();            	 
                }
			});
	    }else{
		    $.ajax({
                type: 'POST',
				data : 'invoice=' +x+'&dateP=' +dateP+'&modeP=' +modeP ,
				url: '../php/invoice_payment.php',
				success: function(data) {		 
				    $(tab).remove();	             	 
                }
		    });
	    }
    }else{
        alert("Selectionnez le mode de payment SVP !!");
    }
}
///Affichage des zone du a un payment par chéque ou par virement
function afficheMP(i){
    var ref="ref"+i;	
	var NC="NC"+i;
	var NCid="#NC"+i;
	var modeP="modeP"+i;
	var zoneMP="#zoneMP"+i;
	var liste = document.getElementById(modeP);
	val = liste.options[liste.selectedIndex].value;
    if(val =="Autre"){
	    $(zoneMP).html('<center><input type="text"  id='+ref+' name='+ref+' size="40" placeholder="Mode de payment" ></center> ');
	}else if(val != "Cache"){
		$(zoneMP).html('<center><input type="text"  id='+ref+' name='+ref+' size="25" placeholder="Réference" > <select id='+NC+'  name='+NC+' ></select></center>');
		$.ajax({
        type: 'POST',  
        url: '../php/liste_compteNum.php',
        success: function(data) {
        $(NCid).html(data);
        }
	    });
	}else{
		$(zoneMP).html('');
	} 
}

//
function listeBanque(){
    $.ajax({
        type: 'POST',  
        url: '../php/liste_compteNum.php',
        success: function(data) {
        $("#NC").html(data);
        }
	});
}
////////////////////////////////////////////////////////////////
function afficheZone(){
	var liste1 = document.getElementById("recherche");
	var val1 = liste1.options[liste1.selectedIndex].value;
	if(val1=="s"){
	    $('#di2').html('');
	    $('#di').html(' <select id="supplier" name="supplier" style="width:200px"  ><option value="1">---Selectionnez</option></select>');
        $.ajax({
            type: 'POST',
            url: '../php/listeFournisseur.php',
            success: function(data) {
            $('#supplier').html(data);
            }
	    });
	}else if (val1=="s2"){
  
		$('#di').html('<input type="text" id="supplier" name="supplier" onKeyup="autoComplete();" onFocus="autoComplete()" onBlur="hideListe();">  <div class="divAuto2"><ul id="listeF2" ></ul></div>');
		$('#di2').html('');
	}else if (val1=="m"){
		$('#di').html('<select id="modeP" name="modeP" style="width:200px"  ><option value="Cheque">Cheque</option><option value="Virement">Virement</option><option value="Cache">Cache</option><option value="Autre">Autre...</option></select> ');
		$('#di2').html('<input type="text" name="invoice" id="invoice" size="25" placeholder="N° facture" > ');
	}else{
		$('#di').html(' <input type="text" name="invoice" id="invoice" size="25"  >');
		$('#di2').html('');
	} 
}
	   
//Désactiver le button entrer 
function desactiveEnter(){ 
 if (event.keyCode == 13) { 
      event.keyCode = 0; 
      window.event.returnValue = false; 
 } 
} 			   
</SCRIPT> 
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
</div>

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');	
}
elseif($role=="FIN2"){
include('../menu/menuFin2.php');	
}elseif($role=="FIN"){
include('../menu/menuFinance.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Invoice Payment</p>

<br>

<!-- end --> 





<form id="form1" method="POST" action="../php/invoice_payment2.php">
<table> 
<tr>
<th width="100 px">Search : </th>
 <td width="150 px">
 <span class="custom-dropdown custom-dropdown--white custom-dropdown--small" style="float:right">
	 <select name="recherche" id="recherche" onChange="afficheZone();" class="custom-dropdown__select custom-dropdown__select--white" >
	         <option value="1">---Selectionnez</option>
			 <option value="s">Supplier</option>
			 <option value="s2">Undefined supplier</option>
	         <option value="i"> Invoice N°</option> 
	         <option value="m"> Mode payment</option> 
			 

   </select> 
   </span>
   </td>
   <td id="di" width="250 px">

		   <input type="text" name="invoice" id="invoice" size="20"  >
    
    </td>
	<td id="di2" width="50px"></td>
 <td>
  
 <input type="button" id="submitbutton" value="OK" onclick="afficheInvoice();">  
 </td>
 </tr>
 </table>
 <div id="divTT">
 </div>
 
</form>


</div>


</div>
</body>

</html>