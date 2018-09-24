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



<title>Ajout Commande</title>
<script>
var i=1;
var v=0;
var v2=0;
////////////////////////LISTE LIKE GOOGLE :) /////////////
function autoComplete(c,l){
var zoneC="#"+c;
var zoneL="#"+l;
var min_length =3;
	var keyword = $(zoneC).val();
	if (keyword.length >= min_length) {

		$.ajax({
			url: '../php/auto_liste_produit.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC,
			success:function(data){
				$(zoneL).show();
				$(zoneL).html(data);
			}});
	}else {
		$(zoneL).hide();
	}
}
//
function hideListe(l) {

    var zoneL="#"+l;
	$(zoneL).hide();
	}
//
function choixListe(p,z) {
	$(z).val(p);
}
////////////////////////////////////FIN///////////////
//Ajout Nouvelle zone Item
function addItem(){
i++;
var po=document.getElementById("PO").value;
var T="TR"+i;
var PON="POI"+i;
var PN="P"+i;
var PU="PU"+i;
var QN="Q"+i;
var PT="PT"+i;

var POV=po+"-"+i;
var listeP="listeP"+i;
$('#TRF').before('<tr id='+T+'><td colspan=5> <input type="text" size=20 id='+PON+' name='+PON+' value='+POV+' READONLY> <input type="text" size=20 id='+PN+' name='+PN+' placeholder="Item N°"  onBlur=hideListe("'+listeP+'"); onKeyup=autoComplete("'+PN+'","'+listeP+'"); onFocus=autoComplete("'+PN+'","'+listeP+'")>  <input type="text" id='+QN+' name='+QN+' size="20" placeholder="QTY" onBlur=verifierProduit("'+PN+'","'+QN+'","'+PU+'","'+PT+'"); /> <input type="text" id='+PU+' name='+PU+' placeholder="Unit price" size="20"  READONLY > <input type="text" id='+PT+' name='+PT+' size="20"  placeholder="total price" READONLY> <div class="divAuto"><ul id='+listeP+' ></ul></div> </td></tr>');
document.getElementById('nbr').value=i;
}
///DELTE ITEM
	function deleteItem(){

    if(i>1){
		var D="#TR"+i;
		var q="Q"+i;
		var p="PT"+i;
	    var qty=document.getElementById(q).value;
		var prix=document.getElementById(p).value;
		if(prix==""){
		prix=0;
		}
	    prix=parseFloat(parseFloat(prix).toFixed(6));
		if(qty==""){
		qty=0;
		}
	    qty=parseFloat(parseFloat(qty).toFixed(6));
		var qtyT=document.getElementById('totalQ').value;
		var prixT=document.getElementById('totalP').value;
		if(prixT==""){
		prixT=0;
		}
	    prixT=parseFloat(parseFloat(prixT).toFixed(6));
		if(qtyT==""){
		qtyT=0;
		}
	    qtyT=parseFloat(parseFloat(qtyT).toFixed(6));

		var x1=qtyT-qty;
		x1=parseFloat(parseFloat(x1).toFixed(6));
		var x2=prixT-prix;
		x2=parseFloat(parseFloat(x2).toFixed(6));
		 document.getElementById('totalQ').value=x1;
		document.getElementById('totalP').value=x2;
			$(D).remove();
   	     i--;
        document.getElementById('nbr').value=i;
     }

}



//POP UP
function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no')
}

//Vérification produit
function verifierProduit(P,Q,PU,PT){
var prd=document.getElementById(P).value;
var qty=document.getElementById(Q).value;
var Tqty=document.getElementById('totalQ').value;
if(Tqty==""){
Tqty=0;
}
Tqty=parseFloat(parseFloat(Tqty).toFixed(6));
var Tprice=document.getElementById('totalP').value;
if(Tprice==""){
Tprice=0;
}
Tprice=parseFloat(parseFloat(Tprice).toFixed(6));
	$.ajax({
          type: 'POST',
          data : 'produit=' + prd+'&qty=' + qty,
          url: '../php/verifChampsCommande.php',
          success: function(data) {
              if(data==0 ){
                if(v2==0){
					         alert("Le produit n'existe pas , veillez ajouter un nouveau produit SVP !!");
                }
			         document.getElementById(P).style.backgroundColor='pink';
					     document.getElementById(Q).value='';
               v2=1;
					    }else{
						//alert(data);
            v2=0;
	          document.getElementById(PU).value=data;
						var p=parseFloat(parseFloat(data).toFixed(6));
						qty=parseFloat(parseFloat(qty).toFixed(6));
						PTV=qty*p;
						PTV=parseFloat(parseFloat(PTV).toFixed(6));
						document.getElementById(PT).value=PTV;
						var x1=Tqty+qty;
		                x1=parseFloat(parseFloat(x1).toFixed(6));
		                var x2=Tprice+PTV;
		                x2=parseFloat(parseFloat(x2).toFixed(6));
						document.getElementById('totalQ').value= x1;
						document.getElementById('totalP').value= x2;
						document.getElementById(P).style.backgroundColor='white';

                    }
           }});

}
///// Verifier PO
function verifierPO(){
    var val=document.getElementById("PO").value;
	var x= val.indexOf(" ");
	if( x > -1){
	    alert("Le numéro de la commande ne doit pas contenir un espace ");
		document.getElementById('PO').style.backgroundColor='pink';
		//v=0;
	}else{
        $.ajax({
			url: '../php/verifChampsCommande2.php',
			type: 'POST',
			data: "PO="+val,
			success:function(data){
				if(data=="0"){
			        alert("Ce PO existe déja , veillez verifier vos valeurs SVP !!");
					document.getElementById('PO').style.backgroundColor='pink';
                    //v=0;
                }else{
		            document.getElementById("POI1").value=val+"-1";
					//v=1;
		        }
        }});
	}
}

//verifier tt les champs
function verifier(){
    var val=document.getElementById("PO").value;
	var val1=document.getElementById("P1").value;
	var val2=document.getElementById("Q1").value;
	var liste1 = document.getElementById("client");
    var val3 = liste1.options[liste1.selectedIndex].value;
	var val5=document.getElementById("dateD").value;
	var val6=document.getElementById("dateE").value;
	var val7=document.getElementById("totalQ").value;
	var val8=document.getElementById("totalP").value;
    if(val==""){
	    alert("Ajouter un PO SVP !!");
		document.getElementById('PO').style.backgroundColor='pink';
	}else  if(val3=="s"){
		alert("Ajouter un client SVP !!");
		document.getElementById('client').style.backgroundColor='pink';
		V=1;
    }else if(val5==""){
		alert("Donnez la date demandée par le client  SVP !!");
		document.getElementById('dateD').style.backgroundColor='pink';
    }else if(val6==""){
		alert("Donnez la date d'expédition confirmée SVP !!");
		document.getElementById('dateE').style.backgroundColor='pink';
	}else if(val1==""){
		alert("Ajouter un Produit SVP !!");
		document.getElementById('P1').style.backgroundColor='pink';
		V=1;
    }else if(val2==0){
		alert("Donnez la quantité du commande  SVP !!");
		document.getElementById('Q1').style.backgroundColor='pink';
		V=1;
    } else if(val7==0){
		alert("Quantité total SVP !!");
		document.getElementById('totalQ').style.backgroundColor='pink';
	} else  if(val8==0){
		alert("Calculez le prix total  SVP !!");
		document.getElementById('totalP').style.backgroundColor='pink';
    } else {
		document.getElementById('nbr').value=i;
		document.forms['formC'].submit();
	}
}
////
function affichelisteC(){
    $.ajax({
			url: '../php/listeClient.php',
			type: 'POST',
			success:function(data){
		   $('#client').html(data);
    }});
}
////
function autoPO(){
    var PO = document.getElementById("PO").value;
	$.ajax({
          type: 'POST',
          url: '../php/auto_PO.php',
          success: function(data) {
			 var PO ="PO"+data;
			 document.getElementById("PO").value=PO;

    }});
}

</script>
</head>

<body onLoad="affichelisteC();">
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


<BR>
<p class="there">Ajout Commande</p>
<br>
<br>
<hr>


<form method="post"  id="formC" action="../php/ajout_commande.php">


<table>

		<tr>
			<th >PO client: </th>
			<td colspan="4"><input type="text" id="PO" name="po" SIZE="20" onBlur="verifierPO();">
			<input type="checkbox" name="chek" id="chek"  value="oui" onclick="autoPO();">Ne passe pas par les étapes de production
			</td>


		</tr>

        <tr>
			<th >UPC: </th>
			<td colspan="4"><input type="text" id="UPC" name="UPC" SIZE="20" placeholder="UPC client " >

			</td>


		</tr>
		<tr>
			<th>Client : </th>
			<td colspan=4 >
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			    <select name="client" id="client" class="custom-dropdown__select custom-dropdown__select--white" onFocus="affichelisteC();">
				    <option value="s">---Selectionnez</option>
                </select>
            </span>
            <input type="button" onclick="pop_up('../pages/pop_ajout_client.php');" value="+" id="submitbutton">
			</td>
		</tr>
	    <tr>
			<th> Date demandée par le client: </th>
			<td colspan=4 ><input type="date" name="date_dem_clt" id="dateD"></td>
		</tr>
		<tr>
			<th>Date d’expédition confirmée par starz: </th>
			<td><input type="date" name="date_exp_conf" id="dateE"></td>
            <th>terme de payement: </th>
            <td colspan=2>
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			    <select name="tpay" id="tpay" type="text" class="custom-dropdown__select custom-dropdown__select--white">
			    <?php include('../include/utile/terme_payment.php'); ?>

			</select>
			</span>
			</td>
        </tr>
		<tr>
		    <td  id="TD1" colspan=4>
			    <input type="text" id="POI1" name="POI1" SIZE="20" placeholder="Purchase order N°" READONLY>
				<input type="text" id="P1" name="P1" SIZE="20" placeholder="Item N°" onKeyup="autoComplete('P1','listeP1');" onFocus="autoComplete('P1','listeP1')"  onBlur="hideListe('listeP1');">
				<input type="text" id="Q1" name="Q1" SIZE="20" placeholder="QTY" onBlur="verifierProduit('P1','Q1','PU1','PT1');">
				<input type="text" id="PU1" name="PU1" SIZE="20" placeholder="Unit price" READONLY>
				<input type="text" id="PT1" name="PT1" SIZE="20" placeholder="Total price" READONLY>
                <div class="divAuto"><ul id="listeP1" ></ul></div>
            </td>
			<td>
			    <input type="button" id="submitbutton" onclick="addItem()" value="+">
				<input type="button" id="submitbutton" onclick="deleteItem()" value="-">
            </td>
        </tr>
		<tr id="TRF">
		    <td colspan=4>
			    <input type="text" id="nbr" name="nbr" SIZE="5" HIDDEN>
				<b>Total QTY </b> <input type="text" id="totalQ" name="totalQ" SIZE="20" placeholder="0" READONLY>
				<b>Total price </b> <input type="text" id="totalP" name="totalP" SIZE="20" placeholder="0" READONLY>
				<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			        <select name="dev" type="text" class="custom-dropdown__select custom-dropdown__select--white">
					<?php include('../include/utile/devise.php'); ?>
			        </select>
	            </span>
            </td>
            <td>
			    <input type="button" id="submitbutton" onclick="verifier()" value="AJOUTER">
			</td>
        </tr>
</table>






</form>


</div>
</div>
</body>

</html>
