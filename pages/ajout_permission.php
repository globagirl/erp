<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
    $role=$_SESSION['role'];
    $userID=$_SESSION['userID'];
}
//Code vérifié
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
    <title>Permission</title>
    <script>
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
        function hideListe(l){
            var zoneL="#"+l;
            $(zoneL).hide();
        }
        //
        function choixListe(p,z) {
            var ch=p.replace("|"," ");
            var ch=ch.replace("|"," ");
            var ch=ch.replace("|"," ");
            $(z).val(ch);
        }
        ////////////////////////////////////FIN///////////////
        function addPermission(){
            var liste = document.getElementById('recherche');
            var R = liste.options[liste.selectedIndex].value;
            var dateA = document.getElementById('dateP').value;
            if(dateA==""){
                alert("selectionez une date SVP !! ");
            }else if(R=="R"){
                alert("selectionez un mode de recherche SVP  !!");
            }else{
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
        }else if($role=="GRH"){
            include('../menu/menuGRH.php');
        }else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <br>
        <p class="there">Permission</p>
        <br>
        <form method="post"  id="form1" action="../php/ajout_permission.php">
            <table>
                <tr>
                    <th>Date: </th>
                    <td><input type="date" name="dateP"  id="dateP"></td>
                </tr>
                <tr>
                    <th>Duration: </th>
                    <td><input type="text" name="nbrH"  id="nbrH" placeholder="Durée par minute"></td>
                </tr>
                <tr>
                    <th>Employee: </th>
                    <td>
                <span class="custom-dropdown custom-dropdown--white custom-dropdown--small">
			        <select name="recherche" id="recherche" type="text" class="custom-dropdown__select custom-dropdown__select--white">
					    <option value="nom">Name</option>
						<option value="matricule">Registration Number</option>
			        </select>
				</span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="text" id="P1" name="P1" size="25" onBlur="hideListe('listeP1');" onKeyup="autoComplete('P1','listeP1'); " onFocus="autoComplete('P1','listeP1')">
                        <div class="divAuto2"><ul id="listeP1" ></ul></div>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><textarea  id="message" name="message" size="10" cols="40" rows="3" placeholder="Why ?!!"></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="button" onclick="addPermission();" id="add1" value="Submit >> "></td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>
<?PHP
if(!empty($_GET['status']))
{
    $status = $_GET['status'];
    if  ($status=="sent")
    {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Permission Added Successfully \');</SCRIPT>';

    } else if ($status=="fail")
    {echo '<SCRIPT LANGUAGE="JavaScript">alert(\'Fail !! PLZ Try Again \');</SCRIPT>';}
}
?>