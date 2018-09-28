<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 28/09/2018
 * Time: 15:32
 */

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
        <title>Order Auto-Creation</title>
        <script>
            var V=1;
            //
            function pop_up(url){
                window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=768,height=600,directories=no,location=no')
            }
            function verifier(){
                var val=document.getElementById("fournisseur").value;
                if(val ==""){
                    alert("PLZ select a supplier !!");
                    document.getElementById('fournisseur').style.backgroundColor='pink';
                } else {
                    document.forms['form1'].submit();
                }
            }
            //
            function affichelisteC(){
                $.ajax({
                    url: '../php/listeFournisseur.php',
                    type: 'POST',
                    success:function(data){
                        $('#fournisseur').html(data);
                    }
                });
            }
        </script>
    </head>
    <body onLoad="affichelisteC();">
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
            <p class="there">Auto-Creation Purchase Order</p>
            <br>
            <br>
            <hr size=2 />
            <form method="POST"  id="form1" name="form1" action="../php/add_purchase_auto.php" enctype="multipart/form-data">
                <table>
                    <tr>
                        <th>Supplier : </th>
                        <td colspan=4 >
                            <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                                <select name="fournisseur" id="fournisseur" class="custom-dropdown__select custom-dropdown__select--white" onFocus="affichelisteC();"></select>
                            </span>
                        </td>
                    <tr>
                        <th>Currency : </th>
                        <td>
                            <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                                <select name="devise" type="text" class="custom-dropdown__select custom-dropdown__select--white">
                                    <option value="EUR">EUR</option>
                                    <?php include('../include/utile/devise.php'); ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Payment Term : </th>
                        <td>
                            <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                                <select name="tpay" id="tpay" type="text" class="custom-dropdown__select custom-dropdown__select--white">
                                <?php include('../include/utile/terme_payment.php'); ?>
                                </select>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td> </td>
                        <td>
                            <input type= "file" name="fileP" id="fileP"/>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="button" onClick="verifier();" value="Submit >> " id="submitbutton"></td>
                    </tr>
                </table>
                <hr size=2 />
                <div id="ComNote"></div>
            </form>
        </div>
    </div>
    </body>
    </html>
<?PHP
if(!empty($_GET['status']))
{
    $status = $_GET['status'];
    if  ($status=="sent"){
        echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Order added successfully  \');</SCRIPT>';
    } else if ($status=="fail"){
        echo '<SCRIPT LANGUAGE="JavaScript">alert(\'FAIL !! PLZ try again \');</SCRIPT>';
    }
}
?>