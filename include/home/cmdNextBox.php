<?php
//NEXT MOUNTH 
  
   $num++;
   if($num<10){
   $num='0'.$num;
   }else if ($num>12){
   $num='01';
   $year++;
   }
   $YN=$year."-".$num;
   $req31= mysql_query("SELECT sum(qte_demande) AS qteC ,count(PO) AS nbrC FROM commande2 where client='1004' and date_exped LIKE '$YN-%'");
   $dataQNBR=mysql_fetch_array($req31);
   //$qtyCMD=mysql_result($req31,0);
   $qtyCMD=$dataQNBR['qteC'];
   $nbrCMD2=$dataQNBR['nbrC'];
   $paneV4=number_format($qtyCMD, 0, ',', ' ');	
   	
		echo '	<div class="col-md-3">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-2"><i class="glyphicon glyphicon-equalizer Zoom3 WH"></i></div>
                            <div class="col-md-10 text-right">
                                <div class="huge">Total Qty: '.$paneV4.'</div>
                                <div>Total CMD :'.$nbrCMD2.'</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">
                            <span class="pull-left"> <a href="../pages/accounting_profit3.php">NEXT MONTH !!</a></span>
                            <span class="pull-right"><i class="glyphicon glyphicon-share-alt pull-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>' ;
//
?>