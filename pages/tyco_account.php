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
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>
<title>
Tyco account
</title>
<SCRIPT>

function mySearch() {
var searchTerm = $(".search").val();
searchTerm=searchTerm.toUpperCase();
var listItem = $('.results tbody').children('tr');
var jobCount = $('.results tbody').children('tr').length;

 for (var iter = 1; iter <= jobCount; iter++) {

 var nIter1="#"+iter;
 var val=$(nIter1).html();
 val=val.toUpperCase();
 if (val.indexOf(searchTerm) >= 0){
 $(nIter1).attr('visible','true');
 }else{
 $(nIter1).attr('visible','false');
  }
 }
}

function excelAccount(){
	document.form1.action="../php/excel_tyco_account.php";
    document.form1.submit();
}
//
function unpaid_sales(N,L){
 var client = document.getElementById("client").value;
$.ajax({
        type: 'POST',
        data: 'lastM='+L+'&nextM='+N+'&client='+client,
        url: '../php/liste_unpaid_sales.php',
        success: function(data) {
         bootbox.alert (data);
       }});
}
//
function unpaid_credit(N,L){
 var client = document.getElementById("client").value;
$.ajax({
        type: 'POST',
        data: 'lastM='+L+'&nextM='+N+'&client='+client,
        url: '../php/liste_credit.php',
        success: function(data) {
         bootbox.alert (data);
       }});
}
//
function sales(N,L){
 var client = document.getElementById("client").value;
$.ajax({
        type: 'POST',
        data: 'lastM='+L+'&nextM='+N+'&client='+client,
        url: '../php/liste_sales.php',
        success: function(data) {

		bootbox.alert (data);
       }});
}
//
function purchases(N,L){
 var client = document.getElementById("client").value;
$.ajax({
        type: 'POST',
        data: 'lastM='+L+'&nextM='+N+'&client='+client,
        url: '../php/liste_purchases.php',
        success: function(data) {

		bootbox.alert (data);
       }});
}

//
function unpaid_purchases(N,L){
 var client = document.getElementById("client").value;
$.ajax({

        type: 'POST',
        data: 'lastM='+L+'&nextM='+N+'&client='+client,
        url: '../php/liste_unpaid_purchases.php',
        success: function(data) {

		bootbox.alert (data);
       }});
}
//
function liste_unpaid(){
 var client = document.getElementById("client").value;
$.ajax({
        type: 'POST',
        data: 'client='+client,
        url: '../php/liste_unpaid.php',
        success: function(data) {

		bootbox.alert (data);
       }});
}

function afficheAccount(){
var week = document.getElementById("week").value;
var Z = document.getElementById("Z").value;
var client = document.getElementById("client").value;
if(client=="S"){
 bootbox.alert("Selectionnez un client SVP !! ");
}else{
 $.ajax({
        type: 'POST',
        data: 'week='+week+'&Z='+Z+'&client='+client,
        url: '../php/tyco_account.php',
        success: function(data) {
        $('#OFD').html(data);
		//alert ("aaaa3");
       }});
//alert(week)	;
}

}
</SCRIPT>
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
elseif($role=="DIR"){
include('../menu/menuDirecteur.php');
}elseif($role=="FIN"){
include('../menu/menuFinance.php');
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Tyco account</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>


<form  id="form1" name="form1" method="POST">
<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
         Tyco account
 </div>
 <div class="panel-body" >
 <form role="form" method="post" name="form1" id="form1">

  <div class="row">
    <?php
	include('../connexion/connexionDB.php');

	$req1= mysql_query("SELECT max(dateP) FROM payment_client where (client='1004' or client='1003' or client='1002')");
	$dernier_pay=mysql_result($req1,0);
	$req11= mysql_query("SELECT solde FROM payment_client where (client='1004' or client='1003' or client='1002') and (dateP='$dernier_pay')");
	$total_pay=mysql_result($req11,0);

	$req4= mysql_query("SELECT reste FROM payment_tyco where dateP='$dernier_pay'");
    $prevision=@mysql_result($req4,0);


	if($total_pay>=0){
	$val=0;
	}else{
	$val=abs($total_pay);
	}
	$dernier_pay2 = strtotime($dernier_pay);
    $dernier_pay2= date("d- M -Y",$dernier_pay2);
	$total_pay2 = number_format($total_pay, 2, ',', ' ');
	$prevision2 = number_format($prevision, 2, ',', ' ');

	?>


    <div class="col-lg-9">

	<?php echo '<h4><b> Last payment: '.$dernier_pay2.'</b> </h4>
	<h4><b>Expected : '.$prevision2.' Euro </b>
	<h4><b>Received : '.$total_pay2.' Euro </b></h4>' ; ?>
	<br>
	</div>
		  	<div class="col-lg-1 pull-right">

										<img src="../image/excel.png" onclick="excelAccount();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p>

										</div>

										<div class="col-lg-1 pull-right">
										<img src="../image/unpaid_invoice.png" onclick="liste_unpaid();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p>
										<?php

										$nbr1=0;
										$nbr2=0;
										$dateJ=date("Y-m-d");
										$dateJ=strtotime($dateJ."-15 days");
										$dateJ=date('Y-m-d',$dateJ);
										$req1=@mysql_query("SELECT * FROM fact1 where (client='1004' or client='1003' or client='1002') and date_pay <='$dateJ' and statut='unpaid'");
										/*$req2=mysql_query("SELECT * FROM supplier_invoice where supplier='TYCO ELECTRONIC LOGI' and dateP <= '$dateJ' and status='unpaid' and typeI='Purchase'");*/
										$nbr1=mysql_num_rows($req1);
										//$nbr2=mysql_num_rows($req2);
										$nbr=$nbr1+$nbr2;
										if($nbr>0){
										echo '<div id="Xnote2" onClick="liste_unpaid();">'.$nbr.'</div>';
										}
										?>

										</div>
          <div class="col-lg-6">
           <div class="form-group ">
                                <label> Client: </label>
                                <div class="form-group form-inline">
                                <select class="form-control " id="client" name="client" required>
								    <?php
									$q1 = mysql_query("SELECT name_client,nomClient FROM client1");
									echo '<option value="S">Selectionnez...</option>';
									while($data1=mysql_fetch_array($q1)) {
									    echo '<option value="'.$data1["name_client"].'">'.$data1["nomClient"].'</option>';
         }
									?>
       </select>
         </div></div>
										<div class="form-group">
                   <label>Display payments up to ...</label>                         <!-- <label>Display payments up to :</label>-->
											 <div class="form-inline">
											 <input class="form-control" id="week" name="week" type="date"  >

											<input class="form-control" id="Z" name="Z" value="<?php echo $val ?>">
           <button type="button" class="btn btn-primary" onclick="afficheAccount();">>> </button>

                                             </div>


										</div>
										</div>






<div id="OFD" class="col-lg-12"></div>
	</form>
 </div>

</div>
</div>
</div>

	</div>
	<?php mysql_close();?>
	 </form>
    </div>

                    </div>
                    </div>
                    </div>
</body>

</html>
