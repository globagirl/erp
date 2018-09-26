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
                        ?>
                    </div><!--Fin panel heading -->
                </div><!--Fin BLUE PANEL -->
                <br>
            </div>
            <form method="post" name="form1" id="form1" action="../php/message2.php" enctype="multipart/form-data">
                <div class="row">
                    <?php
                    $paneT1="Total production TODAY !";
                    $paneL1="../pages/consult_qty_prod.php";
                    $paneL2="../pages/consult_qty_prod.php";
                    $paneT2="Total defaults TODAY!";
                    $paneT3="Production for THIS week !";
                    $paneT4="Total QTY for THIS week !";
                    $T1="glyphicon glyphicon-stats Zoom3 WH";
                    $T2="glyphicon glyphicon-stats Zoom3 WH";
                    $T3="glyphicon glyphicon-thumbs-down Zoom3 WH";
                    //production de la journée
                    $req2= mysql_query("SELECT sum(qte_s) FROM pro_test_pol where date_fin LIKE '$dateJ%'");
                    $tot_prod_d=mysql_result($req2,0);
                    $paneV1 = number_format($tot_prod_d, 0, ',', ' ');
                    //défaut du jour
                    $req21= mysql_query("SELECT sum(nbr_def) FROM pro_test_pol where date_fin LIKE '$dateJ%'");
                    $tot_def1=mysql_result($req21,0);
                    $req22= mysql_query("SELECT sum(nbr_def) FROM pro_sertiss where date_fin LIKE '$dateJ%'");
                    $tot_def2=mysql_result($req22,0);
                    $tot_def=$tot_def1+$tot_def2;
                    $paneV2 = number_format($tot_def, 0, ',', ' ');
                    //QTY of this week
                    $reqMax= mysql_query("SELECT max(date_exped_conf) FROM ordre_fabrication1 where statut='closed' and date_exped_conf <= '$dateJ'");
                    $maxEx=@mysql_result($reqMax,0);
                    $reqMin= mysql_query("SELECT min(date_exped_conf) FROM ordre_fabrication1 where date_exped_conf>'$maxEx'");
                    $minEx=@mysql_result($reqMin,0);
                    $totCMD=0;
                    $req31= mysql_query("SELECT * FROM ordre_fabrication1 where date_exped_conf >'$maxEx' and date_exped_conf <= '$minEx'");
                    while($data=@mysql_fetch_array($req31)){
                        $OF=$data['OF'];
                        $req311= mysql_query("SELECT sum(qte_s) FROM pro_test_pol where plan LIKE '$OF-%'");
                        $qtyCMD=@mysql_result($req311,0);
                        $totCMD=$totCMD+$qtyCMD;
                    }
                    $paneV3 = number_format($totCMD, 0, ',', ' ');
                    $paneV3 = $paneV3;
                    //production of this week
                    $req32= mysql_query("SELECT sum(qte_demande) FROM commande2 where date_exped >'$maxEx' and date_exped <='$minEx'");
                    $qtyCMD=mysql_result($req32,0);
                    $paneV4=number_format($qtyCMD, 0, ',', ' ');
                    echo'<div class="col-md-12">
                        <div class="col-md-3">       
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3"><i class="'.$T1.'"></i></div>
                                        <div class="col-xs-9 text-right">
                                            <div class="huge">'.$paneV1.'</div>
                                            <div >'.$paneT1.'</div>
                                        </div>
                                    </div>
                                </div>
                                <a href="#">
                                    <div class="panel-footer">
                                        <span class="pull-left"> <a href='.$paneL1.'>View Details</a></span>
                                        <span class="pull-right"><i class="glyphicon glyphicon-share-alt pull-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                            </div>
                        </div>
                            <div class="col-md-3">
                                <div class="panel panel-red">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3"><i class="'.$T3.'"></i></div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">'.$paneV2.'</div>
                                                <div>'.$paneT2.'</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left"> <a href='.$paneL1.'>View Details</a></span>
                                            <span class="pull-right"><i class="glyphicon glyphicon-share-alt pull-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="panel panel-yellow">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3"><i class="'.$T2.'"></i></div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">'.$paneV3.'</div>
                                                <div>'.$paneT3.'</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left"> <a href='.$paneL2.'>View Details</a></span>
                                            <span class="pull-right"><i class="glyphicon glyphicon-share-alt pull-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                                
                            <div class="col-md-3">
                                <div class="panel panel-green">
                                    <div class="panel-heading">
                                        <div class="row">
                                            <div class="col-xs-3"><i class="'.$T2.'"></i></div>
                                            <div class="col-xs-9 text-right">
                                                <div class="huge">'.$paneV4.'</div>
                                                <div>'.$paneT4.'</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#">
                                        <div class="panel-footer">
                                            <span class="pull-left"> <a href='.$paneL2.'>View Details</a></span>
                                            <span class="pull-right"><i class="glyphicon glyphicon-share-alt pull-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>';
                    ?>
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <?php include('../include/home/relancePanel.php');	?>
                        </div>
                        <div class="col-md-6">
                            <?php include('../include/home/chatPanel.php');?>
                            <?php include('../include/home/comptePanel.php');?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>