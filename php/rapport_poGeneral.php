<?php
include('../connexion/connexionDB.php');
$PO=@$_POST['PO'];
$req=mysql_query ("SELECT * FROM commande2 where PO='$PO' ");
if(mysql_num_rows($req)>0){
    $data=mysql_fetch_array($req);
    $req1=mysql_query ("SELECT * FROM commande_items where PO='$PO' ");
    echo '
        <ul class="nav nav-tabs">
            <li class="active"><a href="#GE" data-toggle="tab">General </a></li>
            <li><a href="#mag" data-toggle="tab" onClick="afficheMAG();">Used materiel</a></li>
            <li><a href="#man" data-toggle="tab" >Manufacturing</a></li>
        </ul>
        <div class="tab-content" id="general">							
        <div class="tab-pane fade in active" id="GE">
        <div class="row">
        <br>
        <div class="col-lg-6">
        <div class="panel panel-default">
        <div class="panel-heading">
        Commercial information
        </div>
        <div class="panel-body">
        <div class="row">';
    $nbr= mysql_num_rows($req1);
    $i=0;
    while($data1=mysql_fetch_array($req1)){
        $i++;
        echo '     <div class="col-lg-12">
	                    <div class="col-lg-6">
                         Purshase order N° :
                        </div>
						<div class="col-lg-6">
                         '.$data1['POitem'].'
						 
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                         Product :
                        </div>
						<div class="col-lg-6">
                         '.$data1['produit'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Quantity :
                        </div>
						<div class="col-lg-6">
                        '.$data1['qty'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Unit price:
                        </div>
						<div class="col-lg-6">
                         '.$data1['prixU'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Amount :
                        </div>
						<div class="col-lg-6">
                         '.$data1['prixT'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Creation date :
                        </div>
						<div class="col-lg-6">
                         '.$data['date_ent_cmd'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Shipping date :
                        </div>
						<div class="col-lg-6">
                         '.$data['date_exped'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        <hr>
                        </div>
						<div class="col-lg-6">
                         <hr>
                        </div>
						</div>
						';
        $req3=mysql_query ("SELECT * FROM fact_items where PO='$PO' ");
        $j=0;
        while($data3=mysql_fetch_array($req3)){
            $j++;
            $numFact=$data3['idF'];
            $req4=mysql_query ("SELECT * FROM fact1 where num_fact='$numFact' ");
            $data4=mysql_fetch_array($req4);
            echo '  <div class="col-lg-12">
                    <div class="col-lg-6">
                        Invoice date N° '.$j.' :
                    </div>
                    <div class="col-lg-6">
                        '.$data4['date_fact'].'
                    </div>
                    </div>
                    <div class="col-lg-12">
                    <div class="col-lg-6">
                        BL N° '.$j.':
                    </div>
                    <div class="col-lg-6">
                        '.$data3['idF'].'
                    </div>
                    </div>
                    <div class="col-lg-12">
                    <div class="col-lg-6">
                        Invoice N° '.$j.' :
                    </div>
                    <div class="col-lg-6">
                        '.$data3['idF'].'
                    </div>
                    
                    </div>
                    <div class="col-lg-12">
                    <div class="col-lg-6">
                    <hr>
                    </div>
                    <div class="col-lg-6">
                    <hr>
                    </div>
                    </div>';
        }
        if($i != $nbr){
            echo '<hr>';
        }
    }
    echo '</div>
            </div>
            </div>
            </div>	
            <div class="col-lg-6">
            <div class="panel panel-default">
            <div class="panel-heading">
                Manufacturing information
            </div>
            <div class="panel-body">
            <div class="row">';
    $req5=mysql_query ("SELECT * FROM ordre_fabrication1 where PO='$PO' or PO LIKE '$PO-%'");
    while($data5=mysql_fetch_array($req5)){
        echo '  <div class="col-lg-12">
                <div class="col-lg-6">
                Manufacturing order N° :
                </div>
                <div class="col-lg-6">
                '.$data5['OF'].'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                WorkPlans :
                </div>
                <div class="col-lg-6">
                '.$data5['nbr_plan'].'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Quantity :
                </div>
                <div class="col-lg-6">
                '.$data5['qte'].'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Release date :
                </div>
                <div class="col-lg-6">
                '.$data5['date_lance'].'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                <hr>
                </div>
                <div class="col-lg-6">
                <hr>
                </div>
                </div>';
    }
    echo '  </div>
            </div>
            </div>
            </div>
            </div>					
            </div>';
    //Sortie magazin
    echo '  <div class="tab-pane fade" id="mag">
            <div class="row">
            <br>
            <div class="col-lg-12">
            <div class="panel panel-default">
            <div class="panel-heading">
            Manufacturing
            </div>
            <div class="panel-body">
            <div class="row">';
    $req6X=mysql_query ("SELECT * FROM bande_sortie where PO='$PO'");
    while($data6X=mysql_fetch_array($req6X)){
        $IDsortie=$data6X['IDsortie'];
        echo '  <div class="col-lg-12">
                <div class="col-lg-4">
                <b>Date Sortie : '.$data6X['dateS'].'</b>
                </div>
                <div class="col-lg-4">
                <b>ID operateur : '.$data6X['IDoperateur'].'</b>
                </div>
                <div class="col-lg-4">
                <b>Ordre Fabriquation N° : '.$data6X['OF'].'</b>
                </div>
                <div class="col-lg-12">
                <hr>
                </div>
                </div>';
        echo '  <div class="col-lg-12">
                <div class="col-lg-6">
                <b>Paquet</b>
                </div>
                <div class="col-lg-4">
                <b>Qty</b>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                <b><hr></b>
                </div>
                <div class="col-lg-4">
                <b><hr></b>
                </div>
                </div>';
        $req6=mysql_query ("SELECT * FROM sortie_items where IDbande='$IDsortie'");
        while($data6=mysql_fetch_array($req6)){
            echo '  <div class="col-lg-12">
                    <div class="col-lg-6">
                    '.$data6['IDpaquet'].'
                    </div>
                    <div class="col-lg-4">
                    '.$data6['qte'].'
                    </div></div>';
        }
    }
    echo '</div></div></div></div></div></div></div>';
    //Production
    $r1 = mysql_query ("SELECT * FROM decoup WHERE PO='$PO' or PO LIKE '$PO-%'");
    $r2= mysql_query ("SELECT * FROM pro_assem WHERE PO='$PO' or PO LIKE '$PO-%'");
    $r3 = mysql_query ("SELECT * FROM pro_sertiss WHERE PO='$PO' or PO LIKE '$PO-%'");
    $r4 = mysql_query ("SELECT * FROM pro_test_pol WHERE PO='$PO' or PO LIKE '$PO-%'");
    $r5 = mysql_query ("SELECT * FROM pro_contr_fluke  WHERE PO='$PO' or PO LIKE '$PO-%' ");
    $r6 = mysql_query ("SELECT * FROM pro_emb WHERE PO='$PO' or PO LIKE '$PO-%' ");
    echo '  <div class="tab-pane fade" id="man">
            <div class="row">
            <br>
            <div class="col-lg-12">';
    //Cutting
    echo '  <div class="col-lg-6">
            <div class="panel panel-default">
            <div class="panel-heading">
            Cutting
            </div>
            <div class="panel-body">
            <div class="row">';
    while($d1=mysql_fetch_array($r1)){
        echo '  <div class="col-lg-12">
                <div class="col-lg-6">
                Plan :
                </div>
                <div class="col-lg-6">
                '.$d1['plan'].'
                </div>						
                </div> 
                <div class="col-lg-12">
                <div class="col-lg-6">
                <hr>
                </div>
                <div class="col-lg-6">
                <hr>
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Operator
                </div>
                <div class="col-lg-6">
                '.$d1['nom_oper'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Line :
                </div>
                <div class="col-lg-6">
                '.$d1['mach_dec'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Batch :
                </div>
                <div class="col-lg-6">
                '.$d1['batch'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Starting date:
                </div>
                <div class="col-lg-6">
                '.$d1['date_debut'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Finishing date :
                </div>
                <div class="col-lg-6">
                '.$d1['date_fin'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Input qty :
                </div>
                <div class="col-lg-6">
                '.$d1['qte_e'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Output qty :
                </div>
                <div class="col-lg-6">
                '.$d1['q_sor'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Pattern 1
                </div>
                <div class="col-lg-6">
                '.$d1['e1'].'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Pattern 2
                </div>		
                <div class="col-lg-6">
                '.$d1['e2'].'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Pattern 3
                </div>
                <div class="col-lg-6">
                '.$d1['e3'].'
                </div>
                <hr>						
                </div>';
    }
    echo '</div></div></div></div>';
    //Assembly
    echo '  <div class="col-lg-6">
            <div class="panel panel-default">
            <div class="panel-heading">Assembly </div>
            <div class="panel-body">
            <div class="row">';
    while($d2=mysql_fetch_array($r2)){
        $op1=$d2['op_1'];
        $op2=$d2['op_2'];
        $op3=$d2['op_3'];
        $op4=$d2['op_4'];
        $op5=$d2['op_5'];
        $op6=$d2['op_6'];
        $op7=$d2['op_7'];
        if($op1=="" or $op1 =="s"){
            $op1="---";
        }
        if($op2=="" or $op2 =="s"){
            $op2="---";
        }
        if($op3=="" or $op3 =="s"){
            $op3="---";
        }
        if($op4=="" or $op4 =="s"){
            $op4="---";
        }
        if($op5=="" or $op5 =="s"){
            $op5="---";
        }
        if($op6=="" or $op6 =="s"){
            $op6="---";
        }if($op7=="" or $op7 =="s"){
            $op7="---";
        }
        echo '  <div class="col-lg-12">
                <div class="col-lg-6">
                Plan :
                </div>
                <div class="col-lg-6">
                '.$d2['plan'].'
                </div>						
                </div> 
                <div class="col-lg-12">
                <div class="col-lg-6">
                <hr>
                </div>
                <div class="col-lg-6">
                <hr>
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Line :
                </div>
                <div class="col-lg-6">
                '.$d2['ch_ins'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Starting date:
                </div>
                <div class="col-lg-6">
                '.$d2['date_debut'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Finishing date :
                </div>
                <div class="col-lg-6">
                '.$d2['date_fin'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Input qty :
                </div>
                <div class="col-lg-6">
                '.$d2['qte_e'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Output qty :
                </div>
                <div class="col-lg-6">
                '.$d2['qte_s'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">                         
                Control agent
                </div>
                <div class="col-lg-6">
                '.$d2['ag_cont'].'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-12">
                Operators :
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                1/ '.$op1.'
                </div>
                <div class="col-lg-6">
                2/ '.$op2.'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                3/ '.$op3.'
                </div>
                <div class="col-lg-5">
                4/ '.$op4.'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                5/'.$op5.'
                </div>
                <div class="col-lg-6">
                6/  '.$op6.'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                7/'.$op7.'
                </div>
                <div class="col-lg-6">
                8/ -----
                </div>
                <hr>				
                </div>';
    }
    echo '</div></div></div></div>';
    //Crimping
    echo '  <div class="col-lg-6">
            <div class="panel panel-default">
            <div class="panel-heading">Crimping</div>
            <div class="panel-body">
            <div class="row">';
    while($d3=mysql_fetch_array($r3)){
        echo '  <div class="col-lg-12">
                <div class="col-lg-6">
                Plan :
                </div>
                <div class="col-lg-6">
                '.$d3['plan'].'
                </div>						
                </div> 
                <div class="col-lg-12">
                <div class="col-lg-6">
                <hr>
                </div>
                <div class="col-lg-6">
                <hr>
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Line :
                </div>
                <div class="col-lg-6">
                '.$d3['num_ch'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Starting date:
                </div>
                <div class="col-lg-6">
                '.$d3['date_debut'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Finishing date :
                </div>
                <div class="col-lg-6">
                '.$d3['date_fin'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Input qty :
                </div>
                <div class="col-lg-6">
                '.$d3['qte_e'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Output qty :
                </div>
                <div class="col-lg-6">
                '.$d3['qte_s'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Defects :
                </div>
                <div class="col-lg-6">
                '.$d3['nbr_def'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">                         
                Control agent:
                </div>
                <div class="col-lg-6">
                '.$d3['ag_cont'].'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">                         
                Operator :
                </div>
                <div class="col-lg-6">
                '.$d3['nom_opr'].'
                </div>
                <hr>
                </div>';
    }
    echo '</div></div></div></div>';
    //Connector Polarity test
    echo '  <div class="col-lg-6">
            <div class="panel panel-default">
            <div class="panel-heading">Polarity Test</div>
            <div class="panel-body">
            <div class="row">';
    while($d4=mysql_fetch_array($r4)){
        echo '  <div class="col-lg-12">
                <div class="col-lg-6">
                Plan :
                </div>
                <div class="col-lg-6">
                '.$d4['plan'].'
                </div>						
                </div> 
                <div class="col-lg-12">
                <div class="col-lg-6">
                <hr>
                </div>
                <div class="col-lg-6">
                <hr>
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Line :
                </div>
                <div class="col-lg-6">
                '.$d4['ch_ins'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Starting date:
                </div>
                <div class="col-lg-6">
                '.$d4['date_debut'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Finishing date :
                </div>
                <div class="col-lg-6">
                '.$d4['date_fin'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Input qty :
                </div>
                <div class="col-lg-6">
                '.$d4['qte_e'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Output qty :
                </div>
                <div class="col-lg-6">
                '.$d4['qte_s'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">
                Defects :
                </div>
                <div class="col-lg-6">
                '.$d4['nbr_def'].'
                </div>						
                </div>
                
                <div class="col-lg-12">
                <div class="col-lg-6">                         
                Control agent:
                </div>
                <div class="col-lg-6">
                '.$d4['ag_cont'].'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">                         
                Operator 1 :
                </div>
                <div class="col-lg-6">
                '.$d4['op_1'].'
                </div>
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">                         
                Operator 2 :
                </div>
                <div class="col-lg-6">
                '.$d4['op_2'].'
                </div>
                <hr>
                </div>';
    }
    echo '</div></div></div></div>';
    //Fluck test
    echo '  <div class="col-lg-6">
            <div class="panel panel-default">
            <div class="panel-heading">
             Fluke test
            </div>
            <div class="panel-body">
            <div class="row">';
    while($d5=mysql_fetch_array($r5)){
        echo '  <div class="col-lg-12">
                <div class="col-lg-6">
                Plan :
                </div>
                <div class="col-lg-6">
                '.$d5['plan'].'
                </div>						
                </div> 
                <div class="col-lg-12">
                <div class="col-lg-6">
                <hr>
                </div>
                <div class="col-lg-6">
                <hr>
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Starting date:
                </div>
                <div class="col-lg-6">
                '.$d5['date_debut'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Finishing date :
                </div>
                <div class="col-lg-6">
                '.$d5['date_fin'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Input qty :
                </div>
                <div class="col-lg-6">
                '.$d5['qte_e'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                PASS /FAIL  :
                </div>
                <div class="col-lg-6">
                '.$d5['pass_fail'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">                         
                Control agent:
                </div>
                <div class="col-lg-6">
                '.$d5['ag_cont'].'
                </div>
                <hr>
                </div>';
    }
    echo '</div></div></div></div>';
    //Packaging
    echo '<div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         Packaging
                        </div>
                        <div class="panel-body">
						<div class="row">';
    while($d6=mysql_fetch_array($r6)){
        echo '  <div class="col-lg-12">
                <div class="col-lg-6">
                Plan :
                </div>
                <div class="col-lg-6">
                '.$d6['plan'].'
                </div>						
                </div> 
                <div class="col-lg-12">
                <div class="col-lg-6">
                <hr>
                </div>
                <div class="col-lg-6">
                <hr>
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Line :
                </div>
                <div class="col-lg-6">
                '.$d6['ch_ins'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Starting date:
                </div>
                <div class="col-lg-6">
                '.$d6['date_debut'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Finishing date :
                </div>
                <div class="col-lg-6">
                '.$d6['date_fin'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Input qty :
                </div>
                <div class="col-lg-6">
                '.$d6['qte_e'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">
                Output qty :
                </div>
                <div class="col-lg-6">
                '.$d6['qte_s'].'
                </div>						
                </div>
                <div class="col-lg-12">
                <div class="col-lg-6">                         
                Control agent:
                </div>
                <div class="col-lg-6">
                '.$d6['ag_cont'].'
                </div>
                <hr>
                </div>';
    }
    echo '</div></div></div></div>';
    echo '</div></div></div></div>'; //Fin production
    mysql_close();
}else{
    echo 0 ;
    mysql_close();
}
?>