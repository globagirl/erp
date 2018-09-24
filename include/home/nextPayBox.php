<?php
//Next payment 
     $jour = strtotime($dateJ);
	$num = strftime("%a",$jour);
	if($num=="Mon"){
		$nextM=$dateJ;
	}else{
	    $nextM=strtotime("next Monday",$jour);
		$nextM=date('Y-m-d',$nextM);	
	}  

	$req11= mysql_query("SELECT sum(tot_val) FROM fact1 where client='1004' and date_pay <= '$nextM' and statut='unpaid'");
    $unpaid_sales=mysql_result($req11,0);

   
	$paneV2 = number_format($unpaid_sales, 2, ',', ' ');	
	echo '<div class="col-md-3">
				<div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-2"><i class="glyphicon glyphicon-euro Zoom3 WH"></i></div>
                            <div class="col-md-10 text-right">
                                <div class="huge">'.$paneV2.'</div>
                                <div>Next payment !</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left"> <a href="../pages/tyco_account.php">View Details</a></span>
                            <span class="pull-right"><i class="glyphicon glyphicon-share-alt pull-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>';
?>