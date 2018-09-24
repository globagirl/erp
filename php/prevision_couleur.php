 <?php
include('../connexion/connexionDB.php');
$num=@$_POST['num'];
$couleur=@$_POST['couleur'];
$sq=mysql_query("SELECT * FROM po_prevision where num='$num'");
$A1=mysql_fetch_object($sq);
   
    $PO=$A1->po;
    $item=$A1->item;    
    $typeP=$A1->typeP;
    $etat=$A1->etat;
    
if($typeP=="PO"){
$sql=mysql_query("Update commande2 set col='$couleur'  where PO='$PO'");

}else{
$sql=mysql_query("Update ordre_prevision set col='$couleur' where IDordre='$PO' and IDarticle='$item' and statut != 'C'");

}
echo 0;
?>