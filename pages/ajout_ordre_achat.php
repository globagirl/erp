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
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <script src="../jquery/jquery-latest.min.js"></script>
    <script type='text/javascript' src='../jquery/menu_jquery.js'></script>
    <link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../bootstrap/js/bootbox.min.js"></script>

    <title>Purchase Order</title>
    <script>
        var i=1;
        ////////////////////////LISTE LIKE GOOGLE :) /////////////
        function autoComplete(c,l){
            var zoneC="#"+c;
            var zoneL="#"+l;
            var min_length =0;
            var keyword = $(zoneC).val();
            if (keyword.length >= min_length) {
                $.ajax({
                    url: '../php/auto_liste_article.php',
                    type: 'POST',
                    data: "val="+keyword+"&Z="+zoneC,
                    success:function(data){
                        $(zoneL).show();
                        $(zoneL).html(data);
                    }
                });
            }else {
                $(zoneL).hide();
            }
        }
        ///*
        /*function hideListe(l) {

            var zoneL="#"+l;
            $(zoneL).hide();
            }
        //	*/
        function choixListe(p,z) {
            $(z).val(p);
        }
        ////////////FIN////////////
        function afficheP(it,p,l){
            var zoneL="#"+l;
            $(zoneL).hide();
            var item = document.getElementById(it).value;
            $.ajax({
                type: 'POST',
                data : 'item=' + item,
                url: '../php/affichePriceAchat.php',
                success: function(data) {
                    if(data=="NO"){
                        bootbox.alert("PLZ verify the product code !! ");
                        document.getElementById(p).value=0;
                    }
                    else{
                        document.getElementById(p).value=data;
                    }
                }
            });
        }
        function totalP(punitZ,qtyZ,Z,item){
            var ancien = document.getElementById(Z).value;
            ancien=parseFloat(parseFloat(ancien).toFixed(6)) || 0;
            var total = document.getElementById("total").value;
            total=parseFloat(parseFloat(total).toFixed(6)) || 0;
            total=total-ancien;
            total=parseFloat(parseFloat(total).toFixed(6)) || 0;
            document.getElementById(Z).value=0;
            document.getElementById("total").value=total;
            var art = document.getElementById(item).value;
            var qty = document.getElementById(qtyZ).value;
            $.ajax({
                type: 'POST',
                data : 'art='+art+'&qte='+qty,
                url: '../php/verif_qte_achat.php',
                success: function(data){
                    if(data > 0){
                        bootbox.alert ("PLZ verify the QTY, it must be a multiple of : "+data);
                    }else{
                        var punit=document.getElementById(punitZ).value;
                        punit=parseFloat(parseFloat(punit).toFixed(6)) || 0;
                        //var qty=document.getElementById(qtyZ).value;
                        qty=parseFloat(parseFloat(qty).toFixed(6)) || 0;
                        //var total=document.getElementById("total").value;
                        //total=parseFloat(total);
                        var PT1=punit*qty;
                        PT1=parseFloat(parseFloat(PT1).toFixed(6)) || 0;
                        document.getElementById(Z).value=PT1;
                        var TTT=total+PT1;
                        TTT=parseFloat(parseFloat(TTT).toFixed(6)) || 0;
                        document.getElementById("total").value=TTT;
                    }
                }
            });
        }
        ///////Tax & transport
        function addP(x){
            var prix=document.getElementById(x).value;
            if(prix != ""){
                prix=parseFloat(parseFloat(prix).toFixed(6)) || 0;
                var total=document.getElementById("total").value;
                total=parseFloat(parseFloat(total).toFixed(6)) || 0;
                var P=total+prix;
                P=parseFloat(parseFloat(P).toFixed(6)) || 0;
                document.getElementById("total").value=P;
            }}
        function deleteP(x){
            var prix=document.getElementById(x).value;
            if(prix!=""){
                prix=parseFloat(parseFloat(prix).toFixed(6)) || 0;
                document.getElementById(x).value="";
                var total=document.getElementById("total").value;
                total=parseFloat(parseFloat(total).toFixed(6)) || 0;
                var P=total-prix;
                if(isNaN(P)){
                    P=0;
                    document.getElementById("total").value=P;
                }else{
                    P=parseFloat(parseFloat(P).toFixed(6)) || 0;
                    document.getElementById("total").value=P;}
            }}
        ////////////////////////
        function addA(){
            var TX="#TR"+i;
            i++;
            document.getElementById('nbr').value=i;
            var T="TR"+i;
            var itemN="I"+i;
            var qtyN="Q"+i;
            var PU="PU"+i;
            var TP="TP"+i;
            var listeC="listeC"+i;
            $(TX).after('<div class="well" id='+T+'> <b> Item N°'+i+' </b><input type="text" style="width:150px" id='+itemN+' name='+itemN+' onBlur=afficheP("'+itemN+'","'+PU+'","'+listeC+'") onKeyup=autoComplete("'+itemN+'","'+listeC+'") onFocus=autoComplete("'+itemN+'","'+listeC+'")> <input type="text" id='+PU+' name='+PU+' placeholder="Unit Price" size="8"  READONLY > <b>Quantity </b><input type="text" id='+qtyN+' name='+qtyN+' size="8" placeholder="QTY" onBlur=totalP("'+PU+'","'+qtyN+'","'+TP+'","'+itemN+'"); /><b> Total Price </b><input type="text" id='+TP+' name='+TP+' size="8" value="0" READONLY><div class="divAuto"><ul id='+listeC+'></ul></div></div>');
        }
        ///
        function deleteI(){
            if(i>1){
                var D="#TR"+i;
                var TPV="TP"+i;
                var prix=document.getElementById(TPV).value;
                prix=parseFloat(parseFloat(prix).toFixed(5)) || 0;
                $(D).remove();
                if(prix>0){
                    var total=document.getElementById('total').value;
                    total=parseFloat(parseFloat(total).toFixed(5)) || 0;
                    if(total>0){
                        var TTT=total-prix;
                        TTT=parseFloat(parseFloat(TTT).toFixed(5)) || 0;
                        document.getElementById('total').value=TTT;
                    }
                }
                i--;
                document.getElementById('nbr').value=i;
            }
        }
        function affichelisteF(){
            $.ajax({
                type: 'POST',

                url: '../php/listeFournisseur.php',
                success: function(data) {
                    $('#four').html(data);
                }
            });
        }
        function pop_up(url){
            window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no')
        }
        function addPO(){
            document.getElementById('nbr').value=i;
            var liste = document.getElementById('four');
            var fournisseur = liste.options[liste.selectedIndex].value;
            //var total = document.getElementById('total').value;
            var dateD = document.getElementById('dateD').value;
            var devise = document.getElementById('devise').value;
            var tpay = document.getElementById('tpay').value;
            if(fournisseur=="s"){
                bootbox.alert("PLZ select a Supplier !!");
            }else if(dateD==""){
                bootbox.alert("PLZ select a Date !! ");
            }else if((total==0 )||(total=="0")||(total=="")){
                bootbox.alert("PLZ select Items !! ");
            }else if(tpay=="S"){
                bootbox.alert("PLZ select Currency !! ");
            } else if(devise=="S"){
                bootbox.alert("PLZ select Currency !! ");
            }else{
                document.getElementById('form1').submit();
            }
        }
    </script>
</head>
<body onLoad="affichelisteF();">
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
        }else if($role=="COM"){
            include('../menu/menuCommercial.php');
        }else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <div class="container" >
            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12"><h1 class="page-header">Add Purchase Order</h1></div>
                </div>
                <form role="form" method="post" name="form1" id="form1" action="../php/ajout_ordre_achat.php">
                    <div class="row">
                        <div class="col-lg-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading"> Purchase Order </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label> Purchase Order N°:</label>
                                                <?php
                                                $sql3 = mysql_query("SELECT max(IDordre)from ordre_achat2");
                                                $m=mysql_result($sql3,0);
                                                $max=$m+1;
                                                ?>
                                                <input class="form-control" name="num_ord"  value="<?php echo $max ; ?>" >
                                            </div>
                                            <div class="form-group">
                                                <label>Supplier :</label>
                                                <div class="form-inline">
                                                    <select name="four" id="four"  class="form-control" onFocus="affichelisteF();">
                                                        <option value="s">---Select---</option>
                                                    </select>
                                                    <input type="button" onclick="pop_up('../pages/pop_ajout_fournisseur.php');" value="+" class="btn btn-primary">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Payment Term:</label>
                                                <select name="tpay" id="tpay" type="text" class="form-control">
                                                    <option value="S">Select ...</option>
                                                    <?php include('../include/utile/terme_payment.php'); ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Requested date by STARZ :</label>
                                                <input type="date" name="dateD" id="dateD" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" >
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Items
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="well" id="TR1">
                                                <b> Item N°1 </b>
                                                <input type="text" style="width:150px" id="I1" name="I1" onBlur="afficheP('I1','PU1','listeC1');" onKeyup="autoComplete('I1','listeC1');" onFocus="autoComplete('I1','listeC1');">
                                                <input type="text" id="PU1" name="PU1" placeholder="Unity Price" size="8" READONLY >
                                                <b> Quantity  </b>
                                                <input type="text" id="Q1" name="Q1" size="8" placeholder="QTY" onBlur="totalP('PU1','Q1','TP1','I1');" />
                                                <b> Total Price </b>
                                                <input type="text" id="TP1" name="TP1" size="8" value="0" READONLY>
                                                <div class="divAuto"><ul id="listeC1" ></ul></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="well">
                                                <input type="button" onclick="addA();" value="+" class="btn btn-primary">
                                                <input type="button" onclick="deleteI();"  value="-" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="form-group form-inline">
                                        <input type="text" name="tax" id="tax"  placeholder="Tax" onBlur="addP('tax');" onFocus="deleteP('tax');" class="form-control" >
                                        <input type="text" name="transport" id="transport" size="12" onBlur="addP('transport');" onFocus="deleteP('transport');" placeholder="" class="form-control" >
                                        <input type="text" name="total" id="total" size="12" value="0" READONLY class="form-control">
                                        <select name="dev" id="devise" class="form-control">
                                            <option value="S">Currency ...</option>
                                            <?php include('../include/utile/devise.php'); ?>
                                        </select>
                                        <input type="button" onclick="addPO();" id="add1" value="ADD  >> " class="btn btn-danger">
                                        <input type="text" name="nbr" id="nbr"  style="visibility:hidden">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php mysql_close(); ?>
                </form>
            </div>
        </div>
</body>
</html>
