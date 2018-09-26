<?php
/**
 * Created by PhpStorm.
 * User: Khawla
 * Date: 26/09/2018
 * Time: 11:43
 */
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
        New Final Check
    </title>
    <script>
        ///// Verifier PO
        function verifierPO(){
            var val=document.getElementById("PO").value;
            var x= val.indexOf(" ");
            if( x > -1){
                alert("The order number must not contain a space");
                document.getElementById('PO').style.backgroundColor='pink';
                //v=0;
            }else{
                $.ajax({
                    url: '../php/verifChampsCommande2.php',
                    type: 'POST',
                    data: "PO="+val,
                    success:function(data){
                        if(data=="0"){
                            document.getElementById("POI1").value=val+"-1";
                            //v=0;
                        }else{
                            alert("This PO doesn't exists, please check your values !!");
                            document.getElementById('PO').style.backgroundColor='pink';
                            //v=1;
                        }
                    }
                });
            }
        }
        //verifier tt les champs
        function verifier() {
            var val = document.getElementById("PO").value;
            var val1 = document.getElementById("date").value;
            if(val==null){
                alert("PLZ Add PO !!");
                document.getElementById('PO').style.backgroundColor='pink';
            }else  if(val1==null){
                alert("PLZ Enter a date !!");
                document.getElementById('client').style.backgroundColor='pink';
                V=1;
            }
        }
        // auto complete po
        function autoComplete(c,l){
            var zoneC="#"+c;
            var zoneL="#"+l;
            var min_length =3;
            var keyword = $(zoneC).val();
            if (keyword.length >= min_length) {
                $.ajax({
                    url: '../php/auto_liste_po.php',
                    type: 'POST',
                    data: "val="+keyword+"&Z="+zoneC,
                    success:function(data){
                        $(zoneL).show();
                        $(zoneL).html(data);
                    }});
            }else {
                $(zoneL).hide();
            }
        }
        //
        function hideListe(l) {

            var zoneL="#"+l;
            $(zoneL).hide();
        }
    </script>
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
        // users permission
        if($role=="ADM"){
            include('../menu/menuAdmin.php');
        }
        elseif($role=="LOG"){
            include('../menu/menuLogistique.php');
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
                        <h1 class="page-header">Final Check  </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Add Final Check
                            </div>
                            <div class="panel-body" >
                                <form role="form" method="POST" name="form" action="../php/ajout_final_check.php" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>PO : </label>
                                                <input type= "text" name="po" id="PO" class="form-control" onkeyup="autoComplete()" onkeydown="hideListe()" onblur="verifierPO()"/>
                                                <label>Date : </label>
                                                <input type= "Date" name="date" id="date" class="form-control"/>
                                                <label>PDF File </label>
                                                <input type= "file" name="fileP1" id="fileP1" class="form-control"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="button" class="btn btn-primary" value="Add >> " id ="add" onclick="verifier();">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--fin -->
                </div>
            </div>
        </div>
</body>
</html>