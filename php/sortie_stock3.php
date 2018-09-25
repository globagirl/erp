<?php
session_start();
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$PO = $_POST['PO'];
$OF = $_POST['OF'];
$PRD = $_POST['PRD'];
$nbr = $_POST['nbr'];
$typeS = $_POST['typeS'];
//
$sqlPO=mysql_query("SELECT PO,statut from commande_items where POitem='$PO'");
$dataPO=mysql_fetch_array($sqlPO);
$PO1=$dataPO['PO'];
$stat=$dataPO['statut'];
//Sortie pour production vs relance
if($typeS=="P"){
    $ID="SP".$OF;
    $sql1="INSERT INTO bande_sortie(IDsortie, dateS,dateC, IDoperateur,IDcontroleur, OF,PO,statut) VALUES ('$ID',NOW(),NOW(),'$IDoperateur','$IDoperateur','$OF','$PO','C')";
}else{
    $sql=mysql_query("SELECT IDrelance from bande_relance where OF='$OF' and statut='C'");
    $ID=mysql_result($sql,0);
    $sql1="UPDATE bande_relance SET statut='T',IDoperateur='$IDoperateur',dateS=NOW() where IDrelance='$ID'";
}
//traitement
if (!mysql_query($sql1)) {
    die('Error: ' . mysql_error());
}else{
    while($nbr>$i){
        $i++;
        $A="A".$i;
        $P="P".$i;
        $Q="Q".$i;
        $vA = $_POST[$A];
        $vP = $_POST[$P];
        $vQ = $_POST[$Q];
        $vQ=round($vQ,2);
        if($vP != "R"){	// n est pas une sortie de rebut
            $sql2=mysql_query("INSERT INTO sortie_items(IDbande, IDpaquet, qte, typeS) VALUES ('$ID','$vP','$vQ','$typeS')");
            //$sql3=mysql_query("UPDATE paquet2 SET qte_att=qte_att+'$vQ where IDpaquet='$vP'");//Pas de phase de confirmation
            $sql3=mysql_query("SELECT qte_res from paquet2 where IDpaquet='$vP'");
            $qteRes=@mysql_result($sql3,0);
            $qteRes=$qteRes-$vQ;
            $qteRes=round($qteRes,3);
            $sql3=mysql_query("UPDATE paquet2 SET qte_res=$qteRes where IDpaquet='$vP'");
            $sql4=mysql_query("UPDATE article1 SET stock= stock-'$vQ' where code_article='$vA'");
        }else{
            $sql2=mysql_query("INSERT INTO sortie_items(IDbande, IDpaquet, qte, typeS,rebut) VALUES ('$ID','$vA','$vQ','$typeS','Y')");$up3= mysql_query("UPDATE article1 SET stock_rebut= stock_rebut-'$qte' where code_article='$IDpaq'");
        }
        $msg=" a saisie la sortie de <b> ".$vQ." </b> du paquet N°  <b>".$vP."</b> ID sortie ".$ID;
        $HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','bande_sortie','$vP',NOW())");
    }
}
if($stat=="incomplete"){
    $statut="incomplete";
}else{
    $statut="in progres";
}
if($typeS=="P"){
    $sq =mysql_query("UPDATE commande_items SET statut='$statut'  where POitem='$PO'");
    $sq1 =mysql_query("UPDATE ordre_fabrication1 SET statut='in progres' where OF='$OF'");
    $sq2 =mysql_query("UPDATE plan1 SET statut='waiting' where OF='$OF'");
}
//
mysql_close();
header('Location: ../pages/sortie_stock3.php?status=sent');
?>