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
$s11=mysql_query("SELECT max(PR) FROM commande2 where  date_exped='$dateE1'");
$max=mysql_result($s11,0);
$x=$PR1+$step;
if($x <= $max){
$i=$PR1;
while($i<$PR1)
{
$N=$i+1;
$s1=mysql_query("SELECT PO FROM commande2 where PR='$N' and date_exped='$dateE1'");
$PO2=mysql_result($s1,0);
$sq=mysql_query("UPDATE commande2 set PR='$i' where PO='$PO2' and PR='$N'");

$i++;
}
$sq2=mysql_query("UPDATE commande2 set PR='$x' where PO='$PO'");
echo 0;
}else{
echo "Verifier le nombre des pas SVP !!";
}

}

///
else if($PR != ""){
$s11=mysql_query("SELECT max(PR) FROM commande2 where  date_exped='$dateE1'");
$max=mysql_result($s11,0);
if(($PR <= $max) and ($PR > $PR1)){
$i=$PR1;
while($i<$PR)
{
$N=$i+1;
$s1=mysql_query("SELECT PO FROM commande2 where PR='$N' and date_exped='$dateE1'");
$PO2=mysql_result($s1,0);
$sq=mysql_query("UPDATE commande2 set PR='$i' where PO='$PO2'");
$i++;
}
$sq2=mysql_query("UPDATE commande2 set PR='$PR' where PO='$PO'");
echo 0;
}else{
echo "Verifier la priorité donné SVP !!";
}

}




?>