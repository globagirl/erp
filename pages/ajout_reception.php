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
    <link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <script src="../jquery/jquery-latest.min.js"></script>
    <script type='text/javascript' src='../jquery/menu_jquery.js'></script>
    <link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
    <title>
        Items reception
    </title>
    <script>
        //affichage des fournisseur selon le type
        function affichelisteF(){
            $.ajax({
                type: 'POST',

                url: '../php/listeFournisseur.php',
                success: function(data) {
                    $('#four').html(data);
                }});
        }
        var i=0;
        function add(){
            var supplier=document.getElementById('four').value;
            var dateR=document.getElementById('dateR').value;
            if(dateR == "") {
                alert("PLZ Enter The Reception Date!!");
            }else if(supplier == "" || supplier == "s") {
                alert("Select Supplier PLZ!!");
            }else{
                i++;
                document.getElementById('nbr').value=i;
                var orderN="O"+i;
                var itemN="I"+i;
                var qtyN="Q"+i;
                var dN="d"+i;
                var pN="p"+i;
                $('#items').append('<div id='+dN+'> Purchase order  :  <select id='+orderN+' name='+orderN+' style="width:150px" onChange=afficheItems("'+orderN+'","'+itemN+'"); ></select>  Items :  <select style="width:150px" id='+itemN+' name='+itemN+' onChange=afficheP("'+orderN+'");></select> Quantity :<input type="text" id='+qtyN+' name='+qtyN+' size="8"  /><p id='+pN+' ></p><hr></div>');
                var orderA="#"+orderN;
                $.ajax({
                    type: 'POST',
                    data:'supplier=' + supplier,
                    url: '../php/listeOrdre.php',
                    success: function(data) {
                        $(orderA).html(data);
                    }});
            }
        }
        ////
        function deleteE(){
            if(i>0){
                var D="#d"+i;
                $(D).remove();
                i--;
                document.getElementById('nbr').value=i;
            }
        }
        function afficheItems(ordre,item){
            var liste = document.getElementById(ordre);
            var valeur = liste.options[liste.selectedIndex].value;
            var itemA="#"+item;
            $.ajax({
                type: 'POST',
                data : 'ordre=' + valeur,
                url: '../php/listeItemsOrder.php',
                success: function(data) {
                    $(itemA).html(data);
                }});
        }
        function afficheP(oR){
            var xP=oR.substring(1);
            var iT="I"+xP;
            var liste = document.getElementById(oR);
            var orderV = liste.options[liste.selectedIndex].value;
            var liste2 = document.getElementById(iT);
            var itemV = liste2.options[liste2.selectedIndex].value;
            var pA="#p"+xP;
            $.ajax({
                type: 'POST',
                data : 'ordre=' + orderV+'&article='+itemV,
                url: '../php/itemQty.php',
                success: function(data2) {
                    $(pA).html(data2);
                }});
//alert('of');
        }
        //////
        function submitR(){
            var SHIP=document.getElementById('shipment').value;
            var dateR=document.getElementById('dateR').value;
            var liste1 = document.getElementById('four');
            var four = liste1.options[liste1.selectedIndex].value;
            if(dateR == "") {
                alert("PLZ Enter The Reception Date!!");
            }else if(four=="s") {
                alert("Select Supplier PLZ!!");
            }else if(SHIP==""){
                alert("PLZ verify the customer code !!");
            }else{
                document.formR.submit();
            }
        }
        ////////
        function afficheIDR(){
            var dateR=document.getElementById('dateR').value;
            var x=dateR.substr(5,9);
            $.ajax({
                type: 'POST',
                data : 'val=' + x,
                url: '../php/affiche_IDR.php',
                success: function(data) {
                    document.getElementById('reception').value=data;
//alert(data);
                }});
        }
        function clearZone(){
            $('#items').empty();
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

        elseif($role=="MAG2"){
            include('../menu/menuMagazin2.php');
        }
        else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <br>
        <p class="there"> Items reception </p>
        <br>
        <form  method="post"  id="formR" name="formR" action="../php/ajout_reception.php">
            <TABLE >
                <tr><Th>Reception date: </Th>
                    <td ><input type="date" size="10" name="dateR" id="dateR" onChange="afficheIDR();"/></td>
                    <th >
                        Reception ID : </th><td ><input type="text" name="reception" id="reception" size="20"  READONLY></td>
                    <td></td>
                </tr>
                <TR>
                    <TH Wcode_articleTH=150 HEIGHT=30  ALIGN="left">Supplier: </TH>
                    <TD>
			<span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
            <select name="four" id="four"  style="width:270px" class="custom-dropdown__select custom-dropdown__select--white" onChange="clearZone();" onLoad="affichelisteF();">
            </select> 
            </span>
                    </td>
                    <TH Wcode_articleTH=150 HEIGHT=30  ALIGN="left">Shipment N°: </TH>
                    <TD >
                        <input type="text" name="shipment" id="shipment"  placeholder="Shipment N°" size="20">
                    </TD>
                    <td>

                        <input type="text" size="2" name="nbr" id="nbr" style="visibility:hidden" value="0" />
                    </TD>
                </tr>
                <TR>
                    <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left" colspan="4" style="text-align:center">Items:  </TH>
                    <td>
                        <input type="button" onclick="add();" id="submitbutton" value="+">
                        <input type="button" onclick="deleteE();" id="submitbutton" value="-">
                    </td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align:center">

                        <div id="items"></div>
                    </td>
                </tr>
                <tr><th colspan="4"></th><td>  <input type="button" onclick="submitR();" id="submitbutton" value="Submit >>"> </td></tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>