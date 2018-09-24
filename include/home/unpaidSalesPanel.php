<?php
   echo '<div class="col-md-1 pull-right">
				<img src="../image/invoiceUnpaid.png" onclick="liste_unpaid();" alt="Excel" style="cursor:pointer;" width="60" height="50"  />';
									
									
										$nbr1=0;
										$nbr2=0;
										
										$dateJ1=strtotime($dateJ."-15 days");
										$dateJ1=date('Y-m-d',$dateJ1);
										//$req1=mysql_query("SELECT * FROM fact1 where (client='TYCO2' or client='TE 3') and (date_pay <='$dateJ1') and (statut='unpaid')");
										$req1=mysql_query("SELECT count(num_fact) FROM fact1 where (date_pay <='$dateJ1') and (statut='unpaid')");
										$nbr1=mysql_result($req1,0);
										
										if($nbr1>0){
										echo '<div class="Xnote2" onClick="liste_unpaid();">'.$nbr1.'</div>';
										}
										echo '</div>';
?>