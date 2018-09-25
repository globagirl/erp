<?php
include('../connexion/connexionDB.php');
$DD=$_POST['date1'];
$DF=$_POST['date2'];
echo '<table class="table">
        <thead>
            <tr>
                <th>Monday</th>
                <th>Tuesday</th>
                <th>Wednesday</th>
                <th>Thursday</th>
                <th>Friday</th>
                <th>Saturday</th>
            </tr>
        </thead>
        <tbody>';
$J=0;
while($DF>=$DD)
{
    $J++;
    $sql25 = mysql_query ("SELECT * FROM pro_emb WHERE date_debut LIKE '$DD%'");
//emballage
    $qty=0;
    while($data25=@mysql_fetch_array($sql25)){
        $qteS=$data25['qte_e'];

        $qty=$qteS+$qty;
    }
    $idJour="J".$J;
    echo "<td><input class=\"inputBorder\" value=\"".$qty."\" name=\"".$idJour."\" size=\"10\" READONLY></td>";
//
    $dateNext= strtotime($DD."+ 1 day");
    $DD= date('Y-m-d', $dateNext);
}
if ($J<6){
    while($J<6){
        $J++;
        $idJour="J".$J;
        echo "<td><input class=\"inputBorder\" value=\"0\" id=\"".$idJour."\" size=\"10\"></td>";
    }
}
echo '</tbody></table>';
?>