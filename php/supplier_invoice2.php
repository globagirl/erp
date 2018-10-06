<?php
session_start();
$IDoperateur=$_SESSION['userID'];
include('../connexion/connexionDB.php');
$invoice=@$_POST['invoice'];
$supplier=@$_POST['supplier'];
$total=@$_POST['total'];
$devise=@$_POST['devise'];
$tax=@$_POST['tax'];
$typeI=@$_POST['typeI'];
$catI=@$_POST['catI'];
$coastShip=@$_POST['coastShip'];
$coursTND=$_POST['coursTND'];
$nbrJ=@$_POST['j'];
$dateF=@$_POST['dateF'];
$dateP = strtotime($dateF."+ 60 days");
$dateP= date("Y-m-d",$dateP);
$j=0;
$invoice='-'.$invoice;
$sql2S=mysql_query("SELECT IDinvoice from supplier_invoice where IDinvoice like '%$invoice'");
$max=mysql_num_rows($sql2S);
$max++;
$IDinvoice=$max.$invoice;
//Insertion invoice
$sql1=mysql_query("INSERT INTO supplier_invoice(IDinvoice, supplier, dateE,dateF,dateP,shipCoast,tax,total,currency,coursTND, status,typeI,catI) VALUES ('$IDinvoice','$supplier',NOW(),'$dateF','$dateP','$coastShip','$tax','$total','$devise','$coursTND','unpaid','$typeI','$catI')");
///Traitement du fichier
$fichier = $_FILES['imgFact'];
for($i=0; $i<count($fichier['name']); $i++){
    $F=$fichier['name'][$i];
    //verifier existance
    $sqlF=mysql_query("SELECT * from invoice_files where nameF like '%$F'");
    $max1=mysql_num_rows($sqlF);
    $max1++;
    $fichierName=$max1.'-'.$F;
    //
    $fichier1=$fichier['tmp_name'][$i];
    $taille=filesize($fichier['tmp_name'][$i]);
    $typeF=$fichier['type'][$i];
    rename($F,$fichierName);
    $destination='../files/invoices/'.$fichierName;
    if(move_uploaded_file($fichier1,$destination)){
        $sql1=mysql_query("INSERT INTO invoice_files(nameF, typeF, sizeF, upDateF, dataF,IDinvoice) VALUES ('$fichierName','$typeF','$taille',NOW(),'$destination','$IDinvoice')");
    }else{
        echo("PLZ Contact the System Manager !!");
    }
}
//////FIN///////
while($j<$nbrJ){
    $j++;
    $recep="R".$j;
    $reception=@$_POST[$recep];
    $nbr="nbr".$j;
    $nbrI=@$_POST[$nbr];
    $i=0;
    while($i<$nbrI){
        $i++;
        $chek="ch".$i.$j;
        $ord="O".$i.$j;
        $ar="ar".$i.$j;
        $id="id".$i.$j;
        if(isset($_POST[$chek])){

            $Ord=$_POST[$ord];
            $art=$_POST[$ar];
            $idRI=$_POST[$id];
            $IDinvoiceItem=$IDinvoice."I".$i.$j;
            $sq=mysql_query("SELECT * from reception_items  where  idRI='$idRI'");
            $data2=mysql_fetch_array($sq);
            $qty=$data2['qtyBR'];
            //$idRI=$data2['idRI'];
            $sqlP=mysql_query("select prix_facture from ordre_achat_article1 where IDordre='$Ord' and IDarticle='$art'");
            $prix_unitaire=mysql_result($sqlP,0);
            $price=$qty*$prix_unitaire;
            $sqlF="INSERT INTO supplier_invoice_items(isSI,IDinvoice,IDreception ,IDitem, IDordre, qty, unit_price, price)
	   VALUES ('$IDinvoiceItem','$IDinvoice','$reception','$art','$Ord','$qty','$prix_unitaire','$price')";
            if (!mysql_query($sqlF)) {
                die('Error: ' . mysql_error());
            }else{
                //historique
                $msg= " has created the invoice N°   ".$IDinvoice."";
                $HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','Invoice','$IDinvoice',NOW())");
                //Update reception
                $sqlU=mysql_query("UPDATE reception_items SET  status='invoiced' where idRI='$idRI'");
                $sq1=mysql_query("select IDreception from reception_items where IDreception='$reception' and ((status='waiting') or (status='received'))");
                $nbrR=mysql_num_rows($sq1);
                if($nbrR==0){
                    $sql61=mysql_query("UPDATE reception SET status='invoiced' WHERE IDreception='$reception' ");
                }
            }
        }
    }
}
mysql_close();
header('Location: ../pages/supplier_invoice.php?status=sent');
?>