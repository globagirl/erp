<?php
include('../connexion/connexionDB.php');
$invoice=$_POST['invoice'];
$sql = mysql_query("SELECT * FROM supplier_invoice where IDinvoice='$invoice'");
$data=mysql_fetch_array($sql);
$IDinvoice=$invoice;
$n=strpos($IDinvoice,"-");
$IDinvoice=substr($IDinvoice,$n+1); 
$typeI=$data['typeI'];
?>
<div class="col-lg-12 well">                          
    <div class="form-group form-inline">
	<label>N° Facture : <?php echo $IDinvoice ; ?></label>
	<input type="text" class="form-control" id="numFact1" name="numFact1"  value="<?php echo $data['IDinvoice'] ; ?>" style="visibility:HIDDEN">
    </div>
	<hr>
	<div class="form-group form-inline ">
	<label>N°Facture :</label>
	<input type="text" class="form-control" id="numFact" name="numFact"  value="<?php echo $IDinvoice ; ?>" >
    </div>
	<div class="form-group form-inline">
	<label>Fournisseur :</label>
	<input type="text" class="form-control" id="four" name="four"  value="<?php echo $data['supplier'] ; ?>" onKeyup="autoComplete2();"  onFocus="autoComplete2()" onBlur="hideListe2();">  <div class="divAuto2"><ul id="listeF3" ></ul></div>
    </div>
	<div class="form-group form-inline">
	<label>Date facture :</label>
	<input type="date" class="form-control" id="dateF" name="dateF"  value="<?php echo $data['dateF'] ; ?>">
    </div>
	<div class="form-group form-inline">
	<label>Date payment :</label>
	<input type="date" class="form-control" id="dateP" name="dateP"  value="<?php echo $data['dateP'] ; ?>">
    </div>
	<div class="form-group form-inline">
	<label>Cours en TND :</label>
	<input type="text" class="form-control" id="coursTND" name="coursTND"  value="<?php echo $data['coursTND'] ; ?>">
	<select name="devise" id="devise" type="text" class="form-control">
	   <option value="<?php echo $data['currency'] ; ?>">Devise :<?php echo $data['currency'] ; ?></option>
	   <option value="TND">TND</option>
	   <option value="EUR">EUR</option>
	   <option value="USD">USD</option>
	</select>
    </div>
	
    <div class="form-group form-inline">
	<label>Categorie :</label>
    <select name="cat" id="cat" class="form-control" >
		<?php
			 echo '<option value="'.$data["catI"].'">'.$data["catI"].'</option>'; 
			 $sql1 = "SELECT typeCat,catName FROM invoice_category where typeCat='D' or typeCat='A' ";
			 $res = mysql_query($sql1) or exit(mysql_error());
			
			 while($data1=mysql_fetch_array($res)) {
			 echo '<option value="'.$data1["catName"].'">'.$data1["catName"].'</option>'; 
			 }
			 
		?>
    </select> 
	</div>
	<?php 
	if($typeI != 'Purchase'){
	     echo'<div class="form-group form-inline">
	       <label>Categorie :</label>
	       <select name="typeI" id="typeI" class="form-control" >		
			 <option value="'.$data["typeI"].'">'.$data["typeI"].'</option> 
			 <option value="Service">Service</option> 
			 <option value="Expense">Expense</option> 
          </select> </div>'; 
	}else{
	   echo'<div class="form-group form-inline">
	       <label>Categorie :</label>	     	
			 <input  type="text" class="form-control" id="typeI" name="typeI" value="'.$data["typeI"].'"> 
		</div>'; 
	}
	?>
	<div class="form-group">
	  <input type="button" class="btn btn-danger" value="Modifier >>" onClick="update_facture2()";> 
    </div>	  
</div>
<script>
///////Auto Complete //////
function autoComplete2(){
   var min_length =2; 
	var keyword = $('#four').val();	
	if (keyword.length >= min_length) {
	var zoneC="#four";
		$.ajax({
			url: '../php/auto_liste_Finvoice.php',
			type: 'POST',
			data: "val="+keyword+"&Z="+zoneC,
			success:function(data){
				$('#listeF3').show();
				$('#listeF3').html(data);
			}});
	}else {
		$('#listeF3').hide();
	}
	
}
//
function hideListe2() {
	
    
	$('#listeF3').hide();
	}
//	
function choixListe2(p,z) {
    var ch=p.replace("|"," ");
    ch=ch.replace("|"," ");
    ch=ch.replace("|"," ");
    ch=ch.replace("|"," ");
    ch=ch.replace("|"," ");
	$(z).val(ch);
	
}
</script>