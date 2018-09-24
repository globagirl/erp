 	<?php
			//$dateJ=date("Y-m-d");
			
			//Les notifictions
			$nbrNote=0;
			echo '<div class="col-md-1 pull-right">
				  <img src="../image/notification.png" onclick="noteAffiche();" alt="Excel" style="cursor:pointer;" width="60" height="50"/>';
				  
			$sqlNote = mysql_query("SELECT count(IDnote) FROM notification where ((destinataire='$role' or destinataire='$userID') and (statut='N'))");
            $nbrNote=mysql_result($sqlNote,0);	
            if($nbrNote>0){
             echo '<div class="Xnote2" id="XnoteID" onClick="noteAffiche();">'.$nbrNote.'</div>';
             }
			echo '</div>';
?>