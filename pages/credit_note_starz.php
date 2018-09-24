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
Credit note
</title>
<script>

function afficheListe(){

var val=$('input[name=cl_four]:checked', '#form1').val();
 if(val=="client"){
	  	$.ajax({
			url: '../php/listeClient.php',
			type: 'POST',
			success:function(data){

				$('#valeur').html(data);

			}});

 }
 else{

	$.ajax({
			url: '../php/listeFournisseur.php',
			type: 'POST',
			success:function(data){

				$('#valeur').html(data);

			}});
	//

 }
}


function verifFact(){

     var cl_four=$('input[name=cl_four]:checked', '#form1').val();
	 var liste1 = document.getElementById("valeur");
     var valeur = liste1.options[liste1.selectedIndex].value;
     var fact=document.getElementById("fact").value;
	  	$.ajax({
			url: '../php/verif_invoice.php',
			data: "val="+valeur+"&fact="+fact+"&cl_four="+cl_four,
			type: 'POST',
			success:function(data){

				if(data==0){

		        //$("#item").addClass("has-error");
				  bootbox.alert("Check your invoice number PLZ !!!");
				}
			}});

 }
//////////////
function desactiveEnter(){
 if (event.keyCode == 13) {
      event.keyCode = 0;
      window.event.returnValue = false;
 }
}
//
function submitV(){
var valeur = document.getElementById("valeur").value;
var amount = document.getElementById("amount").value;
 if(valeur==""){
	  bootbox.alert("Donnez un fournisseur/Client  SVP !!");

 }else if(amount==""){
 bootbox.alert("Donnez un montant SVP !!");
 }else{
 document.forms['form1'].submit();
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
<div class="container" >
<div id="page-wrapper">
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Credit note STARZ </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>


   <form role="form" method="post" name="form1" id="form1" action="../php/credit_note_starz.php">
<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
     ADD new credit note
 </div>
 <div class="panel-body" >
  <?php
  include('../connexion/connexionDB.php');
  $req=mysql_query("select count(idCN) FROM credit_note_starz");
  $nbr=mysql_result($req,0);
  $nbr=$nbr+1001;
  $id='CN'.$nbr;
  ?>
  <div class="row">
                                <div class="col-lg-5">
								         <div class="form-group">
										  <div class="form-group">
                                            <label>Credit note ID</label>
                                            <input class="form-control" id="CN" name="CN" value="<?php echo $id; ?>" READONLY>

                                            </div>
                                          <label class="radio-inline">
                                                <input type="radio" name="cl_four" id="cl_four1" value="V" checked><b>Client</b>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="cl_four" id="cl_four2" value="A"><b>Supplier</b>
                                            </label>
											</div>
											<div class="form-group">

                                            <select class="form-control" name="valeur" id="valeur" onFocus="afficheListe();">
                                                <option>--Selectionnez</option>
                                            </select>
                                            </div>
                                            <div class="form-group">
                                            <label>Original invoice N°</label>
                                            <input class="form-control" id="fact" name="fact" onBlur="verifFact();">

                                            </div>
										    <div class="form-group">
                                            <label>Amount</label>
											<div class="form-inline">
                                            <input class="form-control" id="amount" name="amount" >
                                            <select class="form-control" name="devise" id="devise" onFocus="afficheListe();">
                                                <option>Euro</option>
                                                <option>Dollar</option>
                                                <option>GBP</option>
                                            </select>

										    <button class="btn btn-default blue" type="button" onClick="submitV();">ADD >>
                                                </button>
                                            </div>
                                            </div>


								</div>
  </div>
</div>
<div class="panel-footer">

</div>

</div>
</div>
</div>
	</form>
</div>

</div>


</body>

</html>
