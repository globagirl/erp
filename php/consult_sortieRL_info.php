 <?php
    session_start();
	$role=$_SESSION['role'];
    include('../connexion/connexionDB.php');
    $IDrelance=$_POST['IDrelance']; 
    $statut='T';
	$req= "SELECT * FROM sortie_items where IDbande='$IDrelance'";
    echo '<div><table class="table">';
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_array($r)){		
		echo ('<tr>
		<td style="width:50%;height:40px;text-align:center">'.$a['IDpaquet'].'</td>
		<td style="width:50%;height:40px;text-align:center">'.$a['qte'].'</td></tr>');
														
    }
	if(($statut=="T")and (($role=="CTRL")||($role=="ADM")) ){
	    echo "<tr><td style=\"width:50%;height:40px;text-align:center\">														
		<input type=\"button\" onClick=confirm_sortieRL('".$IDrelance."'); Value=\"Confirmer >> \" class=\"btn btn-danger\"></td></tr></table></div>";
	}else{
	    echo "</table></div>";
	}
    mysql_close();
  ?>