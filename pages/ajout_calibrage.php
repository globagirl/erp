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
        ADD new Calibration
    </title>
    <SCRIPT>

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
        } elseif($role=="LOG"){
            include('../menu/menuLogistique.php');
        }elseif($role=="QLT"){
            include('../menu/menuQualite.php');
        } else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <div class="container col-md-12" >
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">Calibration</h1>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Add new calibration
                            </div>
                            <div class="panel-body" >
                                <form role="form" method="post" name="form1" id="form1" action="../php/ajout_calibrage.php">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group col-md-10">
                                                <label>Material ID</label>
                                                <select name="IDmat" id="IDmat" class="form-control">
                                                    <?php
                                                    include('../connexion/connexionDB.php');
                                                    $sql = "SELECT * FROM materiel ";
                                                    $res = mysql_query($sql) or exit(mysql_error());
                                                    echo '<option value="s">Select ...</option><br/>';
                                                    while($data=mysql_fetch_array($res)) {
                                                        echo '<option value="'.$data["IDmat"].'">'.$data["IDmat"].'</option><br/>';
                                                    }
                                                    mysql_close();
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label>Calibration date</label>
                                                <input class="form-control" id="dateC" name="dateC" type="date"  >
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label>Result  </label>
                                                <br>
                                                <label class="radio-inline">
                                                    <input type="radio" name="resultat" id="optionsRadios1" value="Conform" checked>Conform
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="resultat"  id="optionsRadios2" value="To repair">To repair
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="resultat"  id="optionsRadios2" value="Not conform">Not conform
                                                </label>
                                            </div>
                                            <div class="form-group col-md-10">
                                                <label>Certification number</label>
                                                <input class="form-control" id="certID" name="certID" type="text"  >
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