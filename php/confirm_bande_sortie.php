 <?php
    session_start();
	$userID=$_SESSION['userID'];
    include('../connexion/connexionDB.php');
    $IDsortie=$_POST['IDsortie'];   
	$req= "SELECT * FROM sortie_items where IDbande='$IDsortie' and typeS='P'";   
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_array($r)){	  
		$idSI=$a['IDsortie'];
		$IDpaq=$a['IDpaquet'];		
		$rebut=$a['rebut'];		
		$qte=$a['qte'];		
		$qte=round($qte,2);		
		$up1= mysql_query("UPDATE sortie_items SET statut='C' where IDsortie='$idSI'");	
		if($rebut == "N"){
		   $up2= mysql_query("UPDATE paquet2 SET qte_res= qte_res-'$qte',qte_att=qte_att-'$qte' where IDpaquet='$IDpaq'");	
		   $up3= mysql_query("UPDATE article1 SET stock= stock-'$qte' where code_article=(SELECT IDarticle FROM paquet2 where IDpaquet='$IDpaq')");
        }else{
            $up3= mysql_query("UPDATE article1 SET stock_rebut= stock_rebut-'$qte' where code_article='$IDpaq'");
        }		
    }
	$up4= mysql_query("UPDATE bande_sortie SET statut='C',dateC=NOW(),IDcontroleur='$userID' where IDsortie='$IDsortie'");	
	$msg=" a confirmé la bande sortie  <b> ".$IDsortie." </b> ";
	$HIS=mysql_query("INSERT INTO historique(user_id,action,tab,ligne,date_heure)VALUES('$userID','$msg','bande_sortie','$IDsortie',NOW())"); 
    mysql_close();


  ?>