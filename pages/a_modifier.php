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
    <title> Tyco Account </title>
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
            $.ajax({
                type: 'POST',
                data: 'lastM='+L+'&nextM='+N,
                url: '../php/liste_unpaid_sales.php',
                success: function(data) {

                    bootbox.alert (data);
                }});
        }
        //
        function sales(N,L){
            $.ajax({
                type: 'POST',
                data: 'lastM='+L+'&nextM='+N,
                url: '../php/liste_sales.php',
                success: function(data) {

                    bootbox.alert (data);
                }});
        }
        //
        function purchases(N,L){
            $.ajax({
                type: 'POST',
                data: 'lastM='+L+'&nextM='+N,
                url: '../php/liste_purchases.php',
                success: function(data) {

                    bootbox.alert (data);
                }});
        }

        //
        function unpaid_purchases(N,L){
            $.ajax({
                type: 'POST',
                data: 'lastM='+L+'&nextM='+N,
                url: '../php/liste_unpaid_purchases.php',
                success: function(data) {

                    bootbox.alert (data);
                }});
        }
        //
        function liste_unpaid(){
            $.ajax({
                type: 'POST',

                url: '../php/liste_unpaid.php',
                success: function(data) {

                    bootbox.alert (data);
                }
            });
        }

        function afficheAccount(){

            var week = document.getElementById("week").value;
            var Z = document.getElementById("Z").value;

            $.ajax({
                type: 'POST',
                data: 'week='+week+'&Z='+Z,
                url: '../php/tyco_account.php',
                success: function(data) {
                    $('#OFD').html(data);
                    //alert ("");
                }
            });
        }
    </SCRIPT>
</head>

<body>
<div id="entete">
    <div id="logo"> </div>
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
                    <h1 class="page-header">TYCO Account</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <form  id="form1" name="form1" method="POST">
                <div class="row">
                    <div class="col-lg-12" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Tyco Account
                            </div>
                            <div class="panel-body" >
                                <form role="form" method="post" name="form1" id="form1">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <!-- <label>Display payments up to :</label>-->
                                                <div class="form-inline">
                                                    <input class="form-control" id="dateD" name="dateD" type="date"  >
                                                    <button type="button" class="btn btn-danger" onclick="afficheAccount()"> >> </button>
                                                    <p class="help-block">Display payments up to ...</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="OFD" class="col-lg-12">
                                            <table class="table table-fixed table-bordered results" id="table3">
                                                <thead style="width:100%">
                                                <tr>
                                                    <th style="width:29.6%;height:60px" class="degraD2" >Client / local</th>
                                                    <th style="width:24.6%;height:60px" class="degraD2">Receivable Accounts  </th>
                                                    <th style="width:24.6%;height:60px" class="degraD2">Payable Accounts </th>
                                                    <th style="width:19.6%;height:60px" class="degraD2">Currency</th>
                                                </tr>
                                                </thead>
                                                <tbody id="tbody2" style="width:100%">
                                                <tr>
                                                    <td style="width:30%;height:60px"><b>CommScope</b></td>
                                                    <td style="width:25%;height:60px">00.0 </th>
                                                    <td style="width:25%;height:60px">00.0</td>
                                                    <td style="width:20%;height:60px">£</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:30%;height:60px"><b>TYCO</b></td>
                                                    <td style="width:25%;height:60px">00.0 </td>
                                                    <td style="width:25%;height:60px">00.0</td>
                                                    <td style="width:20%;height:60px">£</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:30%;height:60px"><b>C.Scope</b></td>
                                                    <td style="width:25%;height:60px">00.0 </td>
                                                    <td style="width:25%;height:60px" >00.0</td>
                                                    <td style="width:20%;height:60px" >GPB</td>
                                                </tr>
                                                <tr>
                                                    <td style="width:30%;height:60px"><b>Local</b></td>
                                                    <td style="width:25%;height:60px">00.0 </td>
                                                    <td style="width:25%;height:60px" >00.0</td>
                                                    <td style="width:20%;height:60px">TND</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </form>
    </div>
</div>
</body>
</html>