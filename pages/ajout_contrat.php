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
        Contract
    </title>
    <script>
        var i=1;
        ////////////////////////LISTE LIKE GOOGLE :) /////////////
        function autoComplete(c,l){
            var liste = document.getElementById('recherche');
            var R = liste.options[liste.selectedIndex].value;
            var zoneC="#"+c;
            var zoneL="#"+l;
            var min_length =1;
            var keyword = $(zoneC).val();
            if (keyword.length >= min_length) {

                $.ajax({
                    url: '../php/auto_liste_personnel.php',
                    type: 'POST',
                    data: "val="+keyword+"&Z="+zoneC+"&R="+R,
                    success:function(data){
                        $(zoneL).show();
                        $(zoneL).html(data);
                    }});
            }else {
                $(zoneL).hide();
            }
        }
        ///
        function hideListe(l) {
            var zoneL="#"+l;
            $(zoneL).hide();
        }
        function choixListe(p,z) {
            var ch=p.replace("|"," ");
            ch=ch.replace("|"," ");
            ch=ch.replace("|"," ");
            $(z).val(ch);
        }
        ////////////////////////////////////FIN///////////////
        function pop_up(url){
            window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no')
        }
        function addContrat(){
            var liste = document.getElementById('recherche');
            var R = liste.options[liste.selectedIndex].value;
            var liste2 = document.getElementById('contratT');
            var val = liste2.options[liste2.selectedIndex].value;
            var contratID = document.getElementById('IDcontrat').value;
            var date1 = document.getElementById('date1').value;
            var date2 = document.getElementById('date2').value;
            if(date1=="" ||date2=="" ){
                alert("PLZ Enter the Date !! ");
            } else if(val=="s"){
                alert("PLZ Enter Contract Type !!");
            }else if(contratID==""){
                alert("PLZ Enter the Contract N° !! ");
            }
            else{
                document.getElementById('form1').submit();
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
        elseif($role=="GRH"){
            include('../menu/menuGRH.php');
        }
        else{
            session_unset();
            session_destroy();
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <!-- began -->
        <BR>
        <p class="there">Contract</p>
        <br>
        <!-- end -->
        <?php
        include('../connexion/connexionDB.php');
        ?>
        <form method="post"  id="form1" action="../php/ajout_contrat.php">
            <table>
                <tr>
                    <th>Society: </th>
                    <td>
                        <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                            <select name="comp" id="comp"  class="custom-dropdown__select custom-dropdown__select--white">
                                <option value="STARZ">STARZ</option>
                                <option value="SESI">SESI</option>
                            </select>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th >Contract N°: </th>
                    <td>
                        <?php
                        $req=mysql_query("SELECT count(numContrat) FROM personnel_contrat where numContrat LIKE 'C%'");
                        $nbr=@mysql_result($req,0);
                        $nbr++;
                        if($nbr<10){
                            $IDC="C00".$nbr;
                        }else if($nbr<100){
                            $IDC="C0".$nbr;
                        }else{
                            $IDC="C".$nbr;
                        }
                        ?>
                        <input type="text" name="IDcontrat"  id="IDcontrat" size="18" value="<?php echo $IDC;?>" >
                    </td>
                </tr>
                <TR>
                    <Th > Contract Type: </Th>
                    <td>
                         <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                            <select name="contratT" id="contratT"  class="custom-dropdown__select custom-dropdown__select--white">
                                <option value="s">---Selct---</option>
                                <option value="SIVP">SIVP</option>
                                <option value="CDI">CDI</option>
                                <option value="CDD">CDD</option>
                                <option value="CIAP">CIAP</option>
                                <option value="Apprentissage">Learning</option>
                            </select>
                        </span>
                    </td>
                </TR>
                <TR>
                    <Th >Date: </Th>
                    <TD>
                        <b>Du</b>
                        <input type="date" name="date1"  id="date1"  >
                        <b> Au </b>
                        <input type="date" name="date2"  id="date2"  >
                    </TD>
                </TR>

                <TR>
                    <TH>Employee: </th>
                    <td>
                        <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                            <select name="recherche" id="recherche" type="text" class="custom-dropdown__select custom-dropdown__select--white">
                                <option value="nom">Name</option>
                                <option value="matricule">Registration Number</option>
                                <option value="NCIN">ID card N°</option>
                            </select>
                         </span>
                    </Td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="text" id="P1" name="P1" size="25" onBlur="hideListe('listeP1');" onKeyup="autoComplete('P1','listeP1'); " onFocus="autoComplete('P1','listeP1')">
                        <div class="divAuto2"><ul id="listeP1" ></ul></div>
                    </td>
                </tr>
                <tr id="TRF">
                    <td></td>
                    <td><input type="button" onclick="addContrat();" id="add1" value="Submit >> ">
                    </td></tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>