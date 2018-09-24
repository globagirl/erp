  <div class="panel panel-default">
                    <div class="panel-heading">
                            <i class="glyphicon glyphicon-comment"></i>
                            Chat
                         
                    </div>
                        <!-- /.panel-heading -->
                    <div class="panel-body">
				    <div class="panel250">
                            <ul class="chat mesOL" id="listeM">                     
                          
                               
                            </ul>
					</div>
					<div class="well sm-12">
                        <input name="myfile" id="myfile" type="file">
                        <br>
                        <textarea class="form-control" rows="3" id="msg" name="msg" placeholder="Type your message here..." ></textarea>
                        <br>
                   
					    <div class="input-group">
                        <select name="des" id="D" class="form-control">
						<option value="s">---Selectionnez</option>
						<?php
						$res = mysql_query("SELECT * FROM users1 where ID != '$userID' ");
						while($data2=mysql_fetch_array($res)) {
						$nom=$data2["nom"];
						if($nom != "X"){
						echo '<option value="'.$data2["ID"].'">'.$nom.'</option><br/>'; 
						}
						}	
						
						?>		
						</select>
						<span class="input-group-btn">
						<button class="btn btn-warning btn-sm" id="btn-chat" type="button" onClick="envoiMsg();">                                        Send
						</button>
						</span>
						</div>
                    </div>
					
                    </div>
                       
                    </div>