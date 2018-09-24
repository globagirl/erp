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
Update prices
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

 }else{
	$.ajax({
			url: '../php/listeFournisseur.php',
			type: 'POST',
			success:function(data){

				$('#valeur').html(data);

			}});
	//

 }
}

//
function afficheListe2(){
var val=$('input[name=cl_four]:checked', '#form2').val();
 if(val=="client"){
	  	$.ajax({
			url: '../php/listeClient.php',
			type: 'POST',
			success:function(data){

				$('#valeur2').html(data);

			}});

 }else{
	$.ajax({
			url: '../php/listeFournisseur.php',
			type: 'POST',
			success:function(data){

				$('#valeur2').html(data);

			}});
	//

 }
}


//
function verifItem(){

  var cl_four=$('input[name=cl_four]:checked', '#form1').val();
	 var liste1 = document.getElementById("valeur");
     var valeur = liste1.options[liste1.selectedIndex].value;
     var item=document.getElementById("item").value;
	  	$.ajax({
			url: '../php/verif_update_price.php',
			data: "val="+valeur+"&item="+item+"&cl_four="+cl_four,
			type: 'POST',
			success:function(data){
				if(data=="X"){
				  bootbox.alert("Check your ITEM ID PLZ !!!");
				}else{
      //$('#prixOld').html(data);
      //bootbox.alert(data);
      document.getElementById("prixOld").value=data;
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
var price = document.getElementById("price").value;
 if(valeur==""){
	  bootbox.alert("Donnez un fournisseur/Client  SVP !!");

 }else if(price==""){
 bootbox.alert("Donnez le nouveau prix  SVP !!");
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

elseif($role=="FIN"){
include('../menu/menuFinance.php');
}
else{
session_unset();
   session_destroy();
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<div class="container" >
<div id="page-wrapper">
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Update </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>



 
<div class="row">
 <div class="col-lg-6" >
 <div class="panel panel-default">
 <div class="panel-heading">
      Update prices
 </div>
 <div class="panel-body" >
    <div class="row">
    <form role="form" method="post" name="form1" id="form1" action="../php/update_price.php" enctype="multipart/form-data">
        <div class="col-lg-6">
			                           <div class="form-group">
                                          <label class="radio-inline">
                                                <input type="radio" name="cl_four" id="cl_four1" value="client" checked><b>Client</b>
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="cl_four" id="cl_four2" value="fournisseur"><b>Supplier</b>
                                            </label>
											</div>
											<div class="form-group">

                                            <select class="form-control" name="valeur" id="valeur" onFocus="afficheListe();">
                                                <option>--Selectionnez</option>
                                            </select>
                                            </div>
                                            <div class="form-group">
                                            <label>Item</label>
                                            <input class="form-control" id="item" name="item" onBlur="verifItem();">

                                            </div>
                                             <div class="form-group">
                                            <label>OLD price</label>
                                            <input class="form-control" id="prixOld" name="prixOld" READONLY >

                                            </div>
										    <div class="form-group">
                                            <label>New price</label>
                                            <input class="form-control" id="price" name="price">

                                            </div>
											<div class="form-group">

                                            <textarea id="note" name="note" class="form-control" placeholder="Pourquoi vous mettez a jour cet Article / Produit ??"></textarea>

                                            </div>
										    <button class="btn btn-primary" type="button" onClick="submitV();">Update >>
                                                </button>

					                         </div>
                        </div>
                        </form>
</div>
<div class="panel-footer">

</div>

</div>
</div>
<div class="col-lg-6" >
<div class="panel panel-default">
<div class="panel-heading">
     Auto-Update prices 
</div>
<div class="panel-body" >

 <div class="row">
 <form role="form" method="post" name="form1" id="form2" action="../php/update_price_auto.php" enctype="multipart/form-data">
        <div class="col-lg-6">
                        <div class="form-group">
                            <label class="radio-inline">
                               <input type="radio" name="cl_four" value="client" checked><b>Client</b>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="cl_four" value="fournisseur"><b>Supplier</b>
                            </label>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="valeur" id="valeur2" onFocus="afficheListe2();">
                                <option>--Selectionnez</option>
                            </select>
                        </div>
                        <div class="form-group">
                        <textarea  name="note" class="form-control" placeholder="Pourquoi vous mettez a jour cet Article / Produit ??"></textarea>
                        </div>
                        <div class="form-group">
                        <input type= "file" name="fileP" id="fileP" class="form-control"/>
                        </div>
                        <button class="btn btn-primary" type="submit" >Update >>
                        </button>

               </div>
 </div>
 </form>
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
