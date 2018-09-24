<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
}
?>
<html>
<head>
<meta charset="utf-8" />

<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>
<title>
Consulter ordre d'achat
</title>
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
			   
function excelCommande(){
	document.form1.action="../php/excel_commandeItems.php";
    document.form1.submit(); 
}			   
</SCRIPT> 
</head>

<body>



<div id="main">



<div id="page-wrapper">
       

<form  id="form1" name="form1" method="POST">
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

  
	
          <input type="text" class="search form-control"  placeholder="Search " id="search" name="search" onkeyup="mySearch()">
	
          </div>


 <div class="pull-right col-lg-1">
<img src="../image/excel.png"  alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p> 
 </div>

 </div>
                
					
						  
  <br><br>	
  <br><br>	
                             
                         
							



<div class="table-responsive col-lg-12" id="divRel">
<table class="table table-fixed table-bordered results" id="table3">
<thead style="width:100%">
          
			<tr>
               
				<th style="width:6.5%;height:60px" class="degraD2">Order N°</th>
				<th style="width:18.7%;height:60px" class="degraD2">Supplier</th>			  
				<th style="width:13.8%;height:60px" class="degraD2">Item</th>			  
				<th style="width:9.9%;height:60px" class="degraD2">QTY demand</th>					  
				<th style="width:9.9%;height:60px" class="degraD2">Received</th>					  
				<th style="width:10%;height:60px" class="degraD2">Received date</th>					  
				<th style="width:9.9%;height:60px" class="degraD2">Unit price</th>					  
				<th style="width:9.9%;height:60px" class="degraD2">Price</th>					  
				<th style="width:8.9%;height:60px" class="degraD2">Statut</th>			  
						  
            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%">
<?php
   $x=0;
		    
	 
   $req= mysql_query("SELECT * FROM ordre_achat_article1  order by IDordre DESC");
   $nbrL=mysql_num_rows($req);
   while($a=@mysql_fetch_array($req))
    {
	$x++;
    $IDordre =$a['IDordre'];    
	
	
	$req1= mysql_query("SELECT * FROM ordre_achat2 where IDordre='$IDordre'");
	while($data=@mysql_fetch_array($req1)){
	$dateR=$data['date_recep'];
	if($dateR==""){
	$dateR="------";
	}
	echo('<tr id='.$x.'>
	<td style="width:6.6%;height:60px;text-align:center" class="tdTab">'.$IDordre.'</td>
	<td  style="width:19%;height:60px;text-align:center">'.$data['fournisseur'].'</td>
	<td  style="width:14.1%;height:60px;text-align:center">'.$a['IDarticle'].'</td>
	<td style="width:10%;height:60px;text-align:center">'.$a['qte_demande'].'</td>
	<td style="width:10.1%;height:60px;text-align:center">'.$a['qte_recue'].'</td>
	<td style="width:10.1%;height:60px;text-align:center">'.$dateR.'</td>
	<td style="width:10.1%;height:60px;text-align:center">'.$a['prix_unitaire'].'</td>
	<td style="width:10%;height:60px;text-align:center">'.$a['prix_total'].'</td>
	<td style="width:9%;height:60px;text-align:center">'.$data['statut'].'</td>

	');
	}
	
	}
?>

        </tbody>
 </table>   
 </div> 


  


 </div> 
 </div> 
 
</div> 
</div> 
</div> 

	</div>
	 </form>
    </div>

                    
                    </div>
</body>

</html>