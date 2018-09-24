<?php
include('../connexion/connexionDB.php');
$fact=$_POST['fact'];



$sql = mysql_query("SELECT * FROM fact1 where num_fact='$fact'");
$nbr=mysql_num_rows($sql);
if($nbr>0){
$data=mysql_fetch_array($sql);
	$statut=$data['statut'];
	
if($statut=="unpaid"){


///////////
echo('<br>
 <div class="panel panel-blue2 ">
 <div class="panel-heading">Invoice N° : '.$data['num_fact'].' </div>
  <div class="panel-body" >
   <div class="row">
  <div class="col-lg-6">
  <div class="form-group">
  <label>Client</label>
  <input class="form-control" id="client" name="client" value='.$data['client'].' READONLY>                                            
  
  </div>

  <div class="form-group">
  <label>Total</label>
  <input class="form-control" id="total" name="total" value='.$data['tot_val'].' READONLY>                                            
  <p class="help-block">Devise :'.$data['devise'].'</p>
  </div>
  <div class="form-group">
  <label>Date facturation</label>
  <input class="form-control"  name="dateF" value='.$data['date_fact'].' READONLY>                                           
  </div>
  <div class="form-group">
  <label>Date paiement</label>
  <input class="form-control"  type="date" name="dateP" id="dateP">                                           
  </div> 
  
  
 <input type="button" class="btn btn-primary" onClick="submitV();" value="paid >>  ">                         

</div>
</div>
</div>
</div>

');}
//////Cas PCB & Others

else{

echo 0;
}
}else{
echo 1;
}
?>