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
    <title> Accounting Graphs</title>
    <SCRIPT>
    function updateG(){
        $.ajax({
            type: 'POST',
            url: '../pChart/graphe_cat6.php',
            success: function(data) {
        }});

        $.ajax({
            type: 'POST',
            url: '../pChart/graphe_cat5.php',
            success: function(data) {
        }});

        $.ajax({
            type: 'POST',
            url: '../pChart/graphe_upm3.php',
            success: function(data) {
        }});
        window.location.href = '../pages/accounting_graphe.php';
    }
    </SCRIPT>
</head>

<body>
    <div id="entete">
        <div id="logo"></div>
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
            }elseif($role=="DIR"){
            include('../menu/menuDirecteur.php');
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
                    <h1 class="page-header">Item accounting graphs</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <?php
                include('../connexion/connexionDB.php');
            ?>
            <!--
            <div class="row">
            <div class="col-lg-12" >
            <div class="panel panel-default">
            <div class="panel-heading">
            Item graphs
            </div>
            <div class="panel-body" >-->
            <form role="form" method="post" name="form1" id="form1">
            <div class="col-lg-12" id="divRel">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#cat5" data-toggle="tab">CAT 5 </a></li>
                    <li><a href="#cat6" data-toggle="tab">CAT 6</a></li>
                    <li><a href="#long" data-toggle="tab">Per length</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="cat5">
                    <div class="scrollY col-lg-12">
                        <br>
                        <?php
                        $sqlG= mysql_query("SELECT DISTINCT produit FROM produit1 where categorie LIKE 'CAT 5%'");
                        while($dataG=@mysql_fetch_array($sqlG)){
                            $produit=$dataG['produit'];
                            echo '
                                <br> <br>
                                <div class="col-lg-6 scrollDiv">
                                    <img src="../pChart/img/'.$produit.'.png"  alt="Print" style="cursor:pointer;" width="1600" height="500"  />
                                </div>
                                <div class="col-lg-6 scrollDiv">
                                    <img src="../pChart/img/P'.$produit.'.png"  alt="Print" style="cursor:pointer;" width="1600" height="500"  />
                                </div>
                                <br><br>
                            ';
                        }
                        ?>
                    </div>
                    </div>
                    <div class="tab-pane fade" id="cat6">
                    <div class="scrollY col-lg-12">
                        <br>
                        <?php
                            $sqlG= mysql_query("SELECT DISTINCT produit FROM produit1 where categorie LIKE 'CAT 6%'");
                            while($dataG=@mysql_fetch_array($sqlG)){
                                $produit=$dataG['produit'];
                                echo '
                                    <br>
                                    <br>
                                    <div class="col-lg-6 scrollDiv">
                                    <img src="../pChart/img/'.$produit.'.png"  alt="Print" style="cursor:pointer;" width="1600" height="500"  />
                                    </div>
                                    <div class="col-lg-6 scrollDiv">
                                    <img src="../pChart/img/P'.$produit.'.png"  alt="Print" style="cursor:pointer;" width="1600" height="500"  />
                                    </div>
                                    <br>  <br>';
                            }
                        ?>
                    </div>
                    </div>
                    <div class="tab-pane fade" id="long">
                    <div class="scrollY col-lg-12">
                        <br>
                        <?php
                            $sqlG= mysql_query("SELECT DISTINCT longueur FROM produit1 where longueur>0  order by longueur ASC");
                            while($dataG=@mysql_fetch_array($sqlG)){
                                $L=$dataG['longueur'];
                                echo '
                                    <br><br>
                                    <div class="col-lg-6 scrollDiv">
                                    <img src="../pChart/img/M'.$L.'.png"  alt="Print" style="cursor:pointer;" width="1600" height="500"  />
                                    </div>
                                    <div class="col-lg-6 scrollDiv">
                                    <img src="../pChart/img/MP'.$L.'.png"  alt="Print" style="cursor:pointer;" width="1600" height="500"  />
                                    </div>
                                    <br><br>';
                            }
                        ?>
                    </div>
                    </div>
                </div><!--content-->
            </div><!--divRel-->
            </form>
            <!--</div>
            </div>
            </div>
            </div>-->
        </div>
        </div>
        <!--fin -->
        </div>
    </div>
</body>
</html>