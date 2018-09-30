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
        Absence
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
            $(z).val(ch);
        }
        ////////////////////////////////////FIN///////////////
        function addAbsence(){
            var liste = document.getElementById('recherche');
            var R = liste.options[liste.selectedIndex].value;
            var nbrH = document.getElementById('nbrH').value;
            var date1 = document.getElementById('date1').value;
            var date2 = document.getElementById('date2').value;
            var d1=date1.substr(5,2);
            var d2=date2.substr(5,2);
            if(date1=="" ||date2=="" ){
                alert("PLZ Enter a Date !! ");
            } else if(d1 != d2){
                alert("The dates of the leave must be in the same month !! PLZ insert the leave on more than one part!!");
            }else if(nbrH==""){
                alert("PLZ give the number of hours !! ");
            }
            else{
                document.getElementById('form1').submit();
            }
            /*
            alert (date1);
            alert (d2);
            */
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
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <!-- began -->
        <BR>
        <p class="there">Absence</p>
        <br>
        <!-- end -->
        <form method="post"  id="form1" action="../php/ajout_absence.php">
            <TABLE >
                <TR>
                    <Th >Date: </Th>
                    <TD colspan="2">
                        <b>Du</b>
                        <input type="date" name="date1"  id="date1"  >
                        <b> Au </b>
                        <input type="date" name="date2"  id="date2"  >
                    </TD>
                </TR>
                <TR>
                    <Th >Total Hours: </Th>
                    <TD colspan="2" >
                        <input type="text" name="nbrH"  id="nbrH" size="8" ></TD>
                    </td>
                </TR>
                <TR>
                    <TH>Employee: </th>
                    <td style="width:15px">
                    <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
                        <select name="recherche" id="recherche" type="text" class="custom-dropdown__select custom-dropdown__select--white">
                            <option value="nom">Name</option>
                            <option value="matricule">Registration number</option>
                            <option value="NCIN">ID Card N°</option>
                        </select>
                    </span>
                    </Td>
                    <td>
                        <input type="text" id="P1" name="P1" size="25" onBlur="hideListe('listeP1');" onKeyup="autoComplete('P1','listeP1'); " onFocus="autoComplete('P1','listeP1')">
                        <div class="divAuto2"><ul id="listeP1" ></ul></div>
                    </td>
                </tr>
                <TR>
                    <Td > </Td>
                    <TD colspan="2" >
                        <h5><input type="radio" name="etat" value="Non justifie" checked> Not Justified</h5>
                        <h5> <input type="radio" name="etat" value="Justifie">Justified</h5>
                        <h5> <input type="radio" name="etat" value="Certificat"> Certificate</h5>
                    </TD>
                </TR>
                <tr id="TRF">
                    <td></td>
                    <td colspan="2"><input type="button" onclick="addAbsence();" id="add1" value="Submit >> "></Td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>