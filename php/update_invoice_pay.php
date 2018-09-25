<?php
include('../connexion/connexionDB.php');
$dateP =@$_POST['dateP'];
$modP =@$_POST['modP'];
$refP =@$_POST['refP'];
$compteP =@$_POST['compteP'];
$montantP =@$_POST['montantP'];
$idP =@$_POST['idP'];
$sql=mysql_query("UPDATE invoice_mode_pay SET reference='$refP',modeP='$modP',compte='$compteP',dateP='$dateP',montant='$montantP' WHERE IDmode='$idP'");
mysql_close();
?>