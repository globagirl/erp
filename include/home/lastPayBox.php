<?php
//Selectionnez le next monday
//
   
    
    $req1= mysql_query("SELECT max(dateP) FROM payment_client where client='1004'");
	$dernier_payD=mysql_result($req1,0);
	$req11= mysql_query("SELECT solde FROM payment_client where client='1004' and (dateP='$dernier_payD')");
	$dernier_pay=@mysql_result($req11,0);
	$req12= mysql_query("SELECT sum(tot_val) FROM  fact1 where client='1004'  and date_pay <= '$dernier_payD'");
	$expec=@mysql_result($req12,0);  
	$paneV1 = number_format($dernier_pay, 2, ',', ' ');		
	$paneV11 = number_format($expec, 2, ',', ' ');	
	echo ' <div class="col-md-3">       
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-2"><i class="glyphicon glyphicon-euro Zoom3 WH"></i></div>
                        <div class="col-md-10 text-right">
						    <div class="huge">Expected: '.$paneV11.'</div>
						    <div class="huge">Received: '.$paneV1.'</div>
                           
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left"> <a href="../pages/tyco_account.php">Last payment !! </a></span>
                        <span class="pull-right"><i class="glyphicon glyphicon-share-alt pull-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>';
?>