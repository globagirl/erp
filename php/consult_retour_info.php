 <?php
    session_start();
	$role=$_SESSION['role'];
    include('../connexion/connexionDB.php');
    $IDretour=$_POST['IDretour']; 
    $statut=$_POST['statut'];
    $typeR=$_POST['typeR'];
	echo '<div><table class="table">';
	if($typeR=="P"){
	$req= "SELECT * FROM bande_retour_items where IDretour='$IDretour'";    
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_array($r)){	  
		$idSI=$a['idSI'];
		$req1= mysql_query("SELECT IDpaquet FROM sortie_items where IDsortie='$idSI'");	
		$IDpaq=mysql_result($req1,0);
		echo ('<tr>
		<td style="width:50%;height:40px;text-align:center">'.$IDpaq.'</td>
		<td style="width:50%;height:40px;text-align:center">'.$a['qte'].'</td></tr>');
														
    }
	}else{
	$req= "SELECT * FROM bande_retour_rebut where IDretour='$IDretour'";    
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_array($r)){	
		echo ('<tr>
		<td style="width:50%;height:40px;text-align:center">'.$a['IDarticle'].'</td>
		<td style="width:50%;height:40px;text-align:center">'.$a['qte'].'</td></tr>');
														
    }
	
	}
	if(($statut=="N")and (($role=="MAG")||($role=="ADM")) ){
	    echo "<tr><td style=\"width:50%;height:40px;text-align:center\">														
		<input type=\"button\" onClick=confirmRT('".$IDretour."','".$typeR."'); Value=\"Confirmer >> \" class=\"btn btn-danger\"></td></tr></table></div>";
	}else{
	    echo "</table></div>";
	}
    mysql_close();


  ?>