<div class="panel panel-default">
                <div class="panel-heading">Bande sortie non confirmé </div>
				<div class="panel-body">
				    <table  class="table table-fixed results">
					    <thead style="width:100%">       
			            <tr>
						<th style="width:24.9%;height:60px;text-align:center">Operateur</th>
						<th style="width:17.8%;height:60px;text-align:center" >Date sortie</th>
						<th style="width:24.8%;height:60px;text-align:center" >Commande</th>						
						<th style="width:19.8%;height:60px;text-align:center" >OF</th>						
						<th style="width:11.8%;height:60px;text-align:center"></th>						
				        </tr>
						
				        </thead>
			            <tbody style="width:100%" >
						<?php						
						$r= mysql_query("SELECT * FROM bande_sortie where statut='N'");
						while($a=mysql_fetch_array($r)){	
						    $IDsortie =$a['IDsortie'];							
							$IDop=$a['IDoperateur'];							
							$OF=$a['OF'];	
							$Stat='N';						
							$r2= mysql_query("SELECT nom FROM users1 where ID='$IDop'");
							$user=mysql_result($r2,0);
							$r3= mysql_query("SELECT PO FROM ordre_fabrication1 where OF='$OF'");
							$PO=mysql_result($r3,0);
							echo("<tr><td style=\"width:25%;height:40px;text-align:center\" >".$user."</td>");
							echo ('<td style="width:18%;height:40px;text-align:center">'.$a['dateS'].'</td>													
							<td style="width:25%;height:40px;text-align:center">'.$PO.'</td>							
							<td style="width:20%;height:40px;text-align:center">'.$OF.'</td>							
							');
							echo "<td style=\"width:12%;height:40px;text-align:center\">
							<input type=\"button\" onClick=afficheInfoS('".$IDsortie."','".$Stat."'); Value=\">>\"></td></tr>";
						}						
						?>
						</tbody>
					</table>
				</div>
            </div>