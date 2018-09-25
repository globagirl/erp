<?php
include('../connexion/connexionDB.php');
$plan=@$_POST['plan'];
$sq=mysql_query("select plan from  pro_assem where plan='$plan'");
if(mysql_num_rows($sq)>0)
{
    echo ("0");
}
else {
    echo ("1");
}
mysql_close();
?>