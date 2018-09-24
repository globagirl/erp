<?php
include('../connexion/connexionDB.php');
$DD=$_POST['date1'];
$DF=$_POST['date2'];
 echo '<table class="table">
            <thead>
                <tr>
                    <th>Lundi</th>
                    <th>Mardi</th>
                    <th>Mercredi</th>
                    <th>Jeudi</th>
                    <th>Vendredi</th>
                    <th>Samedi</th>
                </tr>
            </thead>
            <tbody>';
 $J=0;                                       
while($DF>=$DD) 
{ 
$J++;
$nbr_def=0;
//$sql21 = mysql_query ("SELECT * FROM decoup WHERE date_debut LIKE '$DD%'");
//$sql22 = mysql_query ("SELECT * FROM pro_assem WHERE date_debut LIKE '$DD%'");
//$sql23 = mysql_query ("SELECT * FROM pro_sertiss WHERE date_debut LIKE '$DD%'");
$sql24 = mysql_query ("SELECT * FROM pro_test_pol WHERE date_debut LIKE '$DD%'");
//$sql25 = mysql_query ("SELECT * FROM pro_emb WHERE date_debut LIKE '$DD%'");
//decoup
/*
while($data21=@mysql_fetch_array($sql21)){
$qte21=$data21['q_reb'];
$nbr_def=$nbr_def+$qte21;
}
//assemblage
while($data22=@mysql_fetch_array($sql22)){
$qte22=$data22['nbr_def'];
$nbr_def=$nbr_def+$qte22;
}*/
//sertissage
/*
while($data23=@mysql_fetch_array($sql23)){
$qte23=$data23['nbr_def'];
$nbr_def=$nbr_def+$qte23;
}
*/
//Test pol
while($data24=@mysql_fetch_array($sql24)){
$qte24=$data24['nbr_def'];
$nbr_def=$nbr_def+$qte24;
}
//emballage
/*
while($data25=@mysql_fetch_array($sql25)){
$qteE=$data25['qte_e'];
$qteS=$data25['qte_s'];
$qty=$qteE-$qteS;
$nbr_def=$nbr_def+$qty;
}*/
$idJour="J".$J;
echo "<td><input class=\"inputBorder\" value=\"".$nbr_def."\" id=\"".$idJour."\" name=\"".$idJour."\" size=\"10\"></td>";

//
$dateNext= strtotime($DD."+ 1 day");

$DD= date('Y-m-d', $dateNext);

} 
if ($J<6){
while($J<6){
$J++;
$idJour="J".$J;
echo "<td><input class=\"inputBorder\" value=\"0\" id=\"".$idJour."\" name=\"".$idJour."\" size=\"10\"></td>";

}
}
echo '</tbody></table>';
mysql_close();
////
?>