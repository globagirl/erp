<?php
session_start ();
include('../connexion/connexionDB.php');
// get data from HTMP POST
$login = $_POST['login'];
$pswd = $_POST['pswd'];
$tst= mysql_query ("SELECT * FROM users1 WHERE login='$login'");
$row = mysql_fetch_array ($tst);
if($login != $row['login']){
    echo 0;
}else if ($pswd != $row['pswd']){
    echo 1;
}
else if ($login==$row['login']&&$pswd==$row['pswd'])
{
    $_SESSION['userID']=$row['ID'];
    $_SESSION['role']=$row['role'];
    $_SESSION['login']=$row['login'];
    $_SESSION['userName']=$row['nom'];
    $userid=$_SESSION['userID'];
    $sql=mysql_query("INSERT INTO historique(user_id,action,date_heure)VALUES('$userid','connect',NOW())");
    $role=$row['role'];
    if ($role=='TST')
    {echo 'pages/test_pol.php';}
    else if ($role=='TSF')
    {echo 'pages/controle_fluke.php';}
    else if ($role=='DEC')
    {echo 'pages/decoupage.php';}
    else if ($role=='ASS')
    {echo 'pages/assemblage.php';}
    else if ($role=='ASS2')
    {echo 'pages/assemblage_fin.php';}
    else if ($role=='SRT')
    {echo 'pages/sertissage.php';}
    else if ($role=='EMB')
    {echo 'pages/emballage.php';}
//Compte UPM
    else if ($role=='UPM-CRI')
    {echo 'pages/upm_crimping.php';}
    else if ($role=='UPM-CUT')
    {echo 'pages/upm_cutting.php';}
    else if ($role=='UPM-MLD')
    {echo 'pages/upm_Mold.php';}
    else if ($role=='UPM-PAK')
    {echo 'pages/upm_packaging.php';}
    else if ($role=='UPM-PIN')
    {echo 'pages/upm_plug_ins.php';}
    else if ($role=='UPM-STR')
    {echo 'pages/upm_stripping.php';}
    else if ($role=='UPM-TST')
    {echo 'pages/upm_test.php';}
    else if ($role=='UPM-WSI')
    {echo 'pages/upm_ws_insertion.php';}
    else if ($role=='UPM3')
    {echo 'pages/upm_cutting_deb.php';}
    else{echo  'pages/home.php';}
}
mysql_close();
?>