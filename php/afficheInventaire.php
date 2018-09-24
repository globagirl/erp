<?php
    session_start ();
    $userID=$_SESSION['userID'];
    include('../connexion/connexionDB.php');
    $dateI = $_POST['dateI'];
 
	echo('<div class="scrollY40"><table class="table"><tbody>');
	 
	$sql=mysql_query("SELECT IDinventaire FROM inventaire where dateI='$dateI'");
    echo('<tr><th>Article</th><th>Qte Réel </th><th>Qte Sys</th></tr>');
	if(mysql_num_rows($sql)>0){
	    $IDinventaire=mysql_result($sql,0);
	    
	    $sql1=mysql_query("SELECT IDarticle,stockSys,stockReel FROM inventaire_items where IDinventaire='$IDinventaire'");
		while($data1=mysql_fetch_array($sql1)){
		    echo('<tr><td>'.$data1['IDarticle'].'</td><td>'.$data1['stockReel'].'</td><td>'.$data1['stockSys'].'</td></tr>');
			
		}	
	}else{
        $IDinventaire="INV".$dateI;	    
	    $sql1=mysql_query("INSERT INTO inventaire(IDinventaire, dateI, dateE, operateur) VALUES ('$IDinventaire','$dateI',NOW(),'$userID')");
	}	
    echo('</tbody></table></div>');
  
?>