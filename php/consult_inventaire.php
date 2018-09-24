<?php
include('../connexion/connexionDB.php');
$recherche= $_POST['recherche'];
$valeur = $_POST['valeur'];
$req= mysql_query("SELECT * FROM inventaire  where $recherche='$valeur'");
while($a=mysql_fetch_array($req)){
      $ID=$a['operateur'];
      $req1= mysql_query("SELECT nom  FROM users1 where ID='$ID'");
      $operateur=mysql_result($req1,0);
      $IDinventaire=$a['IDinventaire'];
      echo ('<tr>
             <td style="width:20%;height:40px">'.$a['IDinventaire'].'</td>
            <td style="width:20%;height:40px">'.$a['dateI'].'</td>
            <td style="width:30%;height:40px">'.$operateur.'</td>
            <td style="width:20%;height:40px">'.$a['dateE'].'</td>');
      echo "<td style=\"width:10%;height:40px\">
      <input type=\"button\" onClick=afficheInfo('".$IDinventaire."'); Value=\">>\"></td>

    
      </tr>";
}
mysql_close();
?>