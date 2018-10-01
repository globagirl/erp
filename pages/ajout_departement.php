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
        Add Department
    </title>
</head>
<body>
<div id="entete">
    <div id="logo">
    </div>
    <div id="boton"></div>
</div>
<div id="main">
    <div id="contenu">
        <!-- began -->
        <BR>
        <p class="two">HRM</p>
        <div id="globalc">
            <div id="mbmcpebul_wrapper" style="max-width: 420px;">
                <ul id="mbmcpebul_table" class="mbmcpebul_menulist css_menu">
                    <li class="first_button"><div class="buttonbg gradient_button gradient30"><div class="arrow"><a>Employee</a></div></div>
                        <ul>
                            <li class="first_item"><a href="grh_ajout_personnel.php">Add Employee</a></li>
                            <li><a href="grh_consult_pers.php">Consult Employee</a></li>
                            <li class="last_item"><a href="grh_supp_pers.php">Delete Employee</a></li>
                        </ul></li>
                    <li><div class="buttonbg gradient_button gradient30" style="width: 108px;"><div class="arrow"><a> Quality Agent</a></div></div>
                        <ul>
                            <li class="first_item"><a href="ajout_ag_qual.php">Add Quality Agent</a></li>
                            <li><a href="grh_consult_ag_qual.php">Consult Quality Agent/a></li>
                            <li class="last_item"><a href="grh_supp_ag_qual.php">Delete Quality Agent</a></li>
                        </ul></li>
                    <li><div class="buttonbg gradient_button gradient30" style="width: 96px;"><div class="arrow"><a>Operative</a></div></div>
                        <ul>
                            <li class="first_item"><a href="ajout_ouvr.php">Add Operative</a></li>
                            <li><a href="grh_consult_ouvr.php">Consult Operative</a></li>
                            <li class="last_item"><a href="grh_supp_ouvr.php">Delete Operative</a></li>
                        </ul></li>
                    <li class="last_button"><div class="buttonbg gradient_button gradient30" style="width: 103px;"><div class="arrow"><a>Department</a></div></div>
                        <ul>
                            <li class="first_item"><a href="grh_ajout_dep.php">Add Department</a></li>
                            <li><a href="grh_consult_dep.php">Consult Department</a></li>
                            <li class="last_item"><a href="grh_supp_dep.php">Delete Department</a></li>
                        </ul></li>
                </ul>
            </div>
        </div>
        <p class="there">Add Department</p>
        <br>
        <!-- end -->
        <form method="post" action="../php/dep.php">
            <TABLE BORDER="0">
                <TR>
                    <Th WIDTH=150 HEIGHT=30  ALIGN="left" >Department ID: </Th>
                    <TD colspan="3"><input type="text" name="dep_id" SIZE="8" MAXLENGTH="8" colspan="2"></TD>
                </TR>
                <TR>
                    <TH WIDTH=150 HEIGHT=30  ALIGN="left">Name : </TH>
                    <TD colspan="3"><input type="text" name="nom" SIZE="30" MAXLENGTH="30"></TD>
                </TR>
                <TR>
                    <TH WIDTH=150 HEIGHT=30  ALIGN="left">Department boss : </TH>
                    <TD colspan="3"> <input type="text" name="chef_dep" SIZE="30" MAXLENGTH="30"></TD>
                </TR>
                <TR>
                    <TH WIDTH=100 HEIGHT=30  ALIGN="left">Operative Number : </TH>
                    // <TD colspan="3"> <input type="text" name="nbr_opr" SIZE="20"> </TD>
                </TR>
                <TR>
                    <TH WIDTH=100 HEIGHT=30  ALIGN="left">Technician Number: </TH>
                    <TD colspan="3"> <input type="text" name="nbre_tech" SIZE="20" ></TD>
                </TR>
            </TABLE>
            <input type="submit">
            <p>
            </p>
        </form>
    </div>
</div>
</body>
</html>