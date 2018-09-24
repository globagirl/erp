<?php
include('../connexion/connexionDB.php');
$valeur=$_POST['valeur'];
$recherche=$_POST['recherche']; 


$req= mysql_query("SELECT * FROM shipment_report  where $recherche='$valeur' order by dateE DESC LIMIT 100");  
													while($a=mysql_fetch_array($req)) {
	                                                   														
														$ship = $a['IDshipment'];
														$dateE = $a['dateE'];
														$dateC = $a['dateC'];
														$client = $a['client'];
														$nbrPal = $a['nbrPal'];
														
														$req11= mysql_query("SELECT nomClient FROM client1 where name_client='$client'");
														$clt=@mysql_result($req11,0);
														echo'<tr><td style="width:20%;height:60px;">'.$ship.'</td><td style="width:20%;height:60px;">'.$clt.'</td>
														<td style="width:20%;height:60px;">'.$dateE.'</td>
														<td style="width:20%;height:60px;">'.$dateC.'</td>
														<td style="width:15%;height:60px;">'.$nbrPal.'</td>								                       
										                
												    	</tr>';
														 echo "<td style=\"width:10%;height:60px;text-align:center\">
														<img src=\"../image/print.png\" onclick=print_ship('".$client."','".$dateE."'); style=\"cursor:pointer;\" target=\"_blank\" width=\"30\" height=\"30\"  />
														</td>
												    	</tr>";
                                                        }
																				
													

	                                                    
														mysql_close();
														?>