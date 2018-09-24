<?php 
session_start();
 $IDoperateur=$_SESSION['userID'];
 include('../connexion/connexionDB.php');
 $sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
 $magazigner=mysql_result($sqlOP,0);

$reception=$_POST['IDreception'];
$nbr=$_POST['nbr'];

$j=0;
$v1=1;
if(isset($_POST['pal'])){
$pal=$_POST['pal'];
$sql=mysql_query("UPDATE article1 SET stock=stock+'$pal' WHERE code_article='PAL'");
}
while($nbr>$j){
	
	$j++;
	$ord="O".$j;
	$ar="ar".$j;
	$qtr="qtr".$j;
	$paq="paq".$j;
	$suit="suite".$j;
	$bat="batch".$j;
	$ordre=$_POST[$ord];
	$article=$_POST[$ar];
	$qty=$_POST[$qtr];
	$paquet=$_POST[$paq];
	$suite=$_POST[$suit];
	$batch=@$_POST[$bat];
	
//definir type produit 
$sqT=mysql_query("select catA from article1 where code_article='$article'");
$catA=mysql_result($sqT,0);	

 
 //mise a jour du stock
$sql3=mysql_query("UPDATE article1 SET stock=stock+'$qty' WHERE code_article='$article'");
//update de nbre paquet reception article
$sql3=mysql_query("UPDATE reception_items SET box='$paquet', status='received' WHERE item='$article' AND IDreception='$reception' AND IDorder='$ordre'");

//Mise a jour de l'ordre d'achat
$sql7=mysql_query("UPDATE ordre_achat_article1 SET qte_recue=qte_recue+'$qty' WHERE IDarticle='$article' and IDordre='$ordre'");
//verification

$sq1=mysql_query("select qte_recue from ordre_achat_article1 where IDarticle='$article' and IDordre='$ordre'");
$qterR=mysql_result($sq1,0);
$sq1=mysql_query("select qte_demande from ordre_achat_article1 where IDarticle='$article' and IDordre='$ordre'");
$qtedD=mysql_result($sq1,0);
if($qtedD > $qterR){
$sql61=mysql_query("UPDATE ordre_achat_article1 SET statut='incomplete',dateR=NOW() WHERE IDordre='$ordre' and IDarticle='$article'");
	
}else{
	$sql61=mysql_query("UPDATE ordre_achat_article1 SET statut='received',dateR=NOW() WHERE IDordre='$ordre' and IDarticle='$article'");
	
}
$sq1=mysql_query("select IDordre from ordre_achat_article1 where IDordre='$ordre' and ((statut='waiting') or (statut='incomplete'))");
$nbrR=mysql_num_rows($sq1);
if($nbrR==0){
	$sql61=mysql_query("UPDATE ordre_achat2 SET statut='received' WHERE IDordre='$ordre' ");
}
else{
	$sql61=mysql_query("UPDATE ordre_achat2 SET statut='incomplete' WHERE IDordre='$ordre' ");
}


if($catA=="Production"){
//definir le paquets

///Cas  1 ==> batch multiple
if(isset($_POST[$bat])==false){

if($paquet==1){
  $i=1;
  $codeP="codeP".$j.$i;
  $batchP="batchP".$j.$i;

 $idpaq=$_POST[$codeP]; 
 $batch1=$_POST[$batchP]; 
 $sql4=mysql_query("INSERT INTO paquet2(IDpaquet,idRO,IDarticle,qte_def,qte_res,batch) VALUES ('$idpaq','$reception','$article','$qty','$qty','$batch1')");	
}
else if($suite==0){
$qtpd=$qty/$paquet;
for ($i=1;$i<$paquet+1;$i++){
  $codeP="codeP".$j.$i;
  $batchP="batchP".$j.$i;
 $idpaq=$_POST[$codeP]; 
 $batch1=$_POST[$batchP]; 
 $sql4=mysql_query("INSERT INTO paquet2(IDpaquet,idRO,IDarticle,qte_def,qte_res,batch) VALUES ('$idpaq','$reception','$article','$qtpd','$qtpd','$batch1')");	
}
}
else{
$qtpd=($qty-$suite)/($paquet-1);
for ($i=1;$i<$paquet;$i++){
 $codeP="codeP".$j.$i;
  $batchP="batchP".$j.$i;

 $idpaq=$_POST[$codeP]; 
 $batch1=$_POST[$batchP]; 
 $sql4=mysql_query("INSERT INTO paquet2(IDpaquet,idRO,IDarticle, qte_def, qte_res,batch) VALUES ('$idpaq','$reception','$article','$qtpd','$qtpd','$batch1')");	
}
//$i++;
  $codeP="codeP".$j.$i;
  $batchP="batchP".$j.$i;

 $idpaq=$_POST[$codeP]; 
 $batch1=$_POST[$batchP]; 
 $sql5=mysql_query("INSERT INTO paquet2(IDpaquet,idRO,IDarticle, qte_def, qte_res,batch) VALUES ('$idpaq','$reception','$article','$suite','$suite','$batch1')");		
}
}
////cas 2 ==> un seul batch 
else{

if($paquet==1){

 $idpaq=$article."/".$reception."/".$j."-1"; 
 $sql4=mysql_query("INSERT INTO paquet2(IDpaquet,idRO,IDarticle,qte_def,qte_res,batch) VALUES ('$idpaq','$reception','$article','$qty','$qty','$batch')");	
}
else if($suite==0){
$qtpd=$qty/$paquet;
for ($i=1;$i<$paquet+1;$i++){
 $idpaq=$article."/".$reception."/".$j."-".$i; 
 $sql4=mysql_query("INSERT INTO paquet2(IDpaquet,idRO,IDarticle,qte_def,qte_res,batch) VALUES ('$idpaq','$reception','$article','$qtpd','$qtpd','$batch')");	
}
}
else{
$qtpd=($qty-$suite)/($paquet-1);
for ($i=1;$i<$paquet;$i++){
 $idpaq=$article."/".$reception."/".$j."-".$i; 
 $sql4=mysql_query("INSERT INTO paquet2(IDpaquet,idRO,IDarticle, qte_def, qte_res,batch) VALUES ('$idpaq','$reception','$article','$qtpd','$qtpd','$batch')");	
}
//$i++;
$idpaq=$article."/".$reception."/".$j."-".$i; 
 $sql5=mysql_query("INSERT INTO paquet2(IDpaquet,idRO,IDarticle, qte_def, qte_res,batch) VALUES ('$idpaq','$reception','$article','$suite','$suite','$batch')");	

}
 //fin definir paquets
 }
}

}
//update statut reception
$sql6=mysql_query("UPDATE reception  SET dateES=NOW(),status='received',storekeeper='$magazigner' WHERE IDreception='$reception'");
//Notification
$msg= " Vous avez une nouvelle reception de stock <br> ID reception :  <b>".$reception."</b>";
  $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$user','FIN','$msg',NOW(),'msg')");
  $sql4=mysql_query("INSERT INTO notification(emetteur, destinataire, message, dateN,chemin) VALUES ('$user','COM','$msg',NOW(),'msg')");

  $msg="a entrée le stock de la reception N° <b>".$reception."</b>";
$HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$IDoperateur','$msg','reception/stock','$reception',NOW())");   
header('Location: ../pages/ajout_stock.php?status=sent');

?>