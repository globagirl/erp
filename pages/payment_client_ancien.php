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

<title>Payment client ancien</title>
<script>


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
		url: '../php/ajout_paymentC_ancien.php',
		type: 'POST',
		data: "refP="+refP+"&dateP="+dateP+"&client="+client+"&compte="+compte,
		success:function(data){	
           
			$('#divP').html(data);
           	
		}});
    }
}

function valider_pay(){	
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
        <h1 class="page-header">Payment client ancien </h1>
    </div>                
</div>
<form role="form" method="POST" name="form1" id="form1" action="../php/payment_client_ancien.php">
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
									$q1 = mysql_query("SELECT * FROM client1");									
									echo '<option value="S">Selectionnez...</option>';
									while($data1=mysql_fetch_array($q1)) {
									    echo '<option value="'.$data1["name_client"].'">'.$data1["name_client"].'</option>'; 
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
						  
							<div id="divFP"></div>
                          
						</div> 
						<div class="col-lg-6" id="divP">
						</div>
						
					</div>
				</div>








</div>
</div>


</div>
</form>
</div>
</div>
</div>
</div>


</body>

</html>