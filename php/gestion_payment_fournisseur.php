<?php
  include('../connexion/connexionDB.php');
  $four=$_POST['four'];  
  $dateJ=date("Y-m-d");
 
  $req= mysql_query("SELECT IDinvoice,dateF,dateP,total,currency FROM supplier_invoice where status='unpaid' and dateP <= '$dateJ' and supplier='$four'");
  while($a=@mysql_fetch_array($req)){
		 $IDinvoice =$a['IDinvoice'];
     $n=strpos($IDinvoice,"-");     
     $invoice=substr($IDinvoice,$n+1);
		 echo('<tr>
		 <td style="width:5%;height:60px;text-align:center">
		 <input type="checkbox" name="IDinvoice[]" onClick="totalInvoice()" value='.$IDinvoice.'>
		 </td> 
		 <td style="width:25%;height:60px;text-align:center">'.$invoice.'</td>
     <td  style="width:20%;height:60px;text-align:center">'.$a['dateF'].'</td>
     <td  style="width:20%;height:60px;text-align:center">'.$a['dateP'].'</td>	
		 <td style="width:20%;height:60px;text-align:center">'.$a['total'].'</td>
		 <td style="width:10%;height:60px;text-align:center">'.$a['currency'].'</td>
		
		 </tr>');
  }
  mysql_close();
?>