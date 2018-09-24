<?php 
 session_start();
 $IDoperateur=$_SESSION['userID'];
 include('../connexion/connexionDB.php');
 $sqlOP=mysql_query("select nom from users1 where ID='$IDoperateur'");
 $operateur=mysql_result($sqlOP,0);

$ordre=$_POST['ordre'];
$pos1="|";
$n=strpos($ordre,$pos1);
$IDordre=substr($ordre,0,$n); //definir l'ordre
$l=strlen($ordre);
$ordre=substr($ordre,$n+1,$l); //mettre a jour la chaine
$n=strpos($ordre,$pos1);
$idRO=substr($ordre,0,$n); //definir l'id de la reception 
$l=strlen($ordre);
$ordre=substr($ordre,$n+1,$l); //mettre a jour la chaine
$n=strpos($ordre,$pos1);
$codeC=substr($ordre,0,$n); //definir le code client
$l=strlen($ordre);
$ordre=substr($ordre,$n+1,$l); //mettre a jour la chaine
$n=strpos($ordre,$pos1);
$dateR=substr($ordre,0,$n); //definir la date reception
$l=strlen($ordre);
$ordre=substr($ordre,$n+1,$l); //mettre a jour la chaine
$sql="INSERT INTO reception_ordre_achat1(idRO,IDordre,codeClient,date_recep,date_ent,operateur,statut) VALUES('$idRO','$IDordre','$codeC','$dateR',NOW(),'$operateur','waiting')";
$sql61=mysql_query("UPDATE ordre_achat2 SET statut='waitingE',date_recep=NOW() WHERE IDordre='$IDordre'");
	 if (!mysql_query($sql)) {
die('Error: ' . mysql_error()); 
   echo("../pages/reception_ordre_achat.php");
}else{ 
$l=strlen($ordre);

while($l>1){
	$pos2="*";
	$n=strpos($ordre,$pos2);
	$artOrdre=substr($ordre,0,$n); //tous les cases d'article
	$ordre=substr($ordre,$n+2,$l); //mettre a jour la chaine
	////
	$n=strpos($artOrdre,$pos1);
    $IDarticle=substr($artOrdre,0,$n); //definir l'ordre
    $l=strlen($artOrdre);
    $artOrdre=substr($artOrdre,$n+1,$l); //mettre a jour la chaine
	
	$n=strpos($artOrdre,$pos1);
    $qtd=substr($artOrdre,0,$n); //definir l'ordre
    $l=strlen($artOrdre);
    $artOrdre=substr($artOrdre,$n+1,$l); //mettre a jour la chaine
	
	$n=strpos($artOrdre,$pos1);
    $qtr=substr($artOrdre,0,$n); //definir l'ordre
    $l=strlen($artOrdre);
    $artOrdre=substr($artOrdre,$n+1,$l); //mettre a jour la chaine
	
	$l=strlen($artOrdre);
    $qte=substr($artOrdre,0,$l); //definir l'ordre
    
	$l=strlen($ordre);
	if($qte>0){
		$sql1=mysql_query("INSERT INTO reception_article_ordre(idRO,IDarticle,qte_recue) VALUES ('$idRO','$IDarticle','$qte')");
	}

}
	    echo("../pages/reception_ordre_achat.php");
	 
}  
 //echo($IDordre);

?>