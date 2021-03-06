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

<title>Payment client</title>
<script>
function afficheFacture(){
    var numF = document.getElementById("numF").value;
    var typeF = document.getElementById("typeF").value;
	$.ajax({
		url: '../php/affiche_paymentF.php',
		type: 'POST',
		data: "numF="+numF+"&typeF="+typeF,
		success:function(data){
			$('#divFP').html(data);

		}});


}


function ajoutPay(){
    var refP = document.getElementById("refP").value;
    var dateP = document.getElementById("dateP").value;
    var client = document.getElementById("client").value;
    var compte = document.getElementById("compte").value;
    if(dateP==""){
        bootbox.alert("Donnez la date du payment  SVP !!");
    }else if(client=="S"){
	    bootbox.alert("Sélectionnez un client SVP !!");
    }else if(compte=="S"){
	    bootbox.alert("Sélectionnez un compte bancaire SVP !!");
    }else{
	$.ajax({
		url: '../php/ajout_paymentC.php',
		type: 'POST',
		data: "refP="+refP+"&dateP="+dateP+"&client="+client+"&compte="+compte,
		success:function(data){

			$('#divP').html(data);
            document.getElementById("divF").style.visibility="visible";
		}});
    }
}

function ajoutFacture(){
    var numF = document.getElementById("numF").value;
    var typeF = document.getElementById("typeF").value;
    var refP = document.getElementById("refP").value;
    var dateP = document.getElementById("dateP").value;
    if(dateP==""){
        bootbox.alert("Donnez la date du payment  SVP !!");
    }else{
	$.ajax({
		url: '../php/ajout_paymentF.php',
		type: 'POST',
		data: "numF="+numF+"&typeF="+typeF+"&refP="+refP+"&dateP="+dateP,
		success:function(data){
			ajoutPay();
			$('#divFP').empty();
		}});
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
}else if($role=="FIN"){
    include('../menu/menuFinance.php');
}else{
	header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<div class="container" >
<div id="page-wrapper">
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Payment client </h1>
    </div>
</div>
<form role="form" method="post" name="form1" id="form1">
    <div class="row">
        <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-body well">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label> Réference payment : <label>
                                <input class="form-control" id="refP" name="refP" >
                            </div>
							<div class="form-group">
                                <label> Date payment : <label>
                                <input class="form-control" type="date" id="dateP" name="dateP"  >
                            </div>
							<div class="form-group">
                                <label> Client: <label>
                                <select class="form-control" id="client" name="client">
								    <?php
									$q1 = mysql_query("SELECT name_client,nomClient FROM client1");
									echo '<option value="S">Selectionnez...</option>';
									while($data1=mysql_fetch_array($q1)) {
									    echo '<option value="'.$data1["name_client"].'">'.$data1["nomClient"].'</option>';
                                    }
									?>
                                </select>
                            </div>
							<div class="form-group form-inline">
                                <label> Compte : <label>
                                <select class="form-control" id="compte" name="compte">
								    <?php
									$q2 = mysql_query("SELECT * FROM compte_banque");
									echo '<option value="S">Selectionnez...</option>';
									while($data2=mysql_fetch_array($q2)) {
									    echo '<option value="'.$data2["REFcompte"].'">'.$data2["REFcompte"].'</option>';
                                    }
									?>
                                </select>
								<button type="button" class="btn btn-primary" onClick="ajoutPay();">>> </button>
                            </div>
							<hr/>
						    <div class="form-group form-inline" id="divF" style="visibility:hidden">

                                <select class="form-control" id="typeF">
								    <option value="V">Vente</option>
								    <option value="A">Achat</option>
								    <option value="FE">Facture echantillant</option>
                    <option value="CN">Credit note</option>
                                </select>
								<input class="form-control" type="text" id="numF" placeholder="N° facture">
								<button type="button" class="btn btn-danger" onClick="afficheFacture();">>> </button>

                            </div>
							<div id="divFP"></div>

						</div>
						<div class="col-lg-6" id="divP">
						</div>

					</div>
				</div>
<?php
mysql_close();
?>







</div>
</div>
</div>
</div>
	</form>
</div>

</div>


</body>

</html>
