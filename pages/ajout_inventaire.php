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
    <script type='text/javascript' src='../jquery/menu_jquery.js'></script>
    <link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/bootbox.min.js"></script>
    <title>Customer Payment </title>
    <script>
        ////////////////////////LISTE LIKE GOOGLE :) /////////////
        function autoComplete(c,l){
            var zoneC="#"+c;
            var zoneL="#"+l;
            var min_length =3;
            var keyword = $(zoneC).val();
            if (keyword.length >= min_length) {
                $.ajax({
                    url: '../php/auto_liste_article.php',
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
        ///*
        function hideListe(l) {

            var zoneL="#"+l;
            $(zoneL).hide();
        }
        //
        function choixListe(p,z) {
            $(z).val(p);
        }
        ///////
        function afficheListe(){
            var dateI = document.getElementById("dateI").value;

            $.ajax({
                url: '../php/afficheInventaire.php',
                type: 'POST',
                data: "dateI="+dateI,
                success:function(data){
                    $('#divListe').html(data);
                    document.getElementById("divA").style.visibility="visible";
                }});
        }
        function afficheArticle(){
            var article = document.getElementById("article").value;
            var dateI = document.getElementById("dateI").value;
            if(article==""){
                bootbox.alert("PLZ enter the Article code !!");
            }else{
                $.ajax({
                    url: '../php/afficheArticle_inventaire.php',
                    type: 'POST',
                    data: "dateI="+dateI+"&article="+article,
                    success:function(data){
                        $('#divFA').html(data);
                    }});
            }
        }
        function ajoutArticleS(){
            var dateI = document.getElementById("dateI").value;
            var article = document.getElementById("article").value;
            var stockR = document.getElementById("stockR").value;
            var stockSys = document.getElementById("stockSys").value;
            $.ajax({
                url: '../php/ajoutArticle_inventaire.php',
                type: 'POST',
                data: "stockR="+stockR+"&article="+article+"&stockSys="+stockSys+"&dateI="+dateI,
                success:function(data){
                    if(data=="1"){
                        afficheListe();
                    }else if(data=="2"){
                        //afficheListe();
                        bootbox.alert("The margin of the difference between the two stocks is exceeded !! PLZ Check your values !!");
                    }else{
                        //afficheListe();
                        bootbox.alert("This article already exists in the inventories list !!");
                    }
                }});
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
        }else if($role=="FIN"){
            include('../menu/menuFinance.php');
        }else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <div class="container" >
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Customer Payment </h1>
                    </div>
                </div>
                <form role="form" method="post" name="form1" id="form1">
                    <div class="row">
                        <div class="col-lg-12" >
                            <div class="panel panel-default">
                                <div class="panel-body well">
                                    <div class="row">
                                        <div class="col-lg-6">

                                            <div class="form-group">
                                                <label>Inventory Date : </label>
                                                <div class="form-group form-inline">
                                                    <input class="form-control" type="date" id="dateI" name="dateI"  >
                                                    <button type="button" class="btn btn-danger" onClick="afficheListe();">>> </button>
                                                </div>
                                            </div>
                                            <hr/>
                                            <div class="form-group form-inline" id="divA" style="visibility:hidden">
                                                <input class="form-control" type="text" id="article" placeholder=" Article Code" onBlur="hideListe('listeC1');"  onKeyup="autoComplete('article','listeC1');" onFocus="autoComplete('article','listeC1');">
                                                <button type="button" class="btn btn-danger" onClick="afficheArticle();">>> </button>
                                                <div class="divAuto"><ul id="listeC1" ></ul></div>
                                            </div>
                                            <div id="divFA"></div>
                                        </div>
                                        <div class="col-lg-6" id="divListe">
                                        </div>
                                    </div>
                                </div>
                                <?php
                                mysql_close();
                                ?>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>