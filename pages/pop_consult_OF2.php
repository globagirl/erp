<?php 

echo '
<SCRIPT> 

function mySearch() {
var searchTerm = $(".search").val();
searchTerm=searchTerm.toUpperCase();
var listItem = $('.results tbody').children('tr'); 
var jobCount = $('.results tbody').children('tr').length;
	 
 for (var iter = 1; iter <= jobCount; iter++) {

 var nIter1="#"+iter;
 var val=$(nIter1).html();
 val=val.toUpperCase();
 if (val.indexOf(searchTerm) >= 0){
 $(nIter1).attr('visible','true');
 }else{
 $(nIter1).attr('visible','false');
  }
 }
}




			   
			   
</SCRIPT> ';
echo '


   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manufacturing orders </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>



<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">

 <div class="panel-body" >
 <?php 
include('../connexion/connexionDB.php');

?>
 <div class="row">
          <div class="col-lg-12" >
		  <div class="pull-left col-lg-4">		
          <input type="text" class="search form-control"  placeholder="Search " onkeyup="mySearch()">
	
          </div>

</div>

                          <div class="col-lg-12" id="ALLfiles"> 
						  <form  id="form1" name="form1">
						  
  <br><br>	
                             
                         
							


<div class="col-lg-12" id="divRel">
<div class="table-responsive">
<table class="table table-fixed table-bordered results" id="table3">
<thead style="width:100%">
          
			<tr>
               <th style="width:9.8%;height:60px" class="degraD">OF</th>
				<th style="width:14.8%;height:60px" class="degraD">PO</th>
				<th style="width:14.8%;height:60px" class="degraD">Product</th>			  
				<th style="width:7.8%;height:60px" class="degraD">QTY</th>			  
				<th style="width:7.8%;height:60px" class="degraD">Nombre plan</th>			  
				<th style="width:7.9%;height:60px" class="degraD">Quantité par plan</th>			  
				<th style="width:11.9%;height:60px" class="degraD">Date lancement</th>			  
				<th style="width:11.9%;height:60px" class="degraD">Date expedition</th>			  
				<th style="width:11.9%;height:60px" class="degraD">Statut</th>			  
						  
            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%">';

   $x=0;
		    
	 
   $req= mysql_query("SELECT * FROM ordre_fabrication1  order by OF DESC");
   $nbrL=mysql_num_rows($req);
   while($a=@mysql_fetch_object($req))
    {
	$x++;
    $PO =$a->PO;
    $OF =$a->OF;
	$produit=$a->produit;
	$dateL =$a->date_lance;
	$dateF=$a->date_fin;
	$dateE=$a->date_exped_conf;
	$qte=$a->qte;
	$nbr=$a->nbr_plan;
	$statut=$a->statut;
	
	$req1= mysql_query("SELECT qte_p FROM plan1 where OF='$OF'");
	$qte_p=mysql_result($req1,0);

	echo('<tr id='.$x.'><td style="width:10%;height:40px;text-align:center" class="tdTab">'.$OF.'</td>
	<td  style="width:15%;height:40px;text-align:center">'.$PO.'</td>
	<td  style="width:15%;height:40px;text-align:center">'.$produit.'</td>
	<td style="width:8%;height:40px;text-align:center">'.$qte.'</td>
	<td style="width:8%;height:40px;text-align:center">'.$nbr.'</td>
	<td style="width:8%;height:40px;text-align:center">'.$qte_p.'</td>
	<td style="width:12%;height:40px;text-align:center">'.$dateL.'</td>
	<td style="width:12%;height:40px;text-align:center">'.$dateE.'</td>
	<td style="width:12%;height:40px;text-align:center">'.$statut.'</td>
	');
	/*echo ("<td style=\"text-align:center;width:5%;height:60px\"><a href=\"#\" onClick=deleteFile('".$nF."','".$T."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>");*/
	}


     echo '   </tbody>
 </table>   
 </div> 

 </div> 
  
 </form>
 </div> 
 </div> 
 
</div> 
</div> 
</div> ';

