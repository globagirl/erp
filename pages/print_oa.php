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
        Print Purchase Order
    </title>
    <script>
        function deletepo()
        {
            document.form.num_po.value="";
            document.form.num_po.style.background="#FFFFFF";
        }
        function pop_up(url){
            window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no')
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

        <!-- began -->
        <br>
        <p class="there">Print Purchase Order </p>
        <br>
        <!-- end -->
        <form name="form" method="POST" action="../tcpdf/ord_ach.php">
            <br><br>
            <p style="float:left"><img src="../image/consult.png" onclick="pop_up('../pages/pop_consult_ordre.php');" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p>
            <br>
            <table>
                <tr>
                    <th style="width:250px">Purchase Order:</th>
                    <td style="width:150px"><input  type="text" name="o_a_1" SIZE="15" placeholder="N°" ></td>
                    <td><input type="submit" value="Print >> " id="submitbutton"></td>
                </tr>
            </table>
            <br>
            <br>
        </form>
    </div>
</div>
</body>
</html>