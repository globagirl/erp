<form role="form" method="post" name="form1" id="form1" action="../php/update_invoice.php" enctype="multipart/form-data">
<?php
include('../connexion/connexionDB.php');
$invoice=$_POST['invoice'];
$req=mysql_query("SELECT nameF,dataF FROM invoice_files where IDinvoice='$invoice'");
echo '<div class="row"><div class="col-lg-12 well">
<table class="table table-fixed results">';
while($data=@mysql_fetch_array($req)){
	$nameF=$data['nameF'];
	/*$n=strpos($nameF,".");
	$formatF=substr($nameF,$n+1);
    $nameF=substr($nameF,0,$n-1);*/
	$nameF=str_replace(' ','|',$nameF);
    
	echo ("<tr>
		  <td>".$data['nameF']."</td>
		  <td><input type=\"button\" class=\"btn btn-danger\" value=\"X\" onClick=delete_invoice_file('".$invoice."','".$nameF."')></td>
		  </tr>");
	
}
echo "</table></div>";
mysql_close();
?>
<div class="col-lg-12 well" >
<div class="col-lg-6" >
<input type="file" name="imgfact[]" class="form-control"  multiple>
<input name="inv" value="<?php echo $invoice ; ?> " HIDDEN></div>
<div class="col-lg-6" >
<tr><td> </td><td>  <input type="submit" value="Ajout >>" class="btn btn-primary"></td></tr>
</div>
</div>
</div>

</form>
