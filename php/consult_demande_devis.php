<?php
   include('../connexion/connexionDB.php');
   $recherche=$_POST['recherche'];
   $valeur=$_POST['valeur'];
     $req= mysql_query("SELECT * FROM demande_devis_produit where $recherche LIKE '$valeur'");
     while($a1=@mysql_fetch_array($req)){
           $IDdemande=$a1['IDdemande'];
           $req2=mysql_query("SELECT client,devise FROM demande_devis where IDdemande='$IDdemande'");
           $a2=@mysql_fetch_array($req2);
           echo'<tr><td style="width:10%;height:60px;text-align:center;">'.$IDdemande.'</td>
           <td style="width:30%;height:60px;text-align:center;">'.$a2['client'].'</td>
           <td style="width:25%;height:60px;text-align:center;">'.$a1['IDproduit'].'</td>
           <td style="width:15%;height:60px;text-align:center;">'.$a1['prixU'].'</td>
           <td style="width:10%;height:60px;text-align:center;">'.$a2['devise'].'</td>';
           echo "<td style=\"width:10%;height:60px;text-align:center\">
          <img src=\"../image/print.png\" onclick=print_demande('".$IDdemande."'); style=\"cursor:pointer;\" target=\"_blank\" width=\"30\" height=\"30\"  />
          </td>
         </tr>";
     }
mysql_close();
?>
