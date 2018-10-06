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
    <link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script type='text/javascript' src='../include/scripts/consult_transaction_compte.js'></script>
    <title>
        Add Transaction
    </title>
    <script>
        var v=1;
        function verif_cheque(){
            var modeT=document.getElementById("modeT").value;
            var compte = document.getElementById("compte").value;
            var REF=document.getElementById("REF").value;
            if(modeT == "CHQ"){
                $.ajax({
                    type: 'POST',
                    data: 'compte='+compte+'&ref='+REF,
                    url: '../php/verif_cheque.php',
                    success: function(data) {
                        if(data=="1"){
                            bootbox.alert("This check exists already !!");
                            v=0;
                        }else{
                            v=1;
                        }
                    }});
            }else{
                v=1;
            }
        }
        //
        function verif(){
            var dateT=document.getElementById("dateT").value;
            var compte=document.getElementById("compte").value;
            var modeT=document.getElementById("modeT").value;
            var REF=document.getElementById("REF").value;
            var desc=document.getElementById("DESC").value;
            var montant=document.getElementById("montant").value;
            var catT=document.getElementById("catT").value;
            if(dateT==""){
                bootbox.alert("PLZ enter the transaction date!!");
            }else if(compte=="S"){
                bootbox.alert("PLZ enter the bank account identifier!!");
            }else if((document.getElementById("actT1").checked==false)&& (document.getElementById("actT2").checked==false)){
                bootbox.alert("PLZ select action's type!!");
            }else if(modeT=="S"){
                bootbox.alert("PLZ select the transaction Mode!!");

            }else if((REF=="") && (modeT != "AGIO")){
                bootbox.alert("PLZ enter the reference  !!");
            }else if(catT == "s"){
                bootbox.alert("PLZ enter Category !!");
            }else if(desc==""){
                bootbox.alert("PLZ enter description of the transaction !!");
            }else if(montant==""){
                bootbox.alert("PLZ enter the amount !!");
            }else if((etat=="S") && (modeT == "CHQ")){
                bootbox.alert("Give the state of the check please!!");
            }else if(v == 0){
                bootbox.alert("Check N° exist already !!");
            }else {
                //document.forms['formD'].submit();
                if(modeT != "AGIO"){
                    var etat=document.getElementById("etat").value;
                }else{
                    var etat="R";
                }
                if(document.getElementById("actT1").checked==true){
                    var typeT="RT";
                }else{
                    var typeT="RH";
                }
                $.ajax({
                    url: '../php/ajout_transaction.php',
                    type: 'POST',
                    data: "compte="+compte+"&REF="+REF+"&typeT="+typeT+"&modeT="+modeT+"&DESC="+desc+"&dateT="+dateT+"&montant="+montant+"&etat="+etat+"&catT="+catT,
                    success:function(data){
                        afficheTrans();
                        document.getElementById("dateT").value="";
                        //document.getElementById("compte").selectedIndex=0;
                        document.getElementById("modeT").selectedIndex =0;
                        document.getElementById("catT").selectedIndex =0;
                        document.getElementById("etat").selectedIndex =0;
                        document.getElementById("REF").value="";
                        document.getElementById("DESC").value="";
                        document.getElementById("montant").value="";
                        document.getElementById("actT1").checked=false;
                        document.getElementById("actT2").checked=false;
                    }});
                //alert("OK");
            }
        }
        function etatActive(){
            var modeT=document.getElementById("modeT").value;
            if(modeT!="AGIO"){
                document.getElementById('etat').disabled=false;
            }else{
                document.getElementById('etat').disabled=true;
            }
        }
        ///Afficher la liste des catégories
        function afficheCat(){
            if(document.getElementById("actT1").checked==true){
                $.ajax({
                    type: 'POST',
                    url: '../php/listeCategory.php',
                    success: function(data) {
                        $('#catT').html(data);
                    }
                });
            }else{
                $.ajax({
                    type: 'POST',
                    url: '../php/listeCategory2.php',
                    success: function(data) {
                        $('#catT').html(data);
                    }
                });
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
        }else if($role=="DIR"){
            include('../menu/menuDirecteur.php');
        }elseif($role=="FIN"){
            include('../menu/menuFinance.php');
        }elseif($role=="GRH"){
            include('../menu/menuGRH.php');
        }else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <div class="container" >
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">Transaction  </h1>
                    </div>
                    <!-- /.col-md-12 -->
                </div>
                <div class="row">
                    <div class="col-md-12" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Add transaction
                            </div>
                            <div class="panel-body" >
                                <form role="form" method="post" name="formD" id="formD" action="../php/ajout_transaction.php" >
                                    <div class="col-md-4">
                                        <!--<div class="col-md-6">-->
                                        <div class="form-group ">
                                            <label>Transaction Date </label>
                                            <input type="date" class="form-control" placeholder="aaaa-mm-jj" name="dateT" id="dateT">

                                        </div>
                                        <div class="form-group" >
                                            <label>Bank Account </label>
                                            <select class="form-control" id="compte" name="compte">
                                                <?php
                                                $q2 = mysql_query("SELECT * FROM compte_banque");
                                                echo '<option value="S">Select...</option>';
                                                while($data2=mysql_fetch_array($q2)) {
                                                    echo '<option value="'.$data2["REFcompte"].'">'.$data2["REFcompte"].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="typeT" id="actT1" value="RT" onClick="afficheCat();">Withdrawal
                                                </label>
                                            </div>
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="typeT" id="actT2" value="RH" onClick="afficheCat();">Recharge
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-inline">
                                                <select class="form-control" id="modeT" name="modeT" onChange="etatActive();">
                                                    <option value="S">Mode ...</option>
                                                    <option value="VIR">Transfer</option>
                                                    <option value="CHQ">Check</option>
                                                    <option value="AGIO">AGIOS</option>
                                                </select>
                                                <input type="text" class="form-control"  placeholder="Reference" name="REF" id="REF" onBlur="verif_cheque();">
                                            </div>
                                        </div>
                                    </div> <!--Fin div 1 -->
                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select class="form-control" id="catT" name="catT" onFocus="afficheCat();">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control"  placeholder="Description" name="DESC" id="DESC"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-inline">
                                                <input type="text" class="form-control"  placeholder="Amount .." name="montant" id="montant">
                                                <select class="form-control" id="etat" name="etat" Disabled>
                                                    <option value="AT">Waiting</option>
                                                    <option value="R">Withdraw</option>
                                                    <option value="AN">Canceled</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="button" onClick="verif();" class="btn btn-default blue" Value="Add >> ">
                                            <!--<input type="button" onClick="verif_cheque();" class="btn btn-default blue" Value="Ajouter >> ">-->
                                        </div>
                                        <!--</div>-->
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!-- fin ajout transaction -->
                    <div class="col-md-12" >
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Consult transaction
                            </div>
                            <div class="panel-body" >
                                <div class="table-responsive" id="divRel"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- fin row -->
            </div>
            <?php mysql_close(); ?>
</body>
</html>