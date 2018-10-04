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
        ADD PRICES
    </title>
    <script>
        var j=0;
        var i=0;
        function affiche(){
            var produit=document.getElementById('produit').value;
            if(produit=="s"){
                alert("PLZ Select Product !!");
            }
            else{
                $.ajax({
                    type: 'POST',
                    data : 'produit=' + produit ,
                    url: '../php/affiche_prix_produit.php',
                    success: function(data) {
                        var nbrI=document.getElementById("tab").rows;
                        i=nbrI.length;
                        //i=parseInt(i);
                        if(i==1){
                            $('#divA').before(data);
                            nbrI=document.getElementById("tab").rows;
                            i=nbrI.length;
                            i=i-1;
                            //document.getElementById('nbr').value=i;
                        }
                        else{
                            while(i>1){
                                $('#divA').prev().remove();
                                i--;
                            }
                            $('#divA').before(data);
                            nbrI=document.getElementById("tab").rows;
                            i=nbrI.length;
                            i=i-1;
                        }
                    }});
            }
        }
        function add(){
            var divA="#D"+i;
            i++;
            var mL="mL"+i;
            var mH="mH"+i;
            var p="P"+i;
            var D="D"+i;
            $(divA).after('<TR id='+D+'><TH >FROM</TH><td><input type="text" id='+mL+' size="8" name='+mL+'></td>' +
                '<th> TO   </th><td> <input id='+mH+' size="8" name='+mH+' type="text"></td><th> PRICE '+i+'  </th>' +
                '<td colspan=2 ><input type="text" id='+p+' name='+p+' size="8"/></td></tr>');
//alert(i);
        }
        ////
        function deleteE(){
            if(i>1){
                var D="#D"+i;
                $(D).remove();
                i=parseInt(i);
                i--;
//document.getElementById('nbr').value=i;
            }
        }
        /////
        function addP(){
            document.getElementById('nbr').value=i;
            var nbr=document.getElementById('nbr').value;
            var mHFname="mH"+nbr;
            var mLFname="mL"+nbr;
            var mLB=document.getElementById('mL1').value;
            if(mLB != "1"){
                alert("First value must be equal to 1!!");
                document.getElementById('mL1').style.backgroundColor='pink';
            }
            else{
                var j=1;
                var v=1;
                while(j<nbr && v==1){
                    var lastMHN="mH"+j;
                    var lastMH=document.getElementById(lastMHN).value;
                    lastMH=parseFloat(lastMH);
                    lastMH=lastMH+1;
                    j++;
                    var mLName="mL"+j;
                    var mHName="mH"+j;
                    var mLV=document.getElementById(mLName).value;
                    var mHV=document.getElementById(mHName).value;
                    mHV=parseFloat(mHV);
                    mLV=parseFloat(mLV);
                    if(mLV != lastMH){
                        v=0;
                        alert("PLZ verify your values !!");
                        document.getElementById(mLName).style.backgroundColor='pink';
                    }
                    else if(mHV<= mLV){
                        v=0;
                        alert("PLZ verify your values !!");
                        document.getElementById(mHName).style.backgroundColor='pink';
                    }
                }
            }
            if(nbr>1){
                var mLF=document.getElementById(mLFname).value;
                if(mHV<= mLF){
                    v=0;
                    alert("PLZ verify your values !!");
                    document.getElementById(mLFname).style.backgroundColor='pink';
                }
            }
            if(v==1){
                document.getElementById(mHFname).value="-1";
                document.forms['form1'].submit();
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

        elseif($role=="COM"){
            include('../menu/menuCommercial.php');
        }
        else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <br>
        <p class="there">ADD PRICES</p>
        <br>
        <!-- end -->
        <form  method="post"  id="form1" action="../php/ajout_prix_produit2.php">
            <hr/>
            <TABLE >
                <tr >
                    <th >ITEM ID :</th>
                    <td>
                        <select name="produit" id="produit">
                            <option value="s">---Select---</option>
                            <?php
                            $sql = "SELECT * FROM prices";
                            $res = mysql_query($sql) or exit(mysql_error());
                            while($data=mysql_fetch_array($res)) {
                                echo '<option value="'.$data["IDproduit"].'">'.$data["IDproduit"].'</option><br/>';
                            }
                            ?>
                        </select>
                    </td>
                    <td> <input type="button" onclick="affiche();" id="submitbutton" value="OK"></td>
                    <td><input type="button" onclick="add();" id="submitbutton" value="+">
                        <input type="button" onclick="deleteE();" id="submitbutton" value="-">
                        <input type="text" id="nbr" name="nbr" style="visibility:hidden" value="0" />
                    </td>
                </tr>
            </table>
            <table id="tab">
                <tr id="divA"><td></td><td colspan=6><input type="button" onclick="addP();" id="submitbutton" value="Submit >>"></td>
            </table>
    </div>
</div>
</body>
</html>