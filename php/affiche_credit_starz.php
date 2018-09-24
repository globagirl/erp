<?php
include('../connexion/connexionDB.php');
$CN=$_POST['CN'];



$sql = mysql_query("SELECT * FROM credit_note_starz where idCN='$CN'");
$nbr=mysql_num_rows($sql);
if($nbr>0){
$data=mysql_fetch_array($sql);
$statut=$data['statut'];
	
if($statut=="unpaid"){


///////////
echo('<br>
 <div class="panel panel-blue2 ">
 <div class="panel-heading">Credit note N° : '.$data['idCN'].' </div>
  <div class="panel-body" >
   <div class="row">
  <div class="col-lg-6">
  <div class="form-group">
  <label>Client</label>
  <input class="form-control" id="client" name="client" value='.$data['supplier'].' READONLY>                                            
                                        
  
  </div>

  <div class="form-group">
  <label>Amount</label>
  <input class="form-control" id="amount" name="amount" value='.$data['amount'].' READONLY>                                            
  <p class="help-block">Devise :'.$data['devise'].'</p>
  </div> 
  <div class="form-group">
  <label>Original invoice</label>
  <input class="form-control" id="factID" name="factID" value='.$data['IDfact'].' READONLY>                                            
  
  </div>
  <div class="form-group">
  <label>Date creation</label>
  <input class="form-control"  name="dateCN" value='.$data['dateCN'].' READONLY>                                           
  </div>
  <div class="form-group">
  <label>Date paiement</label>
  <input class="form-control"  type="date" name="dateP" id="dateP">                                           
  </div> 
  
  
 <input type="button" class="btn btn-primary" onClick="submitCN();" value="paid >>  ">                         

</div>
</div>
</div>
</div>

');}


else{

echo 0;
}
}else{
echo 1;
}
?>