<?php  
    $jourJ=strtotime($dateJ);
    $num = strftime("%m",$jourJ);
	$year= strftime("%Y",$jourJ);
	$YN=$year."-".$num;
	$nbrCMD=0;
	//Not shipped yet 
	
	$req21= mysql_query("SELECT * FROM commande2 where client='1004'  and date_exped LIKE '$YN-%'");
	$qtyCMD=0;
	while($dataCMD=mysql_fetch_array($req21)){	
	   $PO=$dataCMD['PO'];
	   $req211= mysql_query("SELECT sum(qty) FROM commande_items where statut !='closed' and statut !='incomplete' and PO='$PO'");
      $CMD1=mysql_result($req211,0);
	   if($CMD1 != NULL){
	     $qtyCMD=$qtyCMD+$CMD1;
		 $nbrCMD++;
	   }
	}
	
	$req212= mysql_query("SELECT sum(qte) FROM fact1 where client='1004'  and date_E LIKE '$YN-%'");
	$reqFI= mysql_query("SELECT COUNT(num_fact) FROM fact1 where client='1004' and date_E LIKE '$YN-%'");
	$CMD2=mysql_result($req212,0);
	$nbrFact=mysql_result($reqFI,0);	
	$nbrCMD=$nbrCMD+$nbrFact;
	$qtyCMD=$CMD2+$qtyCMD;
	/*
	$req21= mysql_query("SELECT sum(qte_demande) FROM commande2 where date_exped LIKE '$nbr-%' and client='TYCO2'");
    $qtyCMD=mysql_result($req1,0);*/
	$paneV3 = number_format($qtyCMD, 0, ',', ' ');	
	
   echo'<div class="col-md-3">
				<div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-2"><i class="glyphicon glyphicon-equalizer Zoom3 WH"></i></div>
                            <div class="col-md-10 text-right">
                                <div class="huge"> Total QTY: '.$paneV3.'</div>
                                <div>Total CMD : '.$nbrCMD.'</div>
                            </div>
                        </div>
                    </div>
                    <a href="#">
                        <div class="panel-footer">';
	if($role=='DIR'){
        echo '<span class="pull-left"> <a href="../pages/accounting_profit3.php">THIS MONTH !! </a></span>';
    }else{
        echo '<span class="pull-left"> <a href="../php/excel_cmdCurrent.php">THIS MONTH !! </a></span>';
    }	
                            
    echo' <span class="pull-right"><i class="glyphicon glyphicon-share-alt pull-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>';
?>