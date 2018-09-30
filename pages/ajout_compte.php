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
        Bank Account
    </title>
    <script>
        function afficheInvoice(){

            var valeur = document.getElementById("fact").value;
            if(valeur==""){
                alert("Donnez le numéro de la facture SVP !!");
            }
            else{
                if($("#chek").prop('checked') == true){

                    $.ajax({
                        url: '../php/affiche_credit_starz.php',
                        type: 'POST',
                        data: "CN="+valeur,
                        success:function(data){
                            if(data==1){
                                bootbox.alert("Vérifier le numéro du credit note SVP !!");
                            }else if(data==0){
                                bootbox.alert("Credit note  payé !!");
                            }else{
                                $('#OFD').html(data);
                            }
                        }});
                }else{
                    $.ajax({
                        url: '../php/affiche_invoice_client.php',
                        type: 'POST',
                        data: "fact="+valeur,
                        success:function(data){
                            if(data==1){
                                bootbox.alert("Vérifier le numéro de la facture SVP !!");
                            }else if(data==0){
                                bootbox.alert("Facture payé !!");
                            }else{
                                $('#OFD').html(data);
                            }
                        }
                    });
                }
            }
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
            var valeur = document.getElementById("fact").value;
            var dateP = document.getElementById("dateP").value;
            if(valeur==""){
                bootbox.alert("Donnez le numéro de la facture SVP !!");

            }else if(dateP==""){
                bootbox.alert("Donnez la date de payment SVP !!");
            }else{
                document.form1.action="../php/client_payment.php";
                document.form1.submit();
            }
        }
        //
        function submitCN(){
            var valeur = document.getElementById("fact").value;
            var dateP = document.getElementById("dateP").value;
            if(valeur==""){
                bootbox.alert("Donnez le numéro de la facture SVP !!");

            }else if(dateP==""){
                bootbox.alert("Donnez la date de payment SVP !!");
            }else{
                document.form1.action="../php/client_paymentCN.php";
                document.form1.submit();
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
        }else if($role=="GRH"){
            include('../menu/menuGRH.php');
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
                        <h1 class="page-header">Bank Account </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <form role="form" method="post" name="form1" id="form1" action="../php/ajout_compte.php">
                    <div class="row">
                        <div class="col-lg-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading"> Add new account </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label> Account Reference : <label>
                                                        <input class="form-control" id="refC" name="refC" placeholder="EX:STARZ.BIAT" >
                                            </div>
                                            <div class="form-group">
                                                <label> Account N° : <label>
                                                        <input class="form-control" id="numC" name="numC" placeholder="EX:2589635861400" >
                                            </div>
                                            <div class="form-group">
                                                <label> Bank : <label>
                                                    <select class="form-control" id="banque" name="banque">
                                                        <option value="BIAT">BIAT</option>
                                                        <option value="Attijari bank">Attijari bank</option>
                                                        <option value="BNA">BNA</option>
                                                    </select>
                                            </div>
                                            <div class="form-group">
                                                <label> Currency : <label>
                                                    <select class="form-control" id="devise" name="devise">
                                                        <option value="TND">TND</option>
                                                        <option value="EUR">EUR </option>
                                                        <option value="DC">DC </option>
                                                        <option value="USD">USD </option>
                                                    </select>
                                            </div>
                                            <div class="form-group">
                                                <label> Initial Balance : <label>
                                                        <input class="form-control" id="solde" name="solde" placeholder="EX:3958.256" >
                                            </div>
                                            <div class="form-group">
                                                <label> State : <label>
                                                        <select class="form-control" id="etat" name="etat">
                                                            <option value="O">Open</option>
                                                            <option value="F">Closed </option>
                                                        </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Create account </button>
                                        </div>
                                    </div>
                                    <div id="OFD"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</body>
</html>