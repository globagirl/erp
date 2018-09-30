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
        Add Line
    </title>
</head>
<body>
<div id="entete">
    <div id="logo">    </div>
    <div id="boton">    </div>
</div>
<div id="main">
    <div id="contenu">
        <!-- began -->
        <BR>
        <p class="two">PRODUCTION</p>
        <div id="globala">
            <div id="mbmcpebul_wrapper" style="max-width: 450px;">
                <ul id="mbmcpebul_table" class="mbmcpebul_menulist css_menu">
                    <li class="first_button"><div class="buttonbg gradient_button gradient30" style="width: 142px;"><a href="ajout_chaine.php">Add Line</a></div></li>
                    <li><div class="buttonbg gradient_button gradient30" style="width: 143px;"><a href="supp_chain.php">Delete Line</a></div></li>
                    <li class="last_button"><div class="buttonbg gradient_button gradient30" style="width: 140px;"><a href="consult_chaine.php">Consult Line</a></div></li>
                </ul>
            </div>
        </div>
        <p class="there">Add Line</p>
        <br>
        <!-- end -->
        <form method="post" action="../php/ajout_ch.php">
            <TABLE BORDER="0">
                <TR>
                    <Th WIDTH=150 HEIGHT=30  ALIGN="left" >Line ID: </Th>
                    <TD colspan="3"><input type="text" name="ch_id" SIZE="8" MAXLENGTH="8" colspan="2"></TD>
                </TR>
                <TR>
                    <TH WIDTH=150 HEIGHT=30  ALIGN="left">Name : </TH>
                    <TD colspan="3"><input type="text" name="nom" SIZE="30" MAXLENGTH="30"></TD>
                </TR>
                <TR>
                    <TH WIDTH=150 HEIGHT=30  ALIGN="left">Department : </TH>
                    <TD colspan="3"> <input type="text" name="dep" SIZE="30" MAXLENGTH="30"></TD>
                </TR>
                <TR>
                    <TH WIDTH=150 HEIGHT=30  ALIGN="left">Type : </TH>
                    <TD colspan="3"> <input type="text" name="type" SIZE="30" MAXLENGTH="30"></TD>
                </TR>
            </TABLE>
            <input type="submit" class="btn btn-default blue" value=">>">
            <p>
            </p>
        </form>
    </div>
</div>
</body>
</html>