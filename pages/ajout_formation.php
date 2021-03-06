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
        ADD new training
    </title>
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
        <div class="container col-md-12" >
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">Training</h1>
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
                                Add new training
                            </div>
                            <div class="panel-body" >
                                <form role="form" method="post" name="form1" id="form1" action="../php/ajout_formation.php">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group col-md-10">
                                                <label>Training</label>
                                                <input name="nomF" id="nomF" class="form-control">
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label>Description</label>
                                                <textarea class="form-control" id="desc" name="desc" rows="3" > </textarea>
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label>Trainer 1</label>
                                                <input class="form-control" id="f1" name="f1" type="text"  >
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label>Trainer 2</label>
                                                <input class="form-control" id="f2" name="f2" type="text"  >
                                            </div>
                                            <div class="form-group col-md-10">
                                                <input type="submit" class="btn btn-default blue" value="ADD >>">
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