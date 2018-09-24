<?php
   include('../connexion/connexionDB.php');
   $recherche=$_POST['recherche'];
   $valeur=$_POST['valeur'];

     $req= mysql_query("SELECT * FROM facture_echantillon_item where $recherche LIKE '$valeur'");
     while($a1=@mysql_fetch_array($req)){
           $IDdemande=$a1['IDdemande'];
             $req2=mysql_query("SELECT * FROM facture_echantillon where numFact='$IDfact'");
           $a2=@mysql_fetch_array($req2);
           echo'<tr><td style="width:10%;height:60px;text-align:center;">'.$IDfact.'</td>
           <td style="width:25%;height:60px;text-align:center;">'.$a2['client'].'</td>
           <td style="width:20%;height:60px;text-align:center;">'.$a1['IDproduit'].'</td>
           <td style="width:10%;height:60px;text-align:center;">'.$a1['qty'].'</td>
           <td style="width:8%;height:60px;text-align:center;">'.$a2['devise'].'</td>
           <td style="width:10%;height:60px;text-align:center;">'.$a2['termeP'].'</td>
           <td style="width:10%;height:60px;text-align:center;">'.$a2['montant'].'</td>
           ';
           echo "<td style=\"width:7%;height:60px;text-align:center\">
          <img src=\"../image/print.png\" onclick=print_facture('".$IDfact."'); style=\"cursor:pointer;\" target=\"_blank\" width=\"30\" height=\"30\"  />
          </td>
         </tr>";
     }
mysql_close();
?>
