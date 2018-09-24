<?php
include('../connexion/connexionDB.php');
/*
$sql = mysql_query("SELECT * FROM supplier_invoice");
while($data=mysql_fetch_array($sql)){
$dateP=$data['dateP'];
$stat=$data['status'];
$inv=$data['IDinvoice'];
if($stat=="paid"){
    $modeP=$data['mode_pay'];
    if(($modeP != "")&& ($modeP != "Cheque") && ($modeP != "Virement")){
      $sql1=mysql_query("INSERT INTO invoice_mode_pay(modeP,dateP, num_invoice) VALUES ('$modeP','$dateP','$inv')");
    }else if($modeP != ""){
      $sql1=mysql_query("UPDATE invoice_mode_pay SET dateP='$dateP' WHERE num_invoice='$inv'");
    }
}
}
*/
///////////////////////
/*
$sql = mysql_query("SELECT * FROM sortie_stock1 where OF IS NOT NULL");
while($data=mysql_fetch_array($sql)){
$OF=$data['OF'];
$PO=$data['commande'];
$dateS=$data['date_sortie'];
$pak=$data['IDpaquet'];
$qte=$data['qte'];
$op=44;
$id="SP".$OF;
$sql3 = mysql_query("SELECT IDsortie,dateS FROM bande_sortie where IDsortie='$id'");
if(mysql_num_rows($sql3)>0){
   $sql2=mysql_query("INSERT INTO sortie_items(IDbande,IDpaquet, qte,typeS,statut) VALUES ('$id','$pak','$qte','P','C')");
}else{
   $sql1=mysql_query("INSERT INTO bande_sortie(IDsortie, dateS, dateC, IDoperateur, IDcontroleur, OF,PO, statut) VALUES ('$id','$dateS','$dateS','$op','$op','$OF','$PO','C')");
   $sql2=mysql_query("INSERT INTO sortie_items(IDbande,IDpaquet, qte,typeS,statut) VALUES ('$id','$pak','$qte','P','C')");
}
}
*/
mysql_close();
?>
