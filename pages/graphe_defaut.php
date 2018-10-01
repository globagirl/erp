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
    <link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
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
        Graphe défaut
    </title>
    <script>
        function grapheDefaut(){
            var liste = document.getElementById('graphe');
            var g = liste.options[liste.selectedIndex].value;
            var d1 = document.getElementById("date1").value;
            var d2 = document.getElementById("date2").value;
            var J1 = document.getElementById("J1").value;
            var J2 = document.getElementById("J2").value;
            var J3 = document.getElementById("J3").value;
            var J4 = document.getElementById("J4").value;
            var J5 = document.getElementById("J5").value;
            var J6 = document.getElementById("J6").value;
            J1= parseInt(J1);
            J2= parseInt(J2);
            J3= parseInt(J3);
            J4= parseInt(J4);
            J5= parseInt(J5);
            J6= parseInt(J6);
            var totalDef=J1+J2+J3+J4+J5+J6;
            if(g=="a"){
                alert("Choisissez un graphe SVP !!");
            }else if (g=="a1"){
                $.ajax({
                    type: 'POST',
                    data: 'J1='+J1 +'&J2='+J2+'&J3='+J3+'&J4='+J4+'&J5='+J5+'&J6='+J6+'&date2='+d2 ,
                    url: '../pChart/nbr_defaut.php',
                    success: function(data) {
                        $('#div1').empty();
                        $('#div1').html(data);
                    }});

            }else if (g=="a2"){
                $.ajax({
                    type: 'POST',
                    data: 'date1='+d1 +'&date2='+d2 ,
                    url: '../pChart/defaut2.php',
                    success: function(data) {
                        $('#div1').html(data);
                    }});

            }else if (g=="a3"){
                $('#div1').empty();
                $.ajax({
                    type: 'POST',
                    data: 'nbrDef='+totalDef+'&date1='+d1 +'&date2='+d2,
                    url: '../pChart/defaut1.php',
                    success: function(data) {

                        $('#div1').html(data);
                    }});

            }
        }
        ////
        function tableDefaut(){
            var liste = document.getElementById('graphe');
            var g = liste.options[liste.selectedIndex].value;
            var d1 = document.getElementById("date1").value;
            var d2 = document.getElementById("date2").value;
            if(g=="a"){
                alert("Choisissez un graphe SVP !!");
            }else if (g=="a1"){
                $.ajax({
                    type: 'POST',
                    data: 'date1='+d1 +'&date2='+d2 ,
                    url: '../php/nbr_defaut_tab.php',
                    success: function(data) {
                        $('#tabDefaut').html(data);
                        grapheDefaut();
                    }
                });
            }else if (g=="a2"){
                $.ajax({
                    type: 'POST',
                    data: 'date1='+d1 +'&date2='+d2 ,
                    url: '../pChart/defaut2.php',
                    success: function(data) {
                        $('#div1').html(data);
                    }
                });
            }else if (g=="a3"){
                $('#imgD').remove();
                $.ajax({
                    type: 'POST',
                    data: 'date1='+d1 +'&date2='+d2 ,
                    url: '../php/nbr_defaut_tab.php',
                    success: function(data) {
                        $('#tabDefaut').html(data);
                        grapheDefaut();
                    }
                });
            }
        }
        ////
        function printGraphe(){
            var d1 = document.getElementById("date1").value;
            var d2 = document.getElementById("date2").value;
            if(d1==""){
                alert("Donnez une date  ");
            }else if(d2==""){
                alert("Donnez une date SVP ");
            }else{
                document.form1.action="../tcpdf/graphe_defaut.php";
                document.form1.submit();
            }
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
        }elseif($role=="QLT"){
            include('../menu/menuQualite.php');
        }
        else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <?php
    include('../connexion/connexionDB.php');
    ?>
    <div id='contenu'>

        <div class="container" >
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Graphe défauts   </h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>



                <div class="row">
                    <div class="col-lg-12" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Défauts par semaine
                            </div>
                            <div class="panel-body" >

                                <form method="post"  id="form1" name="form1">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <div class="col-md-4">
                                                <label class="control-label" for="graphe">Type graphe</label>
                                                <select name="graphe" id="graphe" class="form-control">


                                                    <option value="a">---Sélectionnez</option>
                                                    <option value="a1">Nombre de défauts</option>
                                                    <option value="a2">Pourcentage de chaque défaut </option>
                                                    <option value="a3">Pourcentage des défauts</option>
                                                </select>

                                            </div>
                                        </div>


                                        <div class="form-group col-md-12">
                                            <div class="col-md-4">
                                                <label class="control-label" for="date1">Debut semaine</label>
                                                <input id="date1" name="date1" type="date" class="col-md-4 form-control input-md">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="date2">Fin semaine</label>
                                                <input  id="date2" name="date2" type="date"  class="col-md-4 form-control input-md">
                                            </div>

                                            <div class="col-md-4">
                                                <br>
                                                <input type="button" onclick="tableDefaut();" class="btn btn-default" id="b1" value=">>">
                                                <!--<input type="button" onclick="grapheDefaut();" class="btn btn-default" id="b2" value="Update graphe >>">-->
                                                <input type="button" onclick="printGraphe();" class="btn btn-default" id="b3" value="Print >>">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="tabDefaut"></div>
                                        <div class="col-md-12" id="div1">
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
</body>
</html>
