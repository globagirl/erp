<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 03/10/2018
 * Time: 11:00
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
    <script type="text/javascript" src="tablecloth/tablecloth.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css"/>
    <script src="../jquery/jquery-latest.min.js"></script>
    <script type='text/javascript' src='../jquery/menu_jquery.js'></script>
    <title>
        Inactive
    </title>
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
        }elseif($role=="DIR"){
            include('../menu/menuDirecteur.php');
        }
        else{
            header('Location: ../deny.php');
        }
        ?>
    </div>
    <div id='contenu'>
        <br>
        <p class="there">Inactive </p>
        <br>
        <form method="post" name="form1" id="form1">
            <table class="table table-fixed table-bordered results" id="table3">
               <thead style="width: 100%">
               <tr><th>Registration Number</th>
                    <th>Date</th>
                    <th>Amount</th>
                </tr>
               </thead>
                <tbody style="width: 100%">
                <?php
                include('../connexion/connexionDB.php');
                $query="SELECT * FROM personnel_avance, personnel_info WHERE personnel_avance.matricule=personnel_info.matricule AND  personnel_info.etat='inactif' ORDER BY personnel_avance.dateA DESC";
                $r=mysql_query($query);
                mysql_close();

                while($a=mysql_fetch_object($r))
                {
                    $matricule=$a->matricule;
                    $dateA=$a->dateA;
                    $montant=$a->montant;
                    echo"<tr><td>$matricule</td><td>$dateA</td><td>$montant</td></tr>";
                }
                ?>
                </tbody>
            </table>
            <div id="div1"> </div>
        </form>
    </div>
</div>
</body>
</html>

<div class="panel-body scrollDiv" id="chartQ"><img src="../pChart/img/QTY18258875692.png" alt="Print" style="cursor:pointer;"></div>