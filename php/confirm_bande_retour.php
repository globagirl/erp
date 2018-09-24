 <?php
    session_start();
	$userID=$_SESSION['userID'];
    include('../connexion/connexionDB.php');
    $IDretour=$_POST['IDretour']; 
    $typeR=$_POST['typeR']; 
	//echo $typeR;
    if($typeR=="P"){//Par paquet
	$req= "SELECT * FROM bande_retour_items where IDretour='$IDretour'";    
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_array($r)){	  
		$idSI=$a['idSI'];
		$qte=$a['qte'];
		//echo $IDpaq."<br>";
		$req1= mysql_query("SELECT IDpaquet FROM sortie_items  where IDsortie='$idSI'");
        $IDpaq=mysql_result($req1,0);			
		$up1= mysql_query("UPDATE sortie_items SET qteR=qteR+'$qte' where IDsortie='$idSI'");	
		$up2= mysql_query("UPDATE paquet2 SET qte_res=qte_res+'$qte' where IDpaquet='$IDpaq'");	
		$up3= mysql_query("UPDATE article1 SET stock= stock+'$qte' where code_article=(SELECT IDarticle FROM paquet2 where IDpaquet='$IDpaq')");
														
    }
	}else{
	    $req= "SELECT IDarticle,qte FROM bande_retour_rebut where IDretour='$IDretour'"; 
		$r=mysql_query($req) or die(mysql_error());
		while($a=mysql_fetch_array($r)){	  
		$ID=$a['IDarticle'];
		$qte=$a['qte'];
		$sql2 = mysql_query("UPDATE article1 SET stock_rebut=stock_rebut+'$qte' where code_article='$ID'");
	    }
	}
	$up4= mysql_query("UPDATE bande_retour SET statut='C',operateur2='$userID',dateC=NOW() where IDretour='$IDretour'");	
	$msg=" a confirmé la bande retour  <b> ".$IDretour." </b> ";
	$HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userID','$msg','bande_retour','$IDretour',NOW())"); 
    mysql_close();


  ?>