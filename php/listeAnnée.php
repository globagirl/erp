<?php
include('../connexion/connexionDB.php');
echo '<option value="s">---Select---</option>';
for($i=1970; $i<=2016; $i++)
{
    echo '<option value="'.$i.'">'.$i.'</option><br/>';
}
mysql_close();
?>