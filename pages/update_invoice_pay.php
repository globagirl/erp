<?php
include('../connexion/connexionDB.php');
$invoice=$_POST['invoice'];
$sql = mysql_query("SELECT * FROM invoice_mode_pay where num_invoice='$invoice'");
$IDinvoice=$invoice;
$n=strpos($IDinvoice,"-");
$IDinvoice=substr($IDinvoice,$n+1); 
echo '<div class="row">'; 
$i=0;  
while($data=mysql_fetch_array($sql)){ 
$i++;
$datePN="dateP".$i;
$modPN="modP".$i;
$refPN="refP".$i;
$comptePN="compteP".$i;
$montantPN="montantP".$i;
$modeP=$data['modeP'];
$IDpay=$data['IDmode'];
$compte="";
if(($modeP == 'Cheque')|| ($modeP == 'Virement')){
   $compte=$data['compte'];
   $sql1 = mysql_query("SELECT NUMcompte FROM compte_banque where REFcompte='$compte'");
   $banque=@mysql_result($sql1,0);
   $compte=$banque."/".$compte;
}                    
echo '<div class="col-lg-12">
    <div class="col-lg-4">
     <div class="form-group">
	       <label>Mode payment :</label>
	       <select name='.$modPN.' id='.$modPN.' class="form-control" >		
			 <option value="'.$data["modeP"].'">'.$data["modeP"].'</option> 
			 <option value="Cheque">Cheque</option> 
			 <option value="Virement">Virement</option> 
			 <option value="Cache">Cache</option> 
			 <option value="Autre">Autre ..</option> 
          </select>
		 </div>
	</div>
	<div class="col-lg-4">
	<div class="form-group">
	<label>Reference :</label>
	<input type="text" class="form-control" id='.$refPN.' name='.$refPN.'  value='. $data['reference'].' >
    </div>	
    </div>
   <div class="col-lg-4">	
	<div class="form-group">
	<label>Date payment :</label>
	<input type="date" class="form-control" id='.$datePN.' name='.$datePN.'  value='.$data['dateP'].'>
    </div>
    </div>
    </div>
	<div class="col-lg-12"><div class="col-lg-6">
    <div class="form-group">
	<label>Compte :</label>
    <select name='.$comptePN.' id='.$comptePN.' class="form-control" >	
			<option value="'.$data["compte"].'">'.$compte.'</option>'; 
			 $sql2 = "SELECT REFcompte,NUMcompte,banque FROM compte_banque ";
			 $res = mysql_query($sql2) or exit(mysql_error());
			
			 while($data1=mysql_fetch_array($res)) {
			 echo '<option value="'.$data1["REFcompte"].'">'.$data1["NUMcompte"].'/'.$data1['banque'].'</option>'; 
			 }
			 

    echo '</select> 
	</div></div>
	<div class="col-lg-4">	
	<div class="form-group">
	<label>Montant :</label>
	<input type="text" class="form-control" id='.$montantPN.' name='.$montantPN.'  value='.$data['montant'].'>
    </div>
    </div>
	<div class="col-lg-2">	
	<div class="form-group"><br>';
	echo "<input type=\"button\" class=\"btn btn-danger\" value=\" >>\" onClick=\"update_facture_pay2('".$IDpay."','".$i."')\">" ;
	echo '</div>
	</div>
	</div>
	</div>
	<hr>
	';
	
	}
	echo '</div>';
	mysql_close();
?>
