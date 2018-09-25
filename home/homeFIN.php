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
             include('../include/home/notePanel.php');
             include('../include/home/unpaidSalesPanel.php');
            ?>
									
		</div><!--Fin panel heading -->
</div><!--Fin BLUE PANEL -->
<br>
</div>

<form method="post" name="form1" id="form1" action="../php/message2.php" enctype="multipart/form-data">
<div class="row">
    <!-- vérification et association trasaction -->
    <div class="col-md-12" >
	    <div class="col-md-8">
		    <!-- /.trans par chéque -->
            <div class="panel panel-default">
                <div class="panel-heading">Not Verified Transaction   </div>
				<div class="panel-body">
				    <table  class="table table-fixed results" id="table3">
					    <thead style="width:100%">       
			            <tr>
						<th style="width:9.9%;height:60px;text-align:center">Mode</th>
						<th style="width:11.8%;height:60px;text-align:center">REF</th>
						<th style="width:14.8%;height:60px;text-align:center">Date</th>
						<th style="width:39.8%;height:60px;text-align:center" >Category</th>
						<th style="width:14.8%;height:60px;text-align:center">Amount</th>
						<th style="width:7.8%;height:60px;text-align:center"></th>
						
						
				        </tr>
				        </thead>
			            <tbody id="tbody2"  style="width:100%" >
						</tbody>
					</table>
				</div>
				 <div class="panel-footer"><input type="button"  id="add1" value="Historic" onClick="historique_trans();" class="btn btn-danger"> </div>
            </div>
		</div>
        <div class="col-md-4">
		    <?php include('../include/home/chatPanel.php');	?>
            
        </div> 
    </div>
	<div class="col-md-12" >
	    
	    <div class="col-md-8">
		    <!-- /.Chat -->
            <?php include('../include/home/comptePanel.php');	?>
        </div>
       
    </div>
</div>
</form>
</div>
