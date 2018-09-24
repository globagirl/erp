
 <?php
 include('../connexion/connexionDB.php');

$id_box=$_POST['id_box'];
$req01 = "SELECT * FROM emb_carton WHERE code_carton='$id_box'";
$result01 = mysql_query($req01);
$row01 = mysql_fetch_array($result01);
if(empty($row01))
{
echo(01);
}	
else
{
$qtu=$row01['num_po'];
echo ($qtu);
 } 
?>
