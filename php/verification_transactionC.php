////En y travail plus avec
<?php
include('../connexion/connexionDB.php');
$req= "SELECT modeT,ref,catT,description,montant,IDtrans,compte,etat,dateT FROM transaction_compte WHERE  (((catT LIKE 'C.Scope') or (catT LIKE 'CommeScope') or (catT LIKE 'TYCO')) and (verif='N') and ((compte='STARZ EUR BNA') or (compte='STARZ EUR BIAT')))";
$r=mysql_query($req) or die(mysql_error());
while($a=mysql_fetch_array($r)){
    $IDtrans=$a['IDtrans'];
    $compte=$a['compte'];
    $montant=$a['montant'];
    $etat=$a['etat'];
    if($etat=='AN'){
        $montant=0;
    }
    $req1= mysql_query("SELECT devise FROM compte_banque WHERE  REFcompte ='$compte'");
    $devise=mysql_result($req1,0);
    echo ('<tr>
		<td  style="width:10%;height:70px;text-align:center">'.$a['modeT'].'</td>
		<td  style="width:12%;height:70px;text-align:center">'.$a['ref'].'</td>
		<td  style="width:15%;height:70px;text-align:center">'.$a['dateT'].'</td>
		<td  style="width:30%;height:70px;text-align:center">'.$a['catT'].' : '.$a['description'].'</td>
		<td  style="width:10%;height:70px;text-align:center">'.$montant.' '.$devise.'</td>
		<td  style="width:15%;height:70px;text-align:center"><b>'.$compte.'</b></td>');
    echo "<td  style=\"width:8%;height:70px;text-align:center\"><input type=\"checkbox\" id=\"".$IDtrans."\" onClick=chekTransC('".$IDtrans."')></td>
		</tr>";
}
mysql_close();
?>