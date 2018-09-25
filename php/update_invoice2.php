<?php
include('../connexion/connexionDB.php');
$fact1 =@$_POST['fact1'];
$fact =@$_POST['fact'];
$four =@$_POST['four'];
$dateP =@$_POST['dateP'];
$dateF =@$_POST['dateF'];
$cat =@$_POST['cat'];
$typeI =@$_POST['typeI'];
$coursTND =@$_POST['coursTND'];
$devise =@$_POST['devise'];
$IDinvoice=$fact1;
$n=strpos($IDinvoice,"-");
$IDinvoice=substr($IDinvoice,$n+1);
if($fact==$IDinvoice)
    $sql1 = mysql_query("SELECT IDinvoice,supplier FROM supplier_invoice where IDinvoice LIKE '%-$fact' and supplier='$four'");
if((mysql_num_rows($sql1)>0) && ($fact != $IDinvoice)){
    // echo $fact."<br/>".$four;
    echo "1";
}else{
    if (empty($_POST['dateP'])){
        $dateP=NULL;
    }
    $sql2 = mysql_query("SELECT IDinvoice,supplier FROM supplier_invoice where IDinvoice LIKE '%-$fact'");
    $nbr=@mysql_num_rows($sql2);
    $nbr++;
    $fact=$nbr."-".$fact;
    $sql=mysql_query("UPDATE supplier_invoice SET IDinvoice='$fact',supplier='$four',dateF='$dateF',dateP='$dateP',typeI='$typeI' ,catI='$cat',currency='$devise',coursTND='$coursTND' WHERE IDinvoice='$fact1'");
    $data=mysql_fetch_array($sql1);
    $sql3=mysql_query("UPDATE invoice_files SET IDinvoice='$fact' WHERE IDinvoice='$fact1'");
    //echo $fact."<br/>".$four;
    echo "0";
}
mysql_close();
?>