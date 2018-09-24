<?php
   include('../connexion/connexionDB.php');
   $compte=$_POST['compte'];

   $catT=@$_POST['catT'];

  // var_dump($typeT);
   if($catT=="s" || $catT==""){
     $req= mysql_query("SELECT * FROM transaction_compte WHERE compte='$compte' and etat != 'AN' ");
     $reqRT= mysql_query("SELECT sum(montant) FROM transaction_compte WHERE  compte='$compte' and etat != 'AN' and typeT='RT'");
     $reqRH= mysql_query("SELECT sum(montant) FROM transaction_compte WHERE  compte='$compte' and etat != 'AN' and typeT='RH'");
   }else{
     $req= mysql_query("SELECT * FROM transaction_compte WHERE compte='$compte' and catT='$catT' and etat != 'AN' ");
     $reqRT= mysql_query("SELECT sum(montant) FROM transaction_compte WHERE  compte='$compte' and etat != 'AN' and catT='$catT' and typeT='RT'");
     $reqRH= mysql_query("SELECT sum(montant) FROM transaction_compte WHERE  compte='$compte' and etat != 'AN' and catT='$catT' and typeT='RH'");
   }

 echo '<table  class="table table-fixed results" id="table3">
       <thead style="width:100%">
          <tr>
           <th style="width:14.8%;height:60px;text-align:center">Date</th>
           <th style="width:14.8%;height:60px;text-align:center">Mode</th>
           <th style="width:14.8%;height:60px;text-align:center" >Reference</th>
           <th style="width:24.8%;height:60px;text-align:center">Description</th>
           <th style="width:14.8%;height:60px;text-align:center">Debit</th>
           <th style="width:14.8%;height:60px;text-align:center">Crédit</th>

           </tr>
       </thead>
     <tbody id="tbody" style="width:100%">';
   $col="black";
 //Les en attente
  while($a2=mysql_fetch_array($req)){
    $typeT=$a2['typeT'];
    $montant=$a2['montant'];
     echo ('<tr>
   <td  style="width:15%;height:60px;text-align:center">'.$a2['dateT'].'</td>
   <td  style="width:15%;height:60px;text-align:center"><b>'.$a2['modeT'].'</b></td>
   <td style="width:15%;height:60px;text-align:center">'.$a2['ref'].'</td>
   <td style="width:25%;height:60px;text-align:center">'.$a2['catT'].' : '.$a2['description'].'</td>');
   if($typeT=="RT"){
   echo "<td style=\"width:15%;height:60px;text-align:center\"><b>-</b>".$montant."</td>
   <td style=\"width:15%;height:60px;text-align:center\">--</td></tr>";
   }else{
   echo "<td style=\"width:15%;height:60px;text-align:center\">--</td>
   <td style=\"width:15%;height:60px;text-align:center\"><b>+</b>".$montant."</td></tr>";
   }



   }
 $totalRT=@mysql_result($reqRT,0);
 $totalRH=@mysql_result($reqRH,0);
 $totalRH=round($totalRH,3);
 $totalRT=round($totalRT,3);
 //
 echo '<tr><td style=\"width:30%;height:60px;text-align:center\"></td>
      <td style="width:10%;height:60px;text-align:center"> </td>

      <td style="width:30%;height:60px;text-align:center"><b>Total retrait : '.$totalRT.'</b></td>
      <td style="width:30%;height:60px;text-align:center"><b>Total recharge : '.$totalRH.'</b></td></tr>
      </tbody></table>';

mysql_close();
 ?>
