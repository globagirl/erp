<div class="panel panel-default">
    <div class="panel-heading">Demande relance </div>
    <div class="panel-body">
        <table  class="table table-fixed results">
            <thead style="width:100%">
            <tr>
                <th style="width:24.9%;height:60px;text-align:center">Demander</th>
                <th style="width:24.8%;height:60px;text-align:center" >Order</th>
                <th style="width:19.8%;height:60px;text-align:center">OF</th>
                <th style="width:14.8%;height:60px;text-align:center">Defects Nbr</th>
                <th style="width:14.8%;height:60px;text-align:center"></th>
            </tr>
            </thead>
            <tbody style="width:100%" >
            <?php
                $r= mysql_query("SELECT * FROM bande_relance where statut='A'  order by IDrelance DESC ");
                while($a=mysql_fetch_array($r)){
                    $OF =$a['OF'];
                    $IDrelance=$a['IDrelance'];
                    $IDdemandeur=$a['IDdemandeur'];
                    $r1= mysql_query("SELECT PO,produit FROM ordre_fabrication1 where OF='$OF'");
                    $a1=mysql_fetch_array($r1);
                    $r2= mysql_query("SELECT nom FROM users1 where ID='$IDdemandeur'");
                    $user=mysql_result($r2,0);
                    echo("<tr><td style=\"width:25%;height:40px;text-align:center\" >".$user."</td>");
                    echo ('<td style="width:25%;height:40px;text-align:center">'.$a1['PO'].'</td>
                    <td style="width:20%;height:40px;text-align:center">'.$a['OF'].'</td>							
                    <td style="width:15%;height:40px;text-align:center">'.$a['nbr_piece'].'</td>
                    ');
                    echo "<td style=\"width:15%;height:40px;text-align:center\">
                    <input type=\"button\" onClick=afficheInfo('".$IDrelance."'); Value=\">>\"></td></tr>";
                    }
            ?>
            </tbody>
        </table>
    </div>
</div>
