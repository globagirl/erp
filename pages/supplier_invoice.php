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
<title>Re-create supplier invoice</title>
<script>
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
////////////////////////////////////FIN///////////////
//Variable global pour vérification
var tax=0;
var coastS=0;
var VF=0;
// vérification numéro d'invoice
function verif_invoice(){
    var liste = document.getElementById('typeI');
	var typeI = liste.options[liste.selectedIndex].value;
	var supplier = document.getElementById('supplier').value;
    var invoice = document.getElementById('invoice').value;

    $.ajax({
        type: 'POST',
        data:'supplier=' + supplier +'&invoice=' + invoice,
        url: '../php/verification_num_invoice.php',
        success: function(data) {
            if(data=="1"){
		        alert("Check your invoice Number PLZ !!");
				VF=0;
		    }
			else{
		        VF=1;

		    }
        }
	});
}

//
function affiche_reception(){
  var liste = document.getElementById('typeI');
  var typeI = liste.options[liste.selectedIndex].value;
  if ((VF==1) || (typeI=="M")){

    if(typeI=="Expense"){
        var valeur = document.getElementById("supplier").value;
    }else{
        var liste1 = document.getElementById("supplier");
        var valeur = liste1.options[liste1.selectedIndex].value;
    }
    var invoice = document.getElementById("invoice").value;
	if(valeur=="s"){
	    alert("selectionnez un fournisseur  SVP !!");
    }else if(invoice=="" && typeI != "M"){
	    alert("Donnez le numéro de la facture  SVP !!");
    }else if(typeI=="Credit"){
	    $.ajax({
          type: 'POST',
          url: '../php/supplier_afficheR4.php',
          success: function(data) {
                    $('#arts').html(data);
           }});

    }else if(typeI=="Service" || typeI=="P2" ){
	    $.ajax({
          type: 'POST',
          url: '../php/supplier_afficheR1.php',
          success: function(data) {
                    $('#arts').html(data);
           }});

    }else if(typeI=="Expense"){
	    $.ajax({
          type: 'POST',
          url: '../php/supplier_afficheR1.php',
          success: function(data) {
                    $('#arts').html(data);
           }});

    }else if(typeI=="M"){
	    $.ajax({
          type: 'POST',
          url: '../php/supplier_afficheR3.php',
          success: function(data) {
                    $('#arts').html(data);
           }});

    }else{
	    $.ajax({
          type: 'POST',
          data : 'supplier=' + valeur,
          url: '../php/supplier_afficheR2.php',
          success: function(data) {
                    $('#arts').html(data);
           }});

    }
 }else{alert("Check your invoice Number PLZ !!"); }
}

/////
function pop_up(url){
window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no')
}
////
function affichelisteF2(){
        $.ajax({
        type: 'POST',

        url: '../php/listeFournisseur.php',
        success: function(data) {
        $('#supplier').html(data);
       }});
}
//Afficher la liste des fournisseurs
function affichelisteF(){
    var liste = document.getElementById('typeI');
	var typeI = liste.options[liste.selectedIndex].value;
	//Cas multiple service
	if(typeI=="M"){
        document.getElementById('invoice').disabled=true;
    }else{
        document.getElementById('invoice').disabled=false;
    }
	//
    if(typeI=="Expense"){
        $('#TDsupplier').html('<input type="text" id="supplier" name="supplier" onKeyup="autoComplete();" onFocus="autoComplete()" onBlur="hideListe();">  <div class="divAuto2"><ul id="listeF2" ></ul></div>');
    }else{
	    $('#TDsupplier').html('	<span class="custom-dropdown custom-dropdown--white custom-dropdown--small"><select name="supplier" id="supplier"  style="width:220px" class="custom-dropdown__select custom-dropdown__select--white" onChange="clearZone();" onFocus="affichelisteF2();"><option value="s">---Selectionnez</option> </select> </span> <input type="button" onclick=pop_up("../pages/pop_ajout_fournisseur.php") value="+"> ');

    }
}
///Ajout des prix a une facture
function addPrice(v1,v2){
	var val= document.getElementById('total').value;
	val=parseFloat(parseFloat(val).toFixed(6));
	var p=parseFloat(parseFloat(v2).toFixed(6));
	if( $('input[name='+v1+']').is(':checked') ){
		document.getElementById('total').value=val+p;
	}else{
	    var x=val-p;
	    x=parseFloat(parseFloat(x).toFixed(6));
		document.getElementById('total').value=x;
	}
}
///Ajout d'un tax a une facture
function addTax(){
	var val= document.getElementById('total').value;
	val=parseFloat(parseFloat(val).toFixed(6));
	var T= document.getElementById('tax').value;
	if(T==""){
		T=0;
	}
	tax=parseFloat(parseFloat(tax).toFixed(6));
	T=parseFloat(parseFloat(T).toFixed(6));
    var x= (val+T)-tax;
	x=parseFloat(parseFloat(x).toFixed(6));
	document.getElementById('total').value=x;
	tax=0;
}
///Sauvgarde de la valeur d'un taxe ajouté
function saveTax(){
	var val= document.getElementById('total').value;
	val=parseFloat(parseFloat(val).toFixed(6));
	var T= document.getElementById('tax').value;
	if(T==""){
		T=0;
	}
	T=parseFloat(parseFloat(T).toFixed(6));
	document.getElementById('total').value=val-T;
	document.getElementById('tax').value="";
}
///Ajout d'un shipment coast a une facture
function addCoastS(){
	var val= document.getElementById('total').value;
	val=parseFloat(parseFloat(val).toFixed(6));
	var T= document.getElementById('coastShip').value;
	if(T==""){
		T=0;
	}
	coastS=parseFloat(parseFloat(coastS).toFixed(6));
	T=parseFloat(parseFloat(T).toFixed(6));
	var x= (val+T)-coastS;
	x=parseFloat(parseFloat(x).toFixed(6));
	document.getElementById('total').value=x;
    coastS=0;
}
///Sauvgarde d'un shipment coast déja ajouté
function saveCoastS(){
	var val= document.getElementById('total').value;
	val=parseFloat(parseFloat(val).toFixed(6));
	var T= document.getElementById('coastShip').value;
	if(T==""){
		T=0;
	}
	T=parseFloat(parseFloat(T).toFixed(6));
	document.getElementById('total').value=val-T;
	document.getElementById('coastShip').value="";
}
//Purchase order
function addI2(){
    if(VF==1){
        var dateF= document.getElementById('dateF').value;
	    if(dateF==""){
	        alert("Donnez la date de la facture SVP !!");
	    }else{
            document.forms['form1'].submit();
	    }
	}else{
	    alert("Check your invoice NBR PLZ !!");
	}
}
///Service , credit note , expence
function addI1(){
    if(VF==1){
	    var coursTND= document.getElementById('coursTND').value;
		if(coursTND != ""){
	       document.form1.action="../php/supplier_invoice1.php";
           document.form1.submit();
		}else{
		   alert("Donner la cours du TND SVP !!");
        }
	}else{
	    alert("Check your invoice NBR PLZ !!");
	}
}
//Credit note
function addI4(){
    if(VF==1){
	    var coursTND= document.getElementById('coursTND').value;
		if(coursTND != ""){
	       document.form1.action="../php/supplier_invoice4.php";
           document.form1.submit();
		}else{
		   alert("Donner la cours du TND SVP !!");
        }
	}else{
	    alert("Check your invoice NBR PLZ !!");
	}
}
///multiple service
function addI3(){
	document.form1.action="../php/supplier_invoice3.php";
    document.form1.submit();
}

///Vider la zone
function clearZone(){
   $('#arts').empty();
}

///Afficher la liste des catégories
function afficheCat(){
    $.ajax({
        type: 'POST',
        url: '../php/listeCategory.php',
        success: function(data) {
        $('#catI').html(data);
        }
	});
}

// vérification numéro d'invoice 2
function verif_invoice2(V){
var liste1 = document.getElementById('supplier');
var supplier = liste1.options[liste1.selectedIndex].value;
var nbr = document.getElementById('nbr').value;
var invoice = document.getElementById(V).value;
//alert(invoice);
var i=1;
var verif=0;
while(i<nbr && verif==0){
var nom="inv"+i;
var inv = document.getElementById(nom).value;
if(inv==invoice && nom != V){
verif=1;
}else{
i++;
document.getElementById(nom).style.backgroundColor='white';
}
}
if(verif==0){
    $.ajax({
        type: 'POST',
        data:'supplier=' + supplier +'&invoice=' + invoice,
        url: '../php/verification_num_invoice.php',
        success: function(data) {
        if(data=="1"){
		alert("Check your invoice Number PLZ !!");
		}
       }});
}else{
document.getElementById(nom).style.backgroundColor='pink';
alert("Votre Invoice existe déja , vérifier vos invoice SVP ");
}
}

///Désactiver le button entrer
function desactiveEnter(){
    if (event.keyCode == 13) {
        event.keyCode = 0;
        window.event.returnValue = false;
    }
}
//Add zone
function addZ(){
    var x=document.getElementById("nbr").value;
    x++;
	var inv="inv"+x;
	var total="total"+x;
	var D="devise"+x;
	var img="imgFact"+x+"[]";
	//var img="imgFact"+x;
	var p="paid"+x;
	var Z="tabZ"+x;
	var modeP="modeP"+x;
	var zoneMP="zoneMP"+x;
	var dateP="dateP"+x;
	var dateF="dateF"+x;
	var coursTND="coursTND"+x;
	$('#divAdd').append('<table id='+Z+'><tr><td><center><b> Invoice N°: </b><input type="text" placeholder="Invoice N°" name='+inv+' id='+inv+' onBlur=verif_invoice2("'+inv+'")></center></td><td><b>Date facturation : </b><input  type="date" name='+dateF+' ></td><td><b>Amount : </b><input  type="text" name='+total+'  size=\"15 \" ><span class="custom-dropdown custom-dropdown--white custom-dropdown--small"> <select name='+D+' type="text" class="custom-dropdown__select custom-dropdown__select--white"><option value="TND">TND</option><option value="Euro">Euro</option><option value="Dollar">Dollar</option></select></span> <input  type="text" id='+coursTND+' name='+coursTND+'  placeholder="Cours TND" size="10" ></td></tr><tr><td><center> <b>Paid  </b> <input type="checkbox" name='+p+' id='+p+' value="oui" onClick=activeMP("'+x+'")></center></td><td><b>Date Payement : </b><input type="date" name='+dateP+' id='+dateP+'></td> <td><span class="custom-dropdown custom-dropdown--white custom-dropdown--small" ><select id='+modeP+' name='+modeP+' onChange=afficheMP("'+x+'") class="custom-dropdown__select custom-dropdown__select--white"  disabled><option value="Cache">Cache</option> <option value="Cheque">Par chéque</option>   <option value="Virement">Virement</option><option value="Autre">Autre..</option></select></span></td></tr><tr><td id='+zoneMP+' colspan="2" style="text-align:right"></td><td><center><input type="file" name='+img+'  multiple></center></td></tr></table>');
    document.getElementById('nbr').value=x;
}

//remove zone
function deleteZ(){
    var x=document.getElementById("nbr").value;
	if(x>1){
        var Z="#tabZ"+x;
		$(Z).remove();
		x--;
		document.getElementById('nbr').value=x;
    }
}
///Actver le choix de mode de payment
function activeMP(i){
    var modeP="modeP"+i;
    var paid="paid"+i;
    if(document.getElementById(paid).checked == true){
        document.getElementById(modeP).disabled=false;
    }
    else{
        document.getElementById(modeP).disabled=true;
    }
}
///Affichage des zone du a un payment par chéque ou par virement
function afficheMP(i){
    var ref="ref"+i;
	//var NB="NB"+i;
	var NC="NC"+i;
	var NCid="#NC"+i;
	var modeP="modeP"+i;
	var zoneMP="#zoneMP"+i;
	var liste = document.getElementById(modeP);
	val = liste.options[liste.selectedIndex].value;
    if(val == "Autre"){
	    $(zoneMP).html('<input type="text"  id='+ref+' name='+ref+' size="40" placeholder="Mode de payment" > ');
	}else if(val != "Cache"){
	    $(zoneMP).html('<input type="text"  id='+ref+' name='+ref+' size="25" placeholder="Réference" > <select id='+NC+'  name='+NC+' ></select>');
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
</script>

</head>

<body onLoad="afficheCat();" onKeyDown="desactiveEnter()">



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
elseif($role=="FIN"){
include('../menu/menuFinance.php');
}elseif($role=="FIN2"){
include('../menu/menuFin2.php');
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<br>


<p class="there">Re-create supplier invoice</p>
<br>
<hr>
<form method="POST"  id="form1" name="form1" action="../php/supplier_invoice2.php" enctype="multipart/form-data">

<TABLE >

		<TR>
			<TH>Invoice type: </TH>
			<TD >
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
            <select name="typeI" id="typeI" onChange="affichelisteF(),affichelisteF2(),clearZone();" style="width:150px" class="custom-dropdown__select custom-dropdown__select--white" >
             <option value="s">---Selectionnez</option>
             <option value="Purchase">Purchase</option>
			  <option value="Service">Service</option>
			  <option value="Expense">Expense</option>
			   <option value="Credit">Credit note</option>
			   <option value="M">Multiple service</option>
            </select>
            </span>
			</TD>

			<TD id="TDsupplier">
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
            <select name="supplier" id="supplier"  style="width:220px" class="custom-dropdown__select custom-dropdown__select--white" onChange="clearZone();">
               <option value="s">---Suppliers</option>


            </select>
            </span>

			</td>
			<td style="text-align:right">
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
            <select name="catI" id="catI"  style="width:200px" class="custom-dropdown__select custom-dropdown__select--white" onFocus="afficheCat();">



            </select>
            </span>
			</td>
			<td>
			<input type="button" onclick="pop_up('../pages/pop_ajout_category.php');" value="+" >

           </td>

			<td><input type="text" name="invoice" size="15" id="invoice" placeholder="Invoice N°" onBlur="verif_invoice();"></td>
			<td><input type="button" onclick="affiche_reception();" value=">> " id="submitbutton"></td>



		</TR>
  </table>




<div id="arts" style="text-align:center">
</div>


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
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Facture ajouté avec succès \');</SCRIPT>';
	 //header('Location: ../pages/ajout_fact.php');
	 } else if ($status=="fail")
	 {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Fail !! veuillez réessayer SVP \');</SCRIPT>';}
}
?>
