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
    <script src="../jquery/jqueryDataTable.min.js"></script>
    <script type='text/javascript' src='../jquery/menu_jquery.js'></script>
    <link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
    <link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
    <script src="../bootstrap/js/bootbox.min.js"></script>
    <title>PO Consult</title>
    <script>
        function updateZone(){
            var val = document.getElementById("recherche").value;
            if(val == "date_exped"){
                $('#zone').html('<input type="date" class="form-control" name="valeur" id="valeur"> ');
            }else if(val == "client"){
                $('#zone').html('<select name="valeur" id="valeur" class="form-control"> <option value="s">---Select---</option> </select> ');
                $.ajax({
                    type: 'POST',
                    url: '../php/listeClient.php',
                    success: function(data) {
                        $('#valeur').html(data);
                    }
                });
            }else{
                $('#zone').html('<input type="text" class="form-control" name="valeur" id="valeur" placeholder="Search "> ');
            }
        }
        //
        function affichePO(){
            $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
            var val = document.getElementById("valeur").value;
            var recherche = document.getElementById("recherche").value;
            var dateE1 = document.getElementById("dateE1").value;
            var dateE2 = document.getElementById("dateE2").value;
            $.ajax({
                type: 'POST',
                data: 'valeur='+val+'&recherche='+recherche+'&dateE1='+dateE1+'&dateE2='+dateE2,
                url: '../php/consult_commande.php',
                success: function(data) {
                    $('#tbody2').html(data);
                }
            });
        }
        //
        function excelCommande(){
            document.form1.action="../php/excel_commande.php";
            document.form1.submit();
        }
        //affiche commande info
        function afficheInfoPO(PO,S){
            $.ajax({
                type: 'POST',
                data:'PO='+PO+'&statut='+S,
                url: '../php/consult_commande_info.php',
                success: function(data) {
                    bootbox.alert(data);
                }
            });
        }
    </script>
</head>
<body>
<div id="entete">
    <div id="logo"></div>
    <div id="boton"><?php include('../include/logOutIMG.php');?></div>
</div>
<div id="main">
    <div id="menu">
        <?php
        if($role=="ADM"){
            include('../menu/menuAdmin.php');
        }else if($role=="COM"){
            include('../menu/menuCommercial.php');
        }else if($role=="LOG"){
            include('../menu/menuLogistique.php');
        }else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <div class="container">
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">Customer Order</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"> Orders List </div>
                            <div class="panel-body">
                                <form  id="form1" name="form1" method="POST">
                                    <div class="row">
                                        <div class="pull-left col-md-8">

                                            <div class="form-group form-inline">
                                                <select class="form-control" name="recherche" id="recherche" onChange="updateZone();">
                                                    <!--<option value="A">ALL</option>-->
                                                    <option value="PO"> PO</option>
                                                    <option value="produit"> Product</option>
                                                    <option value="client"> Customer</option>
                                                </select>
                                                <span id="zone"><input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Search "></span>
                                            </div>
                                            <div class="form-group">
                                                <label>Margin by shipment date</label>
                                                <div class="form-group form-inline">
                                                    <input type="date" class="form-control" name="dateE1" id="dateE1" >
                                                    <input type="date" class="form-control" name="dateE2" id="dateE2" >
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input type="button" onClick="affichePO();" class="btn btn-danger" Value="Consult >>">
                                            </div>
                                        </div>
                                        <div class="pull-right col-md-1">
                                            <img src="../image/excel.png" onclick="excelCommande();" alt="Excel" style="cursor:pointer;" width="60" height="50"  />
                                        </div>
                                        <br><br><br><br>
                                        <div class="table-responsive col-md-12" id="divRel">
                                            <table  class="table table-fixed table-bordered results" id="table3">
                                                <thead style="width:100%">
                                                <tr>
                                                    <th style="width:14.8%;height:60px" class="degraD">PO</th>
                                                    <th style="width:14.8%;height:60px" class="degraD">Product</th>
                                                    <th style="width:9.8%;height:60px" class="degraD">QTY</th>
                                                    <th style="width:11.9%;height:60px" class="degraD">Unit Price</th>
                                                    <th style="width:11.9%;height:60px" class="degraD">Total</th>
                                                    <th style="width:11.9%;height:60px" class="degraD">Shipment Date </th>
                                                    <th style="width:11.9%;height:60px" class="degraD">Customer</th>
                                                    <th style="width:9.9%;height:60px" class="degraD">Status</th>
                                                </tr>
                                                </thead>
                                                <tbody id="tbody2" style="width:100%">
                                                <?php
                                                include('../include/functions/consult_commande_functions.php');
                                                $req= mysql_query("SELECT * FROM commande_items  order by dateExp desc LIMIT 200");
                                                while($a=mysql_fetch_array($req)){
                                                    affiche_ligne($a);
                                                }
                                                mysql_close();
                                                ?>
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
        </div>
    </div>
</div>
</body>
</html>