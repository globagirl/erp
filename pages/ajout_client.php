<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
?>
<html>
<head>
    <meta charset="utf-8" />
    <link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript" src="tablecloth/tablecloth.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <script src="../jquery/jquery-latest.min.js"></script>
    <script type='text/javascript' src='../jquery/menu_jquery.js'></script>
    <link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
    <title>
        Add Customer
    </title>
</head>
<body>
<div id="entete">
    <div id="logo">
    </div>
    <div id="boton">
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
        <BR>
        <BR>
        <p class="there">Add Customer</p>
        <br>
        <!-- end -->
        <form method="post" action="../php/ajout_client.php">
            <TABLE BORDER="0">
                <TR>
                    <Th WIDTH=150 HEIGHT=30  ALIGN="left" >Customer </Th>
                    <TD colspan="2"><input type="text" name="clt" SIZE="8" MAXLENGTH="8"></TD>
                    <td><input type="submit" id="submitbutton">
                    </td>
                </TR>
                <TR>
                    <TH WIDTH=150 HEIGHT=30  ALIGN="left">Customer Address</TH>
                    <TD><input type="text" name="adr_clt" SIZE="40" MAXLENGTH="30"></TD>
                    <TH WIDTH=150 HEIGHT=30  ALIGN="left">Country </TH>
                    <TD colspan="3"> <input type="text" name="pays" SIZE="30" MAXLENGTH="30"></TD>
                </tr>
                <tr>
                    <Th WIDTH=30 HEIGHT=30 ALIGN="left">Delivery Address </Th>
                    <Td><input type="text" name="adr_liv" SIZE="40" ></Td>
                    <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Billing Address</Th>
                    <Td><input type="text" name="adr_fact" SIZE="40" ></Td>
                </TR>
                <TR>
                    <TH WIDTH=100 HEIGHT=30  ALIGN="left">Contact 1   </TH>
                    <TD > <input type="text" name="ctc_1"> </TD>
                    <TH WIDTH=100 HEIGHT=30  ALIGN="left">Contact 2  </TH>
                    <TD > <input type="text" name="ctc_2"> </TD>
                </tr>
                <tr>
                    <TH WIDTH=100 HEIGHT=30  ALIGN="left">E-mail 1</TH>
                    <TD ><input type="text" name="mail_1" SIZE="30" MAXLENGTH="30" placeholder="exemple@serveur.com" ></TD>

                    <TH WIDTH=100 HEIGHT=30  ALIGN="left">E-mail 2</TH>
                    <TD ><input type="text" name="mail_2" SIZE="30" MAXLENGTH="30" placeholder="exemple@serveur.com" ></TD>
                </tr>
                <tr>
                    <Th WIDTH=30 HEIGHT=30 ALIGN="left">Phone N° 1 </Th>
                    <Td><input type="text" name="tel_1" SIZE="8" ></Td>
                    <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Phone N° 2</Th>
                    <Td><input type="text" name="tel_2" SIZE="8" ></Td>
                </TR>
                <TR>
                    <Th WIDTH=30 HEIGHT=30 ALIGN="left">Fax 1 </Th>
                    <Td><input type="text" name="fax_1" SIZE="8" ></Td>
                    <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Fax 2</Th>
                    <Td><input type="text" name="fax_2" SIZE="8" ></Td>
                </TR>
            </TABLE>
        </form>
    </div>
</div>
</body>
</html>