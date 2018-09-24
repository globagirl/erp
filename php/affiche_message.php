<?php
session_start ();
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
include('../connexion/connexionDB.php');
  $req = mysql_query("SELECT * FROM message where destinataire='$userID' or emetteur='$userID' order by dateM DESC");
                            while($data=@mysql_fetch_array($req)) {
							$dest=$data['destinataire'];
							$emet=$data['emetteur'];
							if($dest !=$userID){
							//Illi b3aththom
							$sqlOP=mysql_query("select nom from users1 where ID='$dest'");
                            $nomD=@mysql_result($sqlOP,0);
							$dateM=strtotime($data['dateM']);
                           $dateM=date("j F, g:i a",$dateM);
							
							echo '  <li class="right clearfix mesLI">
                                    <span class="chat-img pull-left">
                                        <img src="../image/red.png" alt="User Avatar" width="35" height="35" class="img-circle" />
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
										<strong class="primary-font">Send to : '.$nomD.'</strong>
                                            <small class=" pull-right text-muted">
											<i class="glyphicon glyphicon-calendar"></i>
                                              '.$dateM.'</small>
                                            
                                        </div>
                                        <p>
                                           '.$data['messageText'].'
                                        </p>
										<hr>
                                    </div>
                                </li>';
							}else{
							//Illi jéw
							$sqlOP=mysql_query("select nom from users1 where ID='$emet'");
                            $nomD=@mysql_result($sqlOP,0);
							$dateM=strtotime($data['dateM']);
                            $dateM=date("j F, g:i a",$dateM);
								echo '  <li class="left clearfix mesLI">
                                    <span class="chat-img pull-left">
                                        <img src="../image/blue.png" alt="User Avatar" width="35" height="35"  class="img-circle" />
                                    </span>
                                    <div class="chat-body clearfix">
                                        <div class="header">
                                            <strong class="primary-font">'.$nomD.'</strong>
                                            <small class="pull-right text-muted">
                                                <i class="glyphicon glyphicon-calendar"></i> '.$dateM.'</small>
                                        </div>
                                        <p>
                                            '.$data['messageText'].'
                                        </p>
                                    </div>
									<hr>
                                </li> ';
							}
						
							
							}
mysql_close();							
?>