<?php
include('../connexion/connexionDB.php');
$PO=@$_POST['PO'];
$step=@$_POST['step'];
$PR=@$_POST['pr'];
$sq1=mysql_query("SELECT * FROM commande2 where PO='$PO'");
$s1=mysql_fetch_object($sq1);
$PR1=$s1->PR;
$dateE1=$s1->date_exped;
if($step != ""){
    $x=$PR1-$step;
    if($x>0){
        $i=$x;
        while($i<$PR1)
        {
            $N=$i+1;
            $s1=mysql_query("SELECT PO FROM commande2 where PR='$i' and date_exped='$dateE1'");
            $PO2=mysql_result($s1,0);
            $sq=mysql_query("UPDATE commande2 set PR='$N' where PO='$PO2' and PR='$i'");
            $i++;
        }
        $sq2=mysql_query("UPDATE commande2 set PR='$x' where PO='$PO'");
        echo 0;
    }else{
        echo "Verifier le nombre des pas SVP !!";
    }
}
//
else if($PR != ""){
    if(($PR>0) and ($PR<$PR1)){
        $i=$PR;
        while($i<$PR1)
        {
            $N=$i+1;
            $s1=mysql_query("SELECT PO FROM commande2 where PR='$i' and date_exped='$dateE1'");
            $PO2=mysql_result($s1,0);
            $sq=mysql_query("UPDATE commande2 set PR='$N' where PO='$PO2'");
            $i++;
        }
        $sq2=mysql_query("UPDATE commande2 set PR='$PR' where PO='$PO'");
        echo 0;
    }else{
        echo "Verifier la priorité donné SVP !!";
    }
}
?>