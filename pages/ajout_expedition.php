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
        Add Shipment
    </title>
    <script>
        function affichePO(){
            //Consultation des information du PO
            var valeur = document.getElementById("PO").value;
            $.ajax({
                type: 'POST',
                data : 'PO='+valeur,
                url: '../php/afficheEXPED.php',
                success: function(data) {
                    $('#div1').html(data);
                }});
        }
        function ajoutEXPED(OF,t){
            //Validation d'expédition
            $.ajax({
                type: 'POST',
                data : 'OF='+OF,
                url: '../php/ajoutEXPED.php',
                success: function(data) {
                    if(data=="OK"){
                        var tab= "#"+t;
                        $(tab).remove();
                    }else{
                        alert("Error while inserting, PLZ contact the IT Manager ");
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
        elseif($role=="CONS"){
            include('../menu/menuConsommable.php');
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
                        <h1 class="page-header">Shipment  </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-12" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Add Shipment
                            </div>
                            <div class="panel-body" >
                                <form role="form" method="post" name="form1" >
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group form-inline">
                                                <input class="form-control" id="PO" name="PO" placeholder="Customer PO " onKeyup="autoComplete();" onFocus="autoComplete()"  onBlur="hideListe();">
                                                <button type="button" class="btn btn-default" onclick="affichePO();">>> </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="div1"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>