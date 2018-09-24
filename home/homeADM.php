<div class="container col-md-12" >
<div id="page-wrapper">
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">Dashboard  </h1>
    </div>
</div>

<div class="row">
<div class="col-md-12" >
<div class="panel panel-blue">
        <div class="panel-heading">
         Today is   <?php echo $date ; ?>
         <?php		$dateJ=date("Y-m-d"); ?>
         <?php
         //Notification panels
         include('../include/home/notePanel.php');
         include('../include/home/unpaidSalesPanel.php');
         include('../include/home/cmdNotShippedPanel.php');
         ?>
		 	  </div><!--Fin panel heading -->
</div><!--Fin BLUE PANEL -->
<br>
</div>

<form method="post" name="form1" id="form1" action="../php/message2.php" enctype="multipart/form-data">
<div class="row">
<?php
echo'<div class="col-md-12">';
include('../include/home/lastPayBox.php');
include('../include/home/nextPayBox.php');
include('../include/home/cmdCurrentBox.php');
include('../include/home/cmdNextBox.php');
echo '</div>';
?>
<div class="col-md-12" >				
<?php

echo '
      <div class="col-md-6">
      <div class="col-md-12">
       
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-stats"></i>
                            Production of this year
                        </div>
                        <div class="panel-body scrollDiv" id="chartQ">
						
						</div>
                    </div>
                </div>
				<div class="col-md-12">
       
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-stats"></i>
                           Profits of this year 
                        </div>
                        <div class="panel-body scrollDiv" id="chartP">
						
						</div>
                    </div>
                </div>
				
				
				<div class="col-md-12">
       
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-stats"></i>
                           Average margin per cable 
                        </div>
                        <div class="panel-body scrollDiv" id="chartAv">
						
						</div>
                    </div>
                </div>
				</div>
				 <div class="col-md-6" >
				
				'
				
				
				
				;

				

echo '<div class="col-md-12">';

?>

                <!-- /.Chat -->
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
                    </div>

 
 
<?php				

echo '<div class="col-md-12">';

?>
 <div class="panel panel-default">
 <div class="panel-heading">
  <i class="glyphicon glyphicon-user"></i>
                           My account
 </div>
  <div class="panel-body">
   <div class="form-group">
   <label>Login</label>
   <input class="form-control" id="login">   
   </div>
   <div class="form-group">
   <label>Password</label>
   <input class="form-control" type="password" placeholder="Enter your old password" id="passe1">
   </div>
   <div class="form-group">
   <label>New password</label>
   <input class="form-control" type="password" placeholder="Enter your new password" id="passe2">
   </div>
								
  </div>
 <div class="panel-footer">
 <a href="#" class="btn btn-default btn-block" onClick="updatePass();">
  <i class="glyphicon glyphicon-pencil"></i> Update
 </a>
 </div>  
 </div>
 </div>

 
  </div>
 </div>
<?php				

echo '</div>';

?> <!--Row-->
</form>
</div>
