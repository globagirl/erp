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
    <title>
        Stock Entry
    </title>
    <script>
        function affiche_article(){
            var liste = document.getElementById("reception");
            var valeur = liste.options[liste.selectedIndex].value;
            $.ajax({
                type: 'POST',
                data : 'reception=' + valeur,
                url: '../php/affiche_article_recue.php',
                success: function(data) {
                    $('#arts').html(data);
                }});
        }
        /////////////Affichage du shipment N°
        function afficheSH(){
            var liste = document.getElementById("reception");
            var valeur = liste.options[liste.selectedIndex].value;
            $.ajax({
                type: 'POST',
                data : 'reception=' + valeur,
                url: '../php/affiche_shipment_recue.php',
                success: function(data) {
                    document.getElementById("shipID").value=data;
                }});
        }
        ////////////
        function afficheCase(i){
            var Z="#DD"+i;
            var v2="paq"+i;
            var v3="suite"+i;
            var v4="batch"+i;
            var v5="chB"+i;
            var v6="chB2"+i;
            var v1="ch"+i;
            var val= document.getElementById(v1).value;
            if( $('input[name='+v1+']').is(':checked') ){
                document.getElementById(v2).disabled=false;
                document.getElementById(v2).value=1;
                document.getElementById(v3).disabled=false;
                document.getElementById(v3).value=0;
                document.getElementById(v4).disabled=false;
                document.getElementById(v5).disabled=false;
                document.getElementById(v6).disabled=false;
            }
            else{
                document.getElementById(v2).disabled=true;
                document.getElementById(v2).value="";
                document.getElementById(v3).disabled=true;
                document.getElementById(v3).value="";
                if(document.getElementById(v4).disabled==true){
                    $(Z).remove();
                }
                document.getElementById(v4).disabled=true;
                document.getElementById(v4).value="";
                document.getElementById(v5).disabled=true;
                document.getElementById(v6).disabled=true;
            }
        }
        //////affichage batch
        function afficheBatch(j){
            var batch="batch"+j;
            var  v1="ar"+j;
            var v2="qtr"+j;
            var v3="paq"+j;
            var v4="suite"+j;
            if(document.getElementById(batch).disabled==false){
                document.getElementById(batch).disabled=true;
                var liste = document.getElementById("reception");
                var valeur = liste.options[liste.selectedIndex].value;
                var ar = document.getElementById(v1).value;
                var qtr = document.getElementById(v2).value;
                var paq = document.getElementById(v3).value;
                var suit = document.getElementById(v4).value;
                $.ajax({
                    type: 'POST',
                    data : 'reception='+valeur+'&i='+j+'&ar='+ar+'&qtr='+qtr+'&paq='+paq+'&suit='+suit,
                    url: '../php/affiche_article_batch.php',
                    success: function(data) {
                        var Z="#Z"+j;
                        $(Z).append(data);
                    }});
            }
        }
        ////////////////////Remove zone batch
        function removeBatch(j){
            var batch="batch"+j;
            var  Z="#DD"+j;
            if(document.getElementById(batch).disabled==true){
                $(Z).remove();
                document.getElementById(batch).disabled=false;
            }
        }
        ///////////////////////////////////
        function clickZoneP(p){
            document.getElementById(p).value="";
        }
        function clickZoneS(s){
            document.getElementById(s).value="";
        }
        function blurZoneP(p){
            var val= document.getElementById(p).value;
            if(val==""){
                document.getElementById(p).value=1;
            }
        }
        function blurZoneS(s){
            var val= document.getElementById(s).value;
            if(val==""){
                document.getElementById(s).value=0;
            }
        }
        function addS(){
            var v=1;
            var nbr= document.getElementById('nbr').value;
            var ch="";
            var batch="";
            var i=1;
            while (i<= nbr && v==1) {
                ch="ch"+i;
                batch="batch"+i;
                var batchV= document.getElementById(batch).value;
                if ($('input[name='+ch+']').is(':checked') ){
                    if(document.getElementById(batch).disabled==false){
                        if(batchV==""){
                            document.getElementById(batch).style.backgroundColor='pink';
                            v=0;
                        }else{
                            i++;
                        }
                    }else{
                        i++;
                    }
                }else{
                    v=0;
                }
            }
            if(v==0){
                alert("If you have a problem with the quantity entered, please contact the RESPONSIBLE PLZ! ");
            }else{
                document.forms['form1'].submit();
            }
        }
        //////////////
        function clearZone(){
            $('#arts').empty();
        }
        ///////////////
        function affichelisteF(){
            $.ajax({
                type: 'POST',
                url: '../php/listeFournisseur.php',
                success: function(data) {
                    $('#four').html(data);
                    document.getElementById("shipID").value="";
                }});
        }
        /////////////
        function affichelisteR(){
            var liste = document.getElementById('four');
            var four = liste.options[liste.selectedIndex].value;
            $.ajax({
                type: 'POST',
                data : 'supplier=' +four,
                url: '../php/listeReception.php',
                success: function(data) {
                    $('#reception').html(data);
                }});
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
        }
        elseif($role=="MAG"){
            include('../menu/menuMagazin.php');
        }
        else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <br>
        <p class="there">Stock Entry</p>
        <br>
        <!-- end -->
        <?php
        include('../connexion/connexionDB.php');
        ?>
        <form method="post"  id="form1" action="../php/ajout_stock.php">
            <TABLE >
                <TR>
                    <TH Wcode_articleTH=150 HEIGHT=30  ALIGN="left">Supplier: </TH>
                    <TD colspan>
                        <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                            <select name="four" id="four"  style="width:270px" class="custom-dropdown__select custom-dropdown__select--white" onChange="affichelisteR(),clearZone();" onFocus="affichelisteF();">
                               <option value="s">---Select---</option>
                            </select>
                        </span>
                    </td>
                    <TD colspan>
                        <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                            <select name="reception" id="reception"  style="width:270px" class="custom-dropdown__select custom-dropdown__select--white" onChange="clearZone(),afficheSH();">
                               <option value="s">Reception ID </option>
                            </select>
                        </span>
                        <input type="text"  id="shipID" placeholder="Shipment ID" READONLY>
                    </td>
                    <td>
                        <input type="button" onclick="affiche_article()" id="submitbutton" value="OK">
                    </TD>
                </TR>
            </table>
            <div id="arts" style="text-align:center">
            </div>
    </div>
</div>
</body>
</html>