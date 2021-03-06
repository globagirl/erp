<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 28/09/2018
 * Time: 12:56
 */

session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else {
    $role = $_SESSION['role'];
    $userID = $_SESSION['userID'];
    include('../connexion/connexionDB2.php');
}
?>
<html>
<head>
    <meta charset="utf-8" />
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
    <script type='text/javascript' src="../include/scripts/consult_bande_sortie.js"></script>
    <title> Consult Complete Stock</title>
    <script>
        function affiche_sortie(){
            //alert ("hhhhhh");
            $('#tbody2').html('<tr><td style="width:100%"> <center><img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center></td></tr>');
            var val = document.getElementById("valeur").value;
            $.ajax({
                type: 'POST',
                data: 'valeur='+val,
                url: '../php/consult_real_stock.php',
                success: function(data) {
                    $('#tbody2').html(data);
                }});
        }
    </script>
</head>
<body>
<div id="entete" style=" width: 100%">
    <div id="logo"></div>
    <div id="boton"><?php include('../include/logOutIMG.php');?></div>
</div>
<div id="main">
    <div id="menu">
        <div id="menu">
            <?php
            if($role=="ADM"){
                include('../menu/menuAdmin.php');
            }else if($role=="MAG"){
                include('../menu/menuMagazin.php');
            }else if($role=="COM"){
                include('../menu/menuCommercial.php');
            }else{
                header('Location: ../deny.php');
            }
            ?>
        </div>
    </div>
    <div id='contenu'>
        <div class="container">
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header"> Complete Stock </h1>
                    </div>
                </div>
                <div class="row">
                    <!-- <div class="col-md-12">-->
                    <div class="panel panel-default">
                        <div class="panel-heading"> Complete Stock </div>
                        <div class="panel-body">
                            <form  id="form1" name="form1" method="POST">
                                <div class="row">
                                    <div class="pull-left col-md-6">
                                        <div class="form-group form-inline col-md-12">
                                            <span id="zone">
                                                <label>Article</label>
                                                <input type="text" class="search form-control" name="valeur" id="valeur" placeholder="Article ">
                                            </span>
                                        </div>
                                        <div  class="form-group col-md-6">
                                            <!--                                            <label>Date antérieur :</label>-->
                                            <!--                                            <input type="date" class="search form-control" name="dateA" id="dateA" >-->
                                        </div>
                                        <div  class="form-group col-md-12">
                                            <input type="button" onClick="affiche_sortie();" class="btn btn-primary" Value=">>Search ">
                                            <!--                                            <input type="button" onClick="stock_excel();" class="btn btn-danger" Value="Excel >>">-->
                                        </div>
                                    </div>
                                    <div class="col-md-12" >
                                        <div class="table-responsive" id="divRel">
                                            <table  class="table  table-striped table-bordered table-hover" id="table3">
                                                <thead>
                                                <tr>
                                                    <th style="height:60px" class="degraD">Article</th>
                                                    <th style="height:60px" class="degraD"> Real Stock</th>
                                                    <th style="height:60px" class="degraD">Reception Date</th>
                                                    <th style="height:60px" class="degraD">Complete Stock</th>
                                                </tr>
                                                </thead>
                                                <tbody id="tbody2" >
                                                <?php
                                                //affiche stock
                                                $sql =mysql_query('SELECT IDarticle, qte_demande , Date_prevue  FROM ordre_achat_article1 WHERE Date_prevue > NOW() ORDER BY Date_prevue');
                                                $s2=mysql_query('SELECT article1.stock FROM article1, ordre_achat_article1 WHERE article1.code_article = ordre_achat_article1.IDarticle ');
                                                 while(($row = mysql_fetch_array($sql))&&($row2 = mysql_fetch_array($s2)) ){
                                                        $sum=$row2['stock']+$row['qte_demande'];
                                                        echo '<tr>';
                                                        echo'<td style="width:15%;height:60px;text-align:center">' .$row['IDarticle'].'</td>';
                                                        echo'<td style="width:15%;height:60px;text-align:center">'.$row2['stock'].'</td>';
                                                        echo'<td style="width:15%;height:60px;text-align:center">' .$row['Date_prevue'].'</td>';
                                                        echo'<td style="width:15%;height:60px;text-align:center">' . $sum .'</td>';
                                                        echo '</tr>';
                                                    } //pour finir la boucle
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> <!--Fin row-->
                            </form>
                        </div>
                    </div>
                    <!--</div> -->
                </div><!-- row 2 fin -->
            </div>
        </div>
    </div>
</div>
</body>
</html>