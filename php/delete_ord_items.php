<?php
session_start();
include('../connexion/connexionDB.php');
$userid=$_SESSION['userID'];
$ordI=$_POST['ordI'];
$nbr=$_POST['nbr'];
if($nbr>1){
$sql=mysql_query("select * from ordre_achat_article1 where idOA='$ordI'");
$data=mysql_fetch_array($sql);

$prix=$data['prix_total'];
$ord=$data['IDordre'];
$art=$data['IDarticle'];
$sq=mysql_query("DELETE FROM  ordre_achat_article1 where idOA='$ordI'");
$sq3=mysql_query("DELETE FROM  ordre_prevision where IDordre='$ord' and IDarticle='$art'");
$sq2=mysql_query("UPDATE ordre_achat2 SET prix_total= prix_total-'$prix' WHERE  IDordre='$ord'");
echo($ordI);

//historique
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','delete','ordre_achat_article1','$ordI',NOW())");  

}else{
$sql=mysql_query("select * from ordre_achat_article1 where idOA='$ordI'");
$data=mysql_fetch_array($sql);
$art=$data['IDarticle'];
$ord=$data['IDordre'];
$sq=mysql_query("DELETE FROM ordre_achat_article1 where idOA='$ordI'");
$sq3=mysql_query("DELETE FROM  ordre_prevision where IDordre='$ord' and IDarticle='$art'");
$sq2=mysql_query("DELETE FROM ordre_achat2 WHERE IDordre='$ord'");

//Historique
$msg="a supprimé un article de 'ordre d'achat N° <b>".$ord."</b>";
$His=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userid','$msg','ordre_achat2','$ord',NOW())"); 
}
?>