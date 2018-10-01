<?php
/**
 * Created by PhpStorm.
 * User: Mustapha
 * Date: 29/09/2018
 * Time: 11:52
 */
include('../connexion/connexionDB.php');
$valeur=$_POST['valeur'];
if($valeur != NULL ) {
    //affiche recherche
    $req2 = mysql_query("SELECT IDarticle, qte_demande , Date_prevue  FROM ordre_achat_article1  where IDarticle=$valeur AND Date_prevue > NOW() ORDER BY Date_prevue" );
    $s3 = mysql_query('SELECT article1.stock FROM article1, ordre_achat_article1 WHERE article1.code_article = ordre_achat_article1.IDarticle ');

    while (($a1 = @mysql_fetch_array($req2)) && ($row3 = mysql_fetch_array($s3))) {
        $sum = $row2['stock'] + $a1['qte_demande'];
        echo '<tr>';
        echo '<td style="width:15%;height:60px;text-align:center">' . $a1['IDarticle'] . '</td>';
        echo '<td style="width:15%;height:60px;text-align:center">' . $row3['stock'] . '</td>';
        echo '<td style="width:15%;height:60px;text-align:center">' . $a1['Date_prevue'] . '</td>';
        echo '<td style="width:15%;height:60px;text-align:center">' . $sum . '</td>';
        echo '</tr>';
    }

}elseif($valeur==NULL)
{
    //affiche all
    $sql =mysql_query('SELECT IDarticle, qte_demande , Date_prevue  FROM ordre_achat_article1 WHERE Date_prevue > NOW() ORDER BY Date_prevue');
    $s2=mysql_query('SELECT article1.stock FROM article1, ordre_achat_article1 WHERE article1.code_article = ordre_achat_article1.IDarticle ');
    while(($row = mysql_fetch_array($sql))&&($row2 = mysql_fetch_array($s2)) ){
        $sum=$row2['stock']+$row['qte_demande'];
        echo '<tr>';
        echo'<td style="width:15%;height:60px;text-align:center">' .$row['IDarticle'].'</td>';
        echo'<td style="width:15%;height:60px;text-align:center">'.$row2['stock'].'</td>';
        echo'<td style="width:15%;height:60px;text-align:center">' .$row['Date_prevue'].'</td>';
        echo'<td style="width:15%;height:60px;text-align:center">' . $sum .'</td>';
        echo '</tr>';
    } //pour finir la boucle
}
mysql_close();
?>
