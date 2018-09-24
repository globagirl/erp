 <?php
    include('../connexion/connexionDB.php');	    
    $req= "SELECT modeT,ref,catT,description,montant,IDtrans,compte,etat,dateT FROM transaction_compte WHERE  verif ='N' and typeT='RT' and modeT != 'AGIO'";			
    $r=mysql_query($req) or die(mysql_error());   
    while($a=mysql_fetch_array($r)){  
	    $IDtrans=$a['IDtrans'];
	    $compte=$a['compte'];
	    $montant=$a['montant'];
	    $etat=$a['etat'];
		if($etat=='AN'){
		   $montant=0;
		}
	    $req1= mysql_query("SELECT devise FROM compte_banque WHERE  REFcompte ='$compte'");
		$devise=mysql_result($req1,0);		
       	echo ('<tr>
		<td  style="width:10%;height:70px;text-align:center">'.$a['modeT'].'</td>
		<td  style="width:12%;height:70px;text-align:center">'.$a['ref'].'</td>
		<td  style="width:15%;height:70px;text-align:center">'.$a['dateT'].'</td>
		<td  style="width:40%;height:70px;text-align:center">'.$a['catT'].' : '.$a['description'].'</td>
		<td  style="width:15%;height:70px;text-align:center">'.$montant.' '.$devise.'</td>');
		echo "<td  style=\"width:8%;height:70px;text-align:center\"><input type=\"checkbox\" id=\"".$IDtrans."\" onClick=chekTrans('".$IDtrans."')></td>
		</tr>";
	}
    mysql_close(); 
  ?>