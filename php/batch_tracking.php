<?php
 $batch = $_POST['batch'];
  $item = $_POST['item'];
include('../connexion/connexionDB.php');
$sql1 = mysql_query("SELECT idRO,sum(qte_def) AS qtyR,count(IDpaquet) as nbrP FROM paquet2 where IDarticle='$item' and batch='$batch' group by idRO");
$sql12 = mysql_query("SELECT IDpaquet FROM paquet2 where IDarticle='$item' and batch='$batch'");
if(mysql_num_rows($sql1)>0){
   echo ' <div class="row">
			<br>
                    <div class="col-lg-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Reception information
                        </div>
                       
                        <div class="panel-body">
						<div class="row">';
						
						while($data1=mysql_fetch_array($sql1)){
						$reception=$data1['idRO'];
						$sql2 = mysql_query("SELECT * FROM reception where IDreception='$reception'");
						$data2=mysql_fetch_array($sql2);
						
	                    echo'<div class="col-lg-12">
	                    <div class="col-lg-6">
                         Reception ID :
                        </div>
						<div class="col-lg-6">
                         '.$data2['IDreception'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                         Shipment ID:
                        </div>
						<div class="col-lg-6">
                         '.$data2['IDshipment'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Reception date :
                        </div>
						<div class="col-lg-6">
                        '.$data2['dateR'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Supplier :
                        </div>
						<div class="col-lg-6">
                        '.$data2['supplier'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Quantity :
                        </div>
						<div class="col-lg-6">
                         '.$data1['qtyR'].'
                        </div>
						</div>
						<div class="col-lg-12">
	                    <div class="col-lg-6">
                        Boxs :
                        </div>
						<div class="col-lg-6">
                         '.$data1['nbrP'].'
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
						}
						echo '
					</div>
                    </div>
                    </div>
</div>					
					<div class="col-lg-7">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Affected orders
                        </div>
                       
                        <div class="panel-body">
						<div class="row">
						
	                    <div class="col-lg-12">
	                    <div class="col-lg-3">
                         <b>Purchase order </b><hr>
                        </div>
						<div class="col-lg-3">
                         <b>date </b><hr>
                        </div>
						
	                    <div class="col-lg-2">
                         <b>QTY </b><hr>
                        </div>
						<div class="col-lg-4">
                         <b> Paquet</b><hr>
                        </div>
						</div>
						
						';
						while($data12=mysql_fetch_array($sql12)){
						$paquet=$data12['IDpaquet'];
						$sql21 = mysql_query("SELECT * FROM sortie_stock1 where IDpaquet='$paquet'");
						while ($data21=mysql_fetch_array($sql21)){
						echo '
						<div class="col-lg-12">
	                    <div class="col-lg-3">
                        '.$data21['commande'].'
                        </div>
						<div class="col-lg-3">
                        '.$data21['date_sortie'].'
                        </div>
						
	                    <div class="col-lg-2">
                        '.$data21['qte'].'
                        </div>
						<div class="col-lg-4">
                        '.$data21['IDpaquet'].'
                        </div>
						</div>';
						}}
						echo '
						</div>
						</div>
					</div>
					</div>
					</div>';
					mysql_close();
}else{
echo 0 ; 
mysql_close();
}
				
?>