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
	<link href="../tablecloth/table.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/style.css"/>
	<script src="../jquery/jquery-latest.min.js"></script>
	<script src="../jquery/jqueryDataTable.min.js"></script>
	<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
	<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
	<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
	<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
	<script src="../bootstrap/js/bootbox.min.js"></script>
	<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<title>Consult invoices</title>
<script>
///////Auto Complete //////
function autoComplete(){
   var min_length =2;
	var keyword = $('#valeur').val();
	if (keyword.length >= min_length) {
	var zoneC="#valeur";
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
    ch=ch.replace("|"," ");
	$(z).val(ch);

}
///
function afficheInvoice(){
$('#div1').html('<center><br><br> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center>');
var liste2 = document.getElementById("recherche");
var R = liste2.options[liste2.selectedIndex].value;
var listeP = document.getElementById("modeP");
var modeP= listeP.options[listeP.selectedIndex].value;
//if (R =="IDinvoice" || R =="a" || R =="un_expense"|| R =="supplier" ){
    var val = document.getElementById("valeur").value;
//}else{
    //var liste1 = document.getElementById("valeur");
  //  var val = liste1.options[liste1.selectedIndex].value;
//}
var liste3 = document.getElementById("margeD");
var M = liste3.options[liste3.selectedIndex].value;
var d1 = document.getElementById("date1").value;
var d2 = document.getElementById("date2").value;
var refP = document.getElementById("refP").value;
var stat="A";
if($('#s1').is(':checked')){
	stat="A";
}else if($('#s2').is(':checked')){
	stat="paid";
}else if($('#s3').is(':checked')){
	stat="unpaid";
}

$.ajax({
        type: 'POST',
        data: 'recherche='+R +'&valeur='+val +'&margeD='+M +'&date1='+d1 +'&date2='+d2+'&statut='+stat+'&modeP='+modeP+'&refP='+refP,
        url: '../php/consult_invoice2.php',
        success: function(data) {
        $('#div1').html(data);
       }});

}
//
function afficheInvoiceArticle(){
$('#div1').html('<center><br><br> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center>');
var liste2 = document.getElementById("recherche");
var R = liste2.options[liste2.selectedIndex].value;
var listeP = document.getElementById("modeP");
var modeP= listeP.options[listeP.selectedIndex].value;
//if (R =="IDinvoice" || R =="a" || R =="un_expense"|| R =="supplier" ){
    var val = document.getElementById("valeur").value;
//}else{
    //var liste1 = document.getElementById("valeur");
  //  var val = liste1.options[liste1.selectedIndex].value;
//}
var liste3 = document.getElementById("margeD");
var M = liste3.options[liste3.selectedIndex].value;
var d1 = document.getElementById("date1").value;
var d2 = document.getElementById("date2").value;
var refP = document.getElementById("refP").value;
var stat="A";
if($('#s1').is(':checked')){
	stat="A";
}else if($('#s2').is(':checked')){
	stat="paid";
}else if($('#s3').is(':checked')){
	stat="unpaid";
}

$.ajax({
        type: 'POST',
        data: 'recherche='+R +'&valeur='+val +'&margeD='+M +'&date1='+d1 +'&date2='+d2+'&statut='+stat+'&modeP='+modeP+'&refP='+refP,
        url: '../php/consult_invoice_article.php',
        success: function(data) {
        $('#div1').html(data);
       }});

}
//Excel
function excelInvoiceArticle(){

      document.form1.action="../php/excel_invoice_article.php";
        document.form1.submit();

}
///Affichage zone
function afficheZone(){

 var liste = document.getElementById('recherche');
  var recherche = liste.options[liste.selectedIndex].value;
  if(recherche=="IDinvoice"){
  $('#zone').html('<input type="text" id="valeur" class="form-control" name="valeur"> ');
  }else if (recherche=="supplier"){

	    $('#zone').html('<input type="text" class="form-control" id="valeur" name="valeur" onKeyup="autoComplete();" size="60" onFocus="autoComplete()" onBlur="hideListe();">  <div class="divAuto2"><ul id="listeF2" ></ul></div>');


}else if (recherche=="catI"){

	    $('#zone').html('<select name="valeur" id="valeur"  class="form-control"><option value="s">---Selectionnez</option> </select> ');
        $.ajax({
        type: 'POST',

        url: '../php/listeCategory.php',
        success: function(data) {
        $('#valeur').html(data);
       }});

}else if (recherche=="currency"){

	    $('#zone').html('<select name="valeur" id="valeur"  class="form-control"><option value="TND">TND</option><option value="EUR">EUR</option><option value="USD">USD</option></select>');


}else if (recherche=="typeI"){

	    $('#zone').html('<select name="valeur" id="valeur"  class="form-control"><option value="s">---Selectionnez</option><option value="Purchase">Purchase</option><option value="Service">Service</option><option value="Expense">Expense</option><option value="Credit">Credit note</option></select>');


}else{
  $('#zone').html('<input type="text" id="valeur" class="form-control" name="valeur"> ');
  }

}
//
function changePay(){

  var liste = document.getElementById('modeP');
  var recherche = liste.options[liste.selectedIndex].value;
 if (recherche=="compte"){

	    $('#compteZone').html('<select name="refP" id="refP"  class="form-control"></select> ');
        $.ajax({
        type: 'POST',
        url: '../php/listeCompteNum.php',
        success: function(data) {
        $('#refP').html(data);
       }});

}else{
    $('#compteZone').html('<input type="text" name="refP" id="refP" size="30" class="form-control" placeholder="Réference / Autre mode pay">');
}
}
///afficher les invoice items
function consult_items(i){

$.ajax({
        type: 'POST',
        data:'invoice='+i,
        url: '../php/consult_invoice_items2.php',
        success: function(data) {
        bootbox.alert(data);
       }});

}
///
function consult_info(i){
$.ajax({
        type: 'POST',
        data:'invoice='+i,
        url: '../php/consult_invoice_info.php',
        success: function(data) {
        bootbox.alert(data);
       }});

}
//
function ajout_fichier(i){
$.ajax({
        type: 'POST',
        data:'invoice='+i,
        url: '../php/ajout_invoice_file.php',
        success: function(data) {
        bootbox.alert(data);
       }});

}
//
function delete_invoice_file(i,nameF){
 //alert(nameF);
 $.ajax({
        type: 'POST',
        data:'nameF='+nameF+'&IDinvoice='+i,
        url: '../php/delete_invoice_file.php',
        success: function(data) {
         bootbox.hideAll();
         ajout_fichier(i);
       }});
}
//
function update_facture2(){
var fact1 = document.getElementById("numFact1").value;
var fact = document.getElementById("numFact").value;
var four = document.getElementById("four").value;
var dateP = document.getElementById("dateP").value;
var dateF = document.getElementById("dateF").value;
var cat = document.getElementById("cat").value;
var typeI = document.getElementById("typeI").value;
var coursTND = document.getElementById("coursTND").value;
var devise = document.getElementById("devise").value;
$.ajax({
        type: 'POST',
        data:'fact1='+fact1+'&fact='+fact+'&four='+four+'&dateP='+dateP+'&dateF='+dateF+'&cat='+cat+'&typeI='+typeI+'&coursTND='+coursTND+'&devise='+devise,
        url: '../php/update_invoice2.php',
        success: function(data) {
        //bootbox.alert(data);
		if(data=="1"){
		  bootbox.alert("N° facture existe déja !! ");
		}else{
		  bootbox.hideAll();
		  afficheInvoice();
		}
       }});
}
//
function update_facture(i){
$.ajax({
        type: 'POST',
        data:'invoice='+i,
        url: '../pages/update_invoice.php',
        success: function(data) {
        bootbox.alert(data);
       }});

}
//
function update_facture_pay(i){
$.ajax({
        type: 'POST',
        data:'invoice='+i,
        url: '../pages/update_invoice_pay.php',
        success: function(data) {
        bootbox.alert(data);
       }});

}
//
function update_facture_pay2(idP,i){
var datePN="dateP"+i;
var modPN="modP"+i;
var refPN="refP"+i;
var comptePN="compteP"+i;
 var montantPN="montantP"+i;
var dateP = document.getElementById(datePN).value;
var modP = document.getElementById(modPN).value;
var refP = document.getElementById(refPN).value;
var compteP = document.getElementById(comptePN).value;
var montantP = document.getElementById(montantPN).value;

$.ajax({
        type: 'POST',
        data:'idP='+idP+'&dateP='+dateP+'&modP='+modP+'&refP='+refP+'&compteP='+compteP+'&montantP='+montantP,
        url: '../php/update_invoice_pay.php',
        success: function(data) {
        //bootbox.alert(data);

		  bootbox.hideAll();
		  afficheInvoice();

       }});
}
//Fichier excel
function excelInvoices(){
	document.form1.action="../php/excel_invoice.php";
    document.form1.submit();
}
//Print Invoice
function printInvoices(){
	document.form1.action="../tcpdf/print_invoices.php";
    document.form1.submit();
}
function printImg(){
	document.form1.action="../tcpdf/print_img_inv.php";
    document.form1.submit();
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
elseif($role=="FIN"){
include('../menu/menuFinance.php');
}elseif($role=="FIN2"){
include('../menu/menuFin2.php');
}elseif($role=="COM"){
include('../menu/menuCommercial.php');
}elseif($role=="DIR"){
include('../menu/menuDirecteur.php');
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<div class="container" >
<div id="page-wrapper">
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Factures </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>

<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
       Liste des factures
 </div>
 <div class="panel-body" >
     <form role="form" method="post" name="form1" id="form1">
	   <div class="well">
	   <div class="row">

<div class="col-lg-8">
    <div class="form-group">
		<div class="form-inline">
		    <select name="recherche" id="recherche" onChange="afficheZone();" class="form-control" >
			     <option value="a">ALL</option>
        <option value="IDinvoice"> Invoice N°</option>
        <option value="typeI"> Invoice Type</option>
        <option value="currency"> Devise</option>
        <option value="supplier"> Supplier</option>
        <option value="catI">Category </option>
        <option value="IDreception">Reception </option>
        <option value="IDordre">Ordre d'achat </option>
        <option value="IDitem">Article </option>
        <option value="un_expense"> Unbilled expense</option>
      </select>
			<span id="zone">
			<input type="text" name="valeur" id="valeur"  class="form-control" disabled>
			</span>
		</div>
	</div>
	<div class="form-group">
<label>Filtre par date:</label>
        <div class="form-inline">
        <select name="margeD" id="margeD" class="form-control">
			 <option value="dateP" selected>Payment date</option>
	         <option value="dateF">Invoice date</option>
	         <option value="dateE">Date entrée</option>
        </select>

        <input class="form-control" id="date1" name="date1" type="date">
		<input class="form-control" id="date2" name="date2" type="date">

		</div>
        </div>



        <div class="form-group">

        <label>Filtre par payment:</label>
		    <div class="form-inline">
       <select name="modeP" id="modeP"  class="form-control" onChange="changePay();">
			 <option value="A">Payment par</option>
			 <option value="Cheque">Cheque</option>
	         <option value="Virement">Virement</option>
			 <option value="Cache">Cache</option>
        <option value="compte">Compte</option>
        <option value="X"> Autre..</option>

   </select>


		   <span id="compteZone"><input type="text" name="refP" id="refP" size="30" class="form-control" placeholder="Réference / Autre mode pay"></span>

        </div>
        </div>
        <div class="form-group">
        <div class="radio-inline">
        <label>
        <input type="radio" name="statut" id="s1" value="A"checked> ALL
        </label>
        </div>
        <div class="radio-inline">
        <label>
        <input type="radio" name="statut" id="s2" value="paid"> Payé
        </label>
        </div>
		<div class="radio-inline">
        <label>
        <input type="radio" name="statut" id="s3" value="unpaid"> Non payé
        </label>
        </div>
        </div>


        <input type="button" class="btn btn-primary" value="Recherche >>"  onclick="afficheInvoice()">

      <input type="button" class="btn btn-danger" value="Consultation par article >>"  onclick="afficheInvoiceArticle()">
      <input type="button" class="btn btn-success" value="Excel par article >>"  onclick="excelInvoiceArticle()">

        </div>
<div class="col-lg-4">
  <p style="float:right"><img src="../image/print.png" onclick="printInvoices();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
<img src="../image/excel.png" onclick="excelInvoices();" alt="Excel" style="cursor:pointer;" width="60" height="50"  />
<img src="../image/print-fact.png" onclick="printImg();" alt="Excel" style="cursor:pointer;" width="60" height="50"  />
</p>
</div>
	</div>
	</div>





 <div id="div1">
 </div>

	</form>



</div>
</div>
</div>
</div>
</div>

</div>

<!--fin -->



</div>


</div>
</body>

</html>
