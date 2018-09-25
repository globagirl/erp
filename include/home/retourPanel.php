<div class="panel panel-default">
                <div class="panel-heading">Unverified Right Of Return</div>
				<div class="panel-body">
				    <table  class="table table-fixed results">
					    <thead style="width:100%">       
			            <tr>
						<th style="width:24.9%;height:60px;text-align:center">Operator</th>
						<th style="width:19.8%;height:60px;text-align:center" >Return Date </th>
						<th style="width:24.8%;height:60px;text-align:center" >Order</th>
						<th style="width:14.8%;height:60px;text-align:center" >Type</th>						
						<th style="width:14.8%;height:60px;text-align:center"></th>						
				        </tr>
						
				        </thead>
			            <tbody style="width:100%" >
						<?php
						
						$r= mysql_query("SELECT * FROM bande_retour where statut='N'  order by IDretour DESC ");
                                                                        $statut="N";
						while($a=mysql_fetch_array($r)){	
						            $IDretour =$a['IDretour'];							
							$IDop=$a['operateur1'];							
							$typeR=$a['typeR'];	
                                                                                    if($typeR=="P"){
							    $T="Par paquet";
							}else{
							    $T="Rebut";
							}							
							$r2= mysql_query("SELECT nom FROM users1 where ID='$IDop'");
							$user=mysql_result($r2,0);
							echo("<tr><td style=\"width:25%;height:60px;text-align:center\" >".$user."</td>");
							echo ('<td style="width:20%;height:60px;text-align:center">'.$a['dateR'].'</td>
							<td style="width:25%;height:60px;text-align:center">'.$a['PO'].'</td>							
							<td style="width:14%;height:60px;text-align:center">'.$T.'</td>							
							');
							echo "<td style=\"width:14%;height:60px;text-align:center\">
							<input type=\"button\" onClick=afficheInfoRT('".$IDretour."','".$typeR."'); Value=\">>\"></td></tr>";
						}
						
						?>
						</tbody>
					</table>
				</div>
            </div>