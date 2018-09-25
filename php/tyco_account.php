<?php
include('../connexion/connexionDB.php');
$week=$_POST['week'];
$Z=$_POST['Z'];
$client=$_POST['client'];
$fourArray=array();
$rq1= mysql_query("SELECT nom FROM fournisseur1 where client='$client'");
while($dataF=@mysql_fetch_array($rq1)){
    $fourArray[]="'".$dataF['nom']."'";
}
$fourListe= implode (",",$fourArray);
//echo (var_dump($fourListe));
$req= mysql_query("SELECT max(date_pay) FROM fact1 where client='$client'  and (statut='paid')");
$dernier_pay=mysql_result($req,0);
$dernier_pay2 = strtotime($dernier_pay);
$dernier_pay2= date("d- M -Y",$dernier_pay2);
echo'
  <table class="table table-fixed table-bordered results" id="table3">
<thead style="width:100%"><tr>
<th style="width:12.6%;height:60px" class="degraD2" >Day</th>
<th style="width:12.6%;height:60px" class="degraD2">Credit Notes</th>
<th style="width:14.6%;height:60px" class="degraD2">OLD Unpaid sales</th>
<th style="width:14.6%;height:60px" class="degraD2">Sales</th>
<th style="width:14.6%;height:60px" class="degraD2">OLD Unpaid purchases</th>
<th style="width:14.6%;height:60px" class="degraD2">Purchases</th>
<th style="width:14.7%;height:60px" class="degraD2">Income</th>
</tr></thead><tbody id="tbody2" style="width:100%">';
//$jour1=date('Y-m-d');
$jour = strtotime($dernier_pay);
$nextM=strtotime("next Monday",$jour);
$nextM=date('Y-m-d',$nextM);
$num = strftime("%a",$jour);
$lastM=$dernier_pay;
$req1= mysql_query("SELECT sum(tot_val) FROM fact1 where client='$client'  and (date_pay < '$lastM') and (statut='unpaid')");
$unpaid_sales=mysql_result($req1,0);
//$unpaid_sales=round($unpaid_sales);
$req31= mysql_query("SELECT sum(total) FROM supplier_invoice where supplier IN ($fourListe) and (dateP <'$lastM') and (status='unpaid') and (typeI='Purchase')");
$unpaid_purchases=@mysql_result($req31,0);
//$unpaid_purchases=round($unpaid_purchases);
$i=0;
while($nextM<=$week)
{
    $i++;
    $req2= mysql_query("SELECT sum(tot_val) FROM fact1 where client='$client' and (date_pay >'$lastM') and (date_pay <='$nextM') and (statut='unpaid')");
    $total_sales=@mysql_result($req2,0);
//$total_sales=round($total_sales);

    $req3= mysql_query("SELECT sum(total) FROM supplier_invoice where supplier IN ($fourListe) and (dateP >'$lastM') and (dateP <='$nextM') and (status='unpaid') and (typeI='Purchase')");
    $total_purchases=@mysql_result($req3,0);
//$total_purchases=round($total_purchases);
//credit notes
    $req4= mysql_query("SELECT sum(total) FROM supplier_invoice where supplier IN ($fourListe) and (dateP >'$lastM') and (dateP <='$nextM') and (status='unpaid') and (typeI LIKE 'Credit')");
    $total_credit=@mysql_result($req4,0);
    $tot_sales=$total_sales+$unpaid_sales;
    $tot_purchases=$total_purchases+$unpaid_purchases;
    $income=(($tot_sales-$tot_purchases)-$Z)+$total_credit;
//Date
    $nextM2 = strtotime($nextM);
    $nextM2= date("d- M -Y",$nextM2);
//Affichage
    $total_credit = number_format($total_credit, 2, ',', ' ');
    $total_sales = number_format($total_sales, 2, ',', ' ');
    $unpaid_sales = number_format($unpaid_sales, 2, ',', ' ');
    $total_purchases = number_format($total_purchases, 2, ',', ' ');
    $unpaid_purchases = number_format($unpaid_purchases, 2, ',', ' ');
    $income = round($income,4);
    $income2 = number_format($income, 2, ',', ' ');
    $Z = number_format($Z, 2, ',', ' ');
    echo"<tr>
<td style=\"width:12.8%;height:40px;text-align:center\" class=\"boldStyle\">".$nextM2."</td>";
    if($total_credit==0){
        echo "<td style=\"width:12.8%;height:40px;text-align:center\"> ".$total_credit."</td>";
    }else{
        echo "<td style=\"width:12.8%;height:40px;text-align:center\"  onClick=unpaid_credit('".$nextM."','".$lastM."')> ".$total_credit."</td>";
    }
    if($unpaid_sales>0){
        echo "<td style=\"width:14.8%;height:40px;text-align:center\" onClick=unpaid_sales('".$nextM."','".$lastM."')>+ ".$unpaid_sales."</td>";
    }else{
        echo "<td style=\"width:14.8%;height:40px;text-align:center\">+ ".$unpaid_sales."</td>";
    }
    echo "
<td style=\"width:14.8%;height:40px;text-align:center\" class=\"green2\" onClick=sales('".$nextM."','".$lastM."')>+ ".$total_sales."</td>";
    if($unpaid_purchases>0){
        echo "<td style=\"width:14.8%;height:40px;text-align:center\" onClick=unpaid_purchases('".$nextM."','".$lastM."')>- ".$unpaid_purchases."</td>";
    }else{
        echo "<td style=\"width:14.8%;height:40px\">- ".$unpaid_purchases."</td>";
    }
    echo "<td style=\"width:14.8%;height:40px;text-align:center\" class=\"pink\" onClick=purchases('".$nextM."','".$lastM."')>- ".$total_purchases."</td>";
    if($income>=0){
        echo "<td style=\"width:14.8%;height:40px;text-align:center\" class=\"green\">".$income2."</td></tr>";
    }else{
        echo "<td style=\"width:14.8%;height:40px;text-align:center\" class=\"red\">".$income2."</td></tr>";
    }
//
    if($income<0){
        $Z=abs($income);
    }else{
        $Z=0;
    }
    $re1=mysql_query("SELECT * FROM  payment_tyco where dateP='$nextM'");
    if(mysql_num_rows($re1)>0){
        $req=mysql_query("UPDATE payment_tyco SET reste='$income' where dateP='$nextM'");
    }else{
        $req=mysql_query("INSERT INTO payment_tyco(dateP,reste) VALUES ('$nextM','$income')");
    }
    $unpaid_purchases=0;
    $unpaid_sales=0;
    $lastM=$nextM;
    $nextM= strtotime($nextM."+7 days");
    $nextM=date('Y-m-d',$nextM);
}
echo '</tbody></table>';
mysql_close();
?>