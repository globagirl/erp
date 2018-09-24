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
      include('../include/home/unpaidSalesPanel.php');
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
 <div class="col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
        <i class="glyphicon glyphicon-stats"></i>Production of this year
    </div>
    <div class="panel-body scrollDiv" id="chartQ">
    </div>
  </div>
<!--  <div class="panel panel-default ">
      <div class="panel-heading">
          <i class="glyphicon glyphicon-stats"></i>Profits of this year
      </div>
      <div class="panel-body scrollDiv" id="chartP">
      </div>
  </div>
  <div class="panel panel-default ">
      <div class="panel-heading">
          <i class="glyphicon glyphicon-stats"></i>Average margin per cable
      </div>
      <div class="panel-body scrollDiv" id="chartAv">
 </div>
</div>-->
</div>
	<!--chat & compte panel -->
	<div class="col-md-4">
   <?php
   include('../include/home/chatPanel.php');
   include('../include/home/comptePanel.php');
   ?>
 </div>
 </div>
<?php

echo '</div>';

?> <!--Row-->
</form>
</div>
