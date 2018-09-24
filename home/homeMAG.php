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
		 	<?php
			$dateJ=date("Y-m-d");			
			//Les notifictions
				include('../include/home/notePanel.php');
    ?>									
		</div><!--Fin panel heading -->
</div><!--Fin BLUE PANEL -->
<br>
</div>

<form method="post" name="form1" id="form1" action="../php/message2.php" enctype="multipart/form-data">
 <div class="row">
    <div class="col-md-12">			
        <div class="col-md-6">
            <?php include('../include/home/retourPanel.php');?>	
            		
        </div>
	    <div class="col-md-6">
            <?php include('../include/home/chatPanel.php');?>	
			<?php include('../include/home/comptePanel.php');?>
        </div>
    </div>
 </div>
</form>
</div>
