 <?php
    session_start();
	$userID=$_SESSION['userID'];
    include('../connexion/connexionDB.php');
    $IDrelance=$_POST['IDrelance']; 
   
	$req= "SELECT * FROM sortie_items where IDbande='$IDrelance' and typeS='RL'";
   
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_array($r)){	  
		$idSI=$a['IDsortie'];
		$IDpaq=$a['IDpaquet'];		
		$qte=$a['qte'];		
		$up1= mysql_query("UPDATE sortie_items SET statut='C' where IDsortie='$idSI'");	
		$up2= mysql_query("UPDATE paquet2 SET qte_res= qte_res-'$qte',qte_att=qte_att-'$qte' where IDpaquet='$IDpaq'");	
		$up3= mysql_query("UPDATE article1 SET stock= stock-'$qte' where code_article=(SELECT IDarticle FROM paquet2 where IDpaquet='$IDpaq')");														
    }
	$up4= mysql_query("UPDATE bande_relance SET statut='CT',dateCT=NOW(),IDcontroleur='$userID' where IDrelance='$IDrelance'");	
	$msg=" a confirmé la sortie bande relance  <b> ".$IDrelance." </b> ";
	$HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userID','$msg','bande_relance','$IDrelance',NOW())"); 
    mysql_close();


  ?>