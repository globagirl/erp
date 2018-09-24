 <?php
    
    include('../connexion/connexionDB.php');
    $PO=$_POST['PO']; 
    $statut=$_POST['statut']; 
    
	echo '<div><h5>PO : '.$PO.'</h5><h5>Statut : '.$statut.'</h5>
	<table class="table">';
	
	
	$req= "SELECT * FROM ordre_fabrication1 where PO='$PO'";    
    $r=mysql_query($req) or die(mysql_error());
    while($a=mysql_fetch_array($r)){	  
		
		echo ('<tr>
		<td style="width:35%;height:40px;"><b>OF :</b>'.$a['OF'].'</td>
		<td style="width:30%;height:40px;">'.$a['qte'].'</td>
		<td style="width:35%;height:40px;">'.$a['date_exped_conf'].'</td></tr>');
														
    }
	
	
	
	
	    echo "</table></div>";
	
    mysql_close();


  ?>