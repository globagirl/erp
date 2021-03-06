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
        ADD new preventive
    </title>
    <SCRIPT>
        function afficheRevenu(){
            var d1 = document.getElementById("date1").value;
            var d2 = document.getElementById("date2").value;
            var liste = document.getElementById('recherche');
            var recherche = liste.options[liste.selectedIndex].value;
            if (recherche !="cat"){
                var val = document.getElementById("valeur").value;
            }else{
                var liste1 = document.getElementById("valeur");
                var val = liste1.options[liste1.selectedIndex].value;
            }
            if(document.getElementById('shipped').checked) {
                var R2="shipped";
            }else if(document.getElementById('shippedNot').checked) {
                var R2="shippedNot";
            }else{
                var R2="ALL";
            }
            $.ajax({
                type: 'POST',
                data: 'date1='+d1 +'&date2='+d2 +'&recherche='+recherche +'&R2='+R2+'&valeur='+val ,
                url: '../php/accounting_profit.php',
                success: function(data) {
                    $('#OFD').html(data);
                }});
        }
        /////
        function afficheZone(){
            var liste = document.getElementById('recherche');
            var recherche = liste.options[liste.selectedIndex].value;
            if(recherche !="cat"){
                if(recherche =="a"){
                    $('#zone').html('<input type="text" id="valeur" class="form-control" name="valeur" DISABLED> ');
                }else{
                    $('#zone').html('<input type="text" id="valeur" name="valeur" class="form-control"> ');
                }
            }else{

                $('#zone').html('<select name="valeur" id="valeur"  style="width:220px" class="form-control" ><option value="s">---Category</option> </select> ');
                $.ajax({
                    type: 'POST',
                    url: '../php/listeCatProduit.php',
                    success: function(data) {
                        $('#valeur').html(data);
                    }});
            }
        }
        //Fichier excel
        function excelProfit(){
            document.form1.action="../php/excel_accounting_profit.php";
            document.form1.submit();
        }
        //Print Invoice
        function printProfit(){
            document.form1.action="../tcpdf/print_accounting_profit.php";
            document.form1.submit();
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
        elseif($role=="FIN"){
            include('../menu/menuFinance.php');
        }elseif($role=="DIR"){
            include('../menu/menuDirecteur.php');
        }
        else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <div class="container col-md-12" >
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">Preventive</h1>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <?php
                include('../connexion/connexionDB.php');
                ?>
                <div class="row">
                    <div class="col-md-12" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Add new preventive
                            </div>
                            <div class="panel-body" >
                                <form role="form" method="post" name="form1" id="form1">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group col-md-10">
                                                <label>Material ID</label>
                                                <select name="recherche" id="recherche" onChange="afficheZone();" class="form-control">
                                                    <option value="a">Select...</option>
                                                    <option value="12">Every year</option>
                                                    <option value="6">Every 6 months</option>
                                                    <option value="3">Every 3 months</option>
                                                    <option value="1">Every month</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label>Preventive date</label>
                                                <input class="form-control" id="dateP" name="dateP" type="date"  >
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label>Operator </label>
                                                <select name="opr" id="opr"  class="form-control">
                                                </select>
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label>Result  </label>
                                                <br>
                                                <label class="radio-inline">
                                                    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>Radio 1
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Radio 2
                                                </label>
                                            </div>
                                            <div class="form-group col-md-10">
                                                <input type="button" class="btn btn-default blue" value="ADD >>"  onclick="afficheRevenu()">
                                            </div>
                                        </div>
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