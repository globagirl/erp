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
        Add Product
    </title>
    <script>
        //Liste catégorie
        function catListe(){
            $.ajax({
                type: 'POST',
                url: '../php/listeCatProduit.php',
                success: function(data) {
                    $('#cat').html(data);
                }});
        }
        //Liste client
        function listeClient(){
            $.ajax({
                url: '../php/listeClient.php',
                type: 'POST',
                success:function(data){
                    $('#client').html(data);
                }
            });
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
                        <h1 class="page-header">Product  </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-6" >
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Add Product
                            </div>
                            <div class="panel-body" >
                                <form role="form" method="post" name="form1" action="../php/ajout_produit_auto.php" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Customer </label>
                                                <select type="text" name="client" id="client" class="form-control" OnFocus="listeClient();">
                                                    <option value="s">Select...</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Category </label>
                                                <select type="text" name="cat" id="cat" class="form-control" OnFocus="catListe();">
                                                    <option value="s">Select...</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Note </label>
                                                <textarea class="form-control" id="note" name="note" placeholder="Note in case of update of the product price"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Excel File</label>
                                                <input type= "file" name="fileP" id="fileP" class="form-control"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Add >> ">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--fin -->
                    <div class="col-lg-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                Add Product Nomenclature
                            </div>
                            <div class="panel-body" >
                                <form role="form" method="post" name="form2" action="../php/ajout_nomenclature_auto.php" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Total components nbr (+ cable) </label>
                                                <input type= "text" name="nbrC" id="nbrC" class="form-control"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Excel File</label>
                                                <input type= "file" name="fileP1" id="fileP1" class="form-control"/>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" value="Add >> ">
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