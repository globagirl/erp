 <?php
    include('../connexion/connexionDB.php');	    
    $req= "SELECT modeT,ref,catT,description,montant,IDtrans,compte FROM transaction_compte WHERE  verif ='Y' and typeT='RT' and modeT != 'AGIO' order by dateC DESC LIMIT 100";			
    $r=mysql_query($req) or die(mysql_error());  
    echo '<table  class="table table-fixed results" id="table3">
					    <thead style="width:100%">       
			            <tr>
						<th style="width:9.9%;height:60px;text-align:center">Mode</th>
						<th style="width:19.8%;height:60px;text-align:center">REF</th>
						<th style="width:39.8%;height:60px;text-align:center" >Catégorie</th>						
						<th style="width:19.8%;height:60px;text-align:center">Montant</th>
						<th style="width:9.8%;height:60px;text-align:center"></th>
						
						
				        </tr>
				        </thead>
			            <tbody id="tbody2"  style="width:100%" >';	
    while($a=mysql_fetch_array($r)){  
	    $IDtrans=$a['IDtrans'];
	    $compte=$a['compte'];
	    $req1= mysql_query("SELECT devise FROM compte_banque WHERE  REFcompte ='$compte'");
		$devise=mysql_result($req1,0);		
       	echo ('<tr>
		<td  style="width:10%;height:70px;text-align:center">'.$a['modeT'].'</td>
		<td  style="width:20%;height:70px;text-align:center">'.$a['ref'].'</td>
		<td  style="width:45%;height:70px;text-align:center">'.$a['catT'].' : '.$a['description'].'</td>
		<td  style="width:25%;height:70px;text-align:center">'.$a['montant'].' '.$devise.'</td>
		
		</tr>');
	}
	echo '</tbody></table>';
    mysql_close(); 
  ?>