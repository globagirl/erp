<?php

include('../connexion/connexionDB.php');
// get data from HTMP POST


	$id_box = $_POST['paq'];
	$date_recep_cmd = date('Y/m/d');

	$qtu_recu = $_POST['qtu'];

//  type mouvement
$result = mysql_query("SELECT * FROM recep_ordr_acha WHERE id_box='$id_box'");
$row = mysql_fetch_array($result);
$num_ordr = $row['num_ordr_achat'];
$code_article =  $row['code_article'];
$date=date('Y/m/d');
$type="sortie_non_pl";
$qtu_actuel = $row['qtu_box'];
$new_qtu = $qtu_actuel-$qtu_recu;
if(empty($row))
{
echo(0);
}
else
{
if ($new_qtu < 0)
{
$qtu=0;
$sql = "UPDATE recep_ordr_acha SET qtu_box='$qtu', date_modification='$date_recep_cmd' WHERE id_box='$id_box' ";
 
if (!mysql_query($sql)) {
die('Error: ' . mysql_error());}
echo($new_qtu);
$mouv = "INSERT INTO mouvement_stock (num_ordr_acha, code_article, qtu_cmd, date_modification, type_mouvement) VALUES ('$num_ordr', '$code_article', '$qtu_actuel', '$date', '$type')";
mysql_query($mouv);
}
else
{
$sql2 = "UPDATE recep_ordr_acha SET qtu_box='$new_qtu', date_modification='$date_recep_cmd' WHERE id_box='$id_box' ";
if (!mysql_query($sql2)) {
die('Error: ' . mysql_error());
}
$mouv = "INSERT INTO mouvement_stock (num_ordr_acha, code_article, qtu_cmd, date_modification, type_mouvement) VALUES ('$num_ordr', '$code_article', '$qtu_recu', '$date', '$type')";
mysql_query($mouv);

echo(1);

}
}


?>