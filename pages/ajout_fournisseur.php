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
    <script type="text/javascript" src="tablecloth/tablecloth.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <script src="../jquery/jquery-latest.min.js"></script>
    <script type='text/javascript' src='../jquery/menu_jquery.js'></script>
    <link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
    <title>Add Supplier </title>
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
        } elseif($role=="COM"){
            include('../menu/menuCommercial.php');
        } else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <br>
        <p class="there">Add Supplier</p>
        <br>
        <!-- end -->
        <form method="post" action="../php/ajout_fournisseur.php">
            <TABLE BORDER="0">
                <TR>
                    <Th WIDTH=150 HEIGHT=30  ALIGN="left" > Supplier </Th>
                    <TD colspan="3"><input type="text" name="four" SIZE="8" MAXLENGTH="8" colspan="2"></TD>
                </TR>
                <TH Wcode_articleTH=100 HEIGHT=30  ALIGN="left">Supplier Type: </TH>
                <TD colspan=3 > <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			<select name="t" id="t" type="text" class="custom-dropdown__select custom-dropdown__select--white">
			<option value="s">---Select---</option>
			<option value="Production">Production</option>
			<option value="Service">Service</option>
            <option value="Consummable">Consumable</option>
			</select>
			</span>
                </TD>
                <TR>
                    <TH WIDTH=150 HEIGHT=30  ALIGN="left">Supplier Address:  </TH>
                    <TD><input type="text" name="adr_four" SIZE="40" ></TD>
                    <Th WIDTH=30 HEIGHT=30 ALIGN="left">Store Address:</Th>
                    <Td><input type="text" name="adr_magas" SIZE="40" ></Td>
                </TR>
                <TR>
                    <TH WIDTH=150 HEIGHT=30  ALIGN="left">Country :</TH>
                    <TD colspan="3"> <input type="text" name="pays" SIZE="30" MAXLENGTH="30"></TD>
                </TR>
                <TR>
                    <TH WIDTH=100 HEIGHT=30  ALIGN="left">Contact 1 :  </TH>
                    <TD > <input type="text" name="ctc_1"> </TD>
                    <TH WIDTH=100 HEIGHT=30  ALIGN="left">E-mail 1 :</TH>
                    <TD ><input type="text" name="mail_1" SIZE="30" MAXLENGTH="30" placeholder="exemple@serveur.com" ></TD>
                    <Th WIDTH=30 HEIGHT=30 ALIGN="left">Tel 1 :</Th>
                    <Td><input type="text" name="tel_1" SIZE="8" ></Td>
                    <Th WIDTH=30 HEIGHT=30 ALIGN="left">Fax 1 :</Th>
                    <Td><input type="text" name="fax_1" SIZE="8" ></Td>

                </TR>
                <TR>
                    <TH WIDTH=100 HEIGHT=30  ALIGN="left">Contact 2 :  </TH>
                    <TD> <input type="text" name="ctc_2"> </TD>
                    <TH WIDTH=100 HEIGHT=30  ALIGN="left">E-mail 2 :</TH>
                    <TD ><input type="text" name="mail_2" SIZE="30" MAXLENGTH="30" placeholder="exemple@serveur.com" ></TD>
                    <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Tel 2 :</Th>
                    <Td><input type="text" name="tel_2" SIZE="8" ></Td>
                    <Th WIDTH=100 HEIGHT=30  ALIGN="left"  >Fax 2 :</Th>
                    <Td><input type="text" name="fax_2" SIZE="8" ></Td>
                </TR>
            </TABLE>
            <input type="submit" id="submitbutton" value="Submit">
        </form>
    </div>
</div>
</body>
</html>