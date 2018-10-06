<?php
session_start ();
$role=@$_SESSION['role'];
$userID=@$_SESSION['userID'];
include('../connexion/connexionDB.php');
?>
<html>
<head>
    <meta charset="utf-8" />
    <link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
    <script type="text/javascript" src="tablecloth/tablecloth.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <script src="../jquery/jquery-latest.min.js"></script>
    <script type='text/javascript' src='../jquery/menu_jquery.js'></script>
    <title>
        Assembly
    </title>
    <SCRIPT>
        function myF1(){
            var qtei=document.getElementById("qte_e");
            qtei.innerHTML="";
            var x=document.getElementById("qte_e").value;
            if((x=="") || (x<0) || (!x.match(/^(0|[1-9][0-9]*)$/))){
                qtei.value="saisi incorrect";
                qtei.style.background="#DB5776";
                return false;
            }else{
                return true;
            }
        }
        function myF2(){
            var qtei=document.getElementById("qte_s");
            qtei.innerHTML="";
            var x=document.getElementById("qte_s").value;
            if((x=="") || (x<0) || (!x.match(/^(0|[1-9][0-9]*)$/))){
                qtei.value="incorrect entry";
                qtei.style.background="#DB5776";
                return false;
            }else{
                return true;
                document.getElementById("N_D").value = document.getElementById("qte_e").value - document.getElementById("qte_s").value;
            }
        }
        function calc(){
            var qte_e=document.getElementById("qte_e").value;
            var qte_s=document.getElementById("qte_s").value;
            var qte_e = parseInt(qte_e);
            var qte_s = parseInt(qte_s);
            if(qte_e >= qte_s){
                document.getElementById("N_D").value = qte_e - qte_s;
            }else{
                alert("PLZ Check the output quantity !!");
                document.getElementById("N_D").value=0;
                document.getElementById("qte_s").value=qte_e;
            }
        }
        function a1(status){
            status=!status;
            document.pro_ass.qd1.disabled=status;
        }
        function a2(status){
            status=!status;
            document.pro_ass.qd2.disabled=status;
        }
        function a3(status){
            status=!status;
            document.pro_ass.qd3.disabled=status;
        }
        function a4(status){
            status=!status;
            document.pro_ass.qd4.disabled=status;
        }
        function a5(status){
            status=!status;
            document.pro_ass.qd5.disabled=status;
        }
        function del2(){
            document.getElementById("qte_s").value="";
            document.getElementById("qte_s").style.background="#FFF";
        }
        function affichePlan(){

            var valeur = document.getElementById("plan").value;
            if(valeur==""){
                alert("Select a plan PLZ !!");
            }
            else{
                $.ajax({
                    type: 'POST',
                    data:'plan=' +valeur,
                    url: '../php/affichePlanAs2.php',
                    success: function(data) {
                        $('#tab').html(data);
                        document.getElementById("tab2").style.visibility = "visible";

                    }});
            }
        }
    </SCRIPT>
</head>
<body onload="a1(false),a2(false),a3(false),a4(false),a5(false)">
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
        elseif($role=="ASS"){
            include('../menu/menuASS.php');
        }
        elseif($role=="PRD"){
            include('../menu/menuProduction.php');
        }
        else{
            include('../menu/menuSRT.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <br>
        <p class="there">Assemblage > End Operation</p>
        <br>
        <!-- end -->
        <form name= "pro_ass" method="post" action="../php/ajoutAssemblage2.php">
            <table>
                <tr>
                    <TH>Plan N°: </TH>
                    <td>
                        <input name="plan" id="plan" type="text" size="20" placeholder="Plan N°">
                        <input type="button" id="submitbutton" value="OK" onclick="affichePlan()"/></div>
    </td>
    </tr>
    </table>
    <table id="tab">
    </table>
    <TABLE id="tab2" style="visibility:hidden" BORDER="0">
        <TR>
            <TH ALIGN="left">Select Line : </TH>
            <TD colspan="5">
                <select name="ch_ins">
                    <?php
                    $ID_list = mysql_query("SELECT nom FROM ajout_chaine WHERE type='assemblage_cable'");

                    while ($row = mysql_fetch_array($ID_list)){
                        echo '<option value="'. $row['nom'] .'">'. $row['nom'] .'</option>';
                    }
                    ?>
                </select>
            </TD>
        </TR>
        <TR>
            <TH ALIGN="left">Clamp Operator Nbr: *</TH>
            <Td colspan=5><input type="text" name="nbr_opr" SIZE="2" ></Td>
        </TR>
        <TR>
            <TH WIDTH=150 HEIGHT=20  ALIGN="left"> Operator 1 :</TH>
            <TH WIDTH=150 HEIGHT=20  ALIGN="left"> Operator 2 :</TH>
            <TH WIDTH=150 HEIGHT=20  ALIGN="left"> Operator 3 :</TH>
            <TH WIDTH=150 HEIGHT=20  ALIGN="left"> Operator 4 :</TH>
            <TH WIDTH=150 HEIGHT=20  ALIGN="left"> Operator 5 :</TH>
            <TH WIDTH=150 HEIGHT=20  ALIGN="left"> Operator 6 :</TH>
        </tr>
        <tr>
            <TD>
                <select name="op_1">
                    <option value="s">--Select--</option>
                    <?php
                    $nom_prenom_list = mysql_query(" SELECT nom,prenom FROM ouvrier1 WHERE tache='pince' ");
                    while ($row = mysql_fetch_array($nom_prenom_list)){
                        echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
                    }
                    ?>
                </select>
            </TD>
            <TD>
                <option value="s">--Select--</option>
                <select name="op_2">
                    <?php
                    $nom_prenom_list = mysql_query(" SELECT nom,prenom FROM ouvrier1 WHERE tache='pince' ");
                    while ($row = mysql_fetch_array($nom_prenom_list)){
                        echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
                    }
                    ?>
                </select>
            </TD>
            <TD>
                <select name="op_3">
                    <option value="s">--Select--</option>
                    <?php
                    $nom_prenom_list = mysql_query(" SELECT nom,prenom FROM ouvrier1 WHERE tache='pince' ");
                    while ($row = mysql_fetch_array($nom_prenom_list)){
                        echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
                    }
                    ?>
                </select>
            </TD>
            <TD>
                <select name="op_4">
                    <option value="s">--Select--</option>
                    <?php
                    $nom_prenom_list = mysql_query(" SELECT nom,prenom FROM ouvrier1 WHERE tache='pince' ");
                    while ($row = mysql_fetch_array($nom_prenom_list)){
                        echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
                    }
                    ?>
                </select>
            </TD>
            <TD>
                <select name="op_5">
                    <option value="s">--Select--</option>
                    <?php
                    $nom_prenom_list = mysql_query(" SELECT nom,prenom FROM ouvrier1 WHERE tache='pince' ");
                    while ($row = mysql_fetch_array($nom_prenom_list)){
                        echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
                    }
                    ?>
                </select>
            </TD>
            <TD>
                <select name="op_6">
                    <option value="s">--Select--</option>
                    <?php
                    $nom_prenom_list = mysql_query(" SELECT nom,prenom FROM ouvrier1 WHERE tache='pince' ");
                    while ($row = mysql_fetch_array($nom_prenom_list)){
                        echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
                    }
                    ?>
                </select>
            </TD>
        </tr>
        <TR>
            <TH WIDTH=100 HEIGHT=30  ALIGN="left">Control Agent: *:</TH>
            <TD colspan="5">
                <select name="ag_cont">
                    <?php
                    $nom_prenom_list = mysql_query(" SELECT nom,prenom FROM agent_qual1 WHERE tache ='cont_assem' ");
                    while ($row = @mysql_fetch_array($nom_prenom_list)){
                        echo '<option value="'. $row['nom'],' '.$row ['prenom'] .'">'. $row['nom'] ,' '.$row ['prenom'] .'</option>';
                    }
                    ?>
                </select>
            </TD>
        </TR>
        <TR>
            <TH WIDTH=100 HEIGHT=30  ALIGN="left" colspan=7>Defect Type : </TH>
        <tr>
            <td> <input type="checkbox" name="option1"  id="dnd" onclick="a1(this.checked)" > Stripping <br> </td>
            <td  WIDTH=10 HEIGHT=30  ALIGN="left"><input type="text" name="denud" id= "qd1" SIZE="8" MAXLENGTH="2"> </td>
            <TD colspan="4" >

                <select name="action" >
                    <option selected="selected" value="A_C_00">CHOSE</option>
                    <option value="A_C_0">--------------</option>
                    <option value="A_C_2">Sorts</option>
                    <option value="A_C_3">Reject</option>
                    <option value="A_C_4">Reparation</option>
                </select>
            </td>
        </tr>
        <tr>
            <td> <input type="checkbox" name="option2" id="Emp_cmp" onclick="a2(this.checked)">Emplacement_cmp </td>
            <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" name="emp_cmp" id="qd2" SIZE="8" MAXLENGTH="8">  </td>
            <TD colspan="4">
                <select name="action">
                    <option selected="selected" value="A_C_1">CHOSE</option>
                    <option value="A_C_0">-----------------</option>
                    <option value="A_C_2">Sorts</option>
                    <option value="A_C_3">Reject</option>
                    <option value="A_C_4">Reparation</option>
                </select>
            </td>
        </tr>
        <tr>
            <td> <input type="checkbox" name="option3" value="Dist_pair" onclick="a3(this.checked)"> Paired Distribution<br> </td>
            <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" name="dist_p" id="qd3" SIZE="8" MAXLENGTH="8"></td>
            <TD colspan="4">
                <select name="action">
                    <option selected="selected" value="A_C_1">CHOSE</option>
                    <option value="A_C_0">-----------------</option>
                    <option value="A_C_2">Sorts</option>
                    <option value="A_C_3">Reject</option>
                    <option value="A_C_4">Reparation</option>
                </select>
            </td>
        </tr>
        <tr>
            <td> <input type="checkbox" name="option3" value="Long_Pair" onclick="a4(this.checked)"> Paired Length <br> </td>
            <td WIDTH=100 HEIGHT=30  ALIGN="left"><input type="text" name="long_p" id="qd4" SIZE="8" MAXLENGTH="8"></td>
            <TD colspan="4">

                <select name="action">
                    <option selected="selected" value="A_C_1">CHOSE</option>
                    <option value="A_C_0">-----------------</option>
                    <option value="A_C_2">Sorts</option>
                    <option value="A_C_3">Reject</option>
                    <option value="A_C_4">Reparation</option>
                </select>
            </td>
        </tr>
        <tr>
            <td> <input type="checkbox" name="option1" value="Denudage"onclick="a5(this.checked)" > Missing Accessory<br> </td>
            <td WIDTH=10 HEIGHT=30  ALIGN="left"><input type="text" name="acc_mqt" id="qd5" SIZE="8" MAXLENGTH="8"> </td>
            <TD colspan="4">
                <select name="action">
                    <option selected="selected" value="A_C_1">CHOSE</option>
                    <option value="A_C_0">-----------------</option>
                    <option value="A_C_2">Sorts</option>
                    <option value="A_C_3">Reject</option>
                    <option value="A_C_4">Reparation</option>
                </select>
            </td>
        </tr>
        <TR><td></td><td colspan=5>  <input type="submit" id="submitbutton"></td></tr>
    </TABLE>
    </FORM>
</div>
</body>
</html>