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
	<link href="../tablecloth/table.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/style.css"/>
	<script src="../jquery/jquery-latest.min.js"></script>
	<script src="../jquery/jqueryDataTable.min.js"></script>
	<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
	<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
	<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
	<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
	<script src="../bootstrap/js/bootstrap.min.js"></script>
	<script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
	<script src="../bootstrap/js/bootbox.min.js"></script>
	<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<title>Trnsaction compte client</title>
<script>
	function chekTransC(IDtrans,div){
	bootbox.confirm("Voulez vous vraiment confirmer la transaction !", function(result){ 
    if(result){
	$.ajax({
        type: 'POST', 
        data:'IDtrans=' + IDtrans,		
        url: '../php/validation_transaction.php',
        success: function(data) {
            //listeTransC();
             var demo='#'+div;			
            $(demo).load(location.href +" "+demo);			
    }}); 
   }else{
	document.getElementById(IDtrans).checked=false;
   }
   });
   }	   
</script> 
</head>
<body>

<div id="entete">
<div id="logo">
</div>
<div id="boton">
<?php 
include('../include/logOutIMG.php');
?>	
</div>
</div>

<div id="main">
<div id="menu">
<?php
if($role=="ADM"){
include('../menu/menuAdmin.php');	
}
elseif($role=="FIN"){
include('../menu/menuFinance.php');	
}elseif($role=="DIR"){
include('../menu/menuDirecteur.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>

<div id='contenu'>
<div class="container" >
<div id="page-wrapper">
<div class="row">
     <div class="col-md-12">
        <h1 class="page-header">Transaction </h1>
     </div>              
</div>
<form role="form" method="post" name="form1" id="form1">
  <div class="row">
     <div class="col-md-6" >
       <div class="panel panel-default">
        <div class="panel-heading"> Transaction Compte STARZ EUR BNA</div>
          <div class="panel-body" >                
				    <table  class="table table-fixed results table3" id="tab1">
					    <thead style="width:100%">       
			            <tr>
						<th style="width:9.9%;height:60px;text-align:center">Mode</th>
						<th style="width:14.8%;height:60px;text-align:center">REF</th>
						<th style="width:14.8%;height:60px;text-align:center">Date</th>
						<th style="width:34.8%;height:60px;text-align:center" >Catégorie</th>						
						<th style="width:14.8%;height:60px;text-align:center">Montant</th>
						
						<th style="width:9.8%;height:60px;text-align:center"></th>				
						
				        </tr>
				        </thead>
			            <tbody id="tbody3"  style="width:100%" >
						 <?php
						 include('../connexion/connexionDB.php');
						 $req= "SELECT modeT,ref,catT,description,montant,IDtrans,compte,etat,dateT FROM transaction_compte WHERE  (((catT LIKE 'C.Scope') or (catT LIKE 'CommeScope') or (catT LIKE 'TYCO')) and (verif='N') and (compte='STARZ EUR BNA'))";
						 $r=mysql_query($req) or die(mysql_error());
						 while($a=mysql_fetch_array($r)){ 
						   $IDtrans=$a['IDtrans'];
						   $compte=$a['compte'];
						   $montant=$a['montant'];
						   $etat=$a['etat'];
						   if($etat=='AN'){
		                    $montant=0;
						   }
						   $req1= mysql_query("SELECT devise FROM compte_banque WHERE  REFcompte ='$compte'");
						   $devise=mysql_result($req1,0);
						  echo ('<tr>
						   <td  style="width:10%;height:70px;text-align:center">'.$a['modeT'].'</td>
						   <td  style="width:15%;height:70px;text-align:center">'.$a['ref'].'</td>
						   <td  style="width:15%;height:70px;text-align:center">'.$a['dateT'].'</td>
						   <td  style="width:35%;height:70px;text-align:center">'.$a['catT'].' : '.$a['description'].'</td>
						   <td  style="width:15%;height:70px;text-align:center">'.$montant.' '.$devise.'</td>
						   ');
						   echo "<td  style=\"width:10%;height:70px;text-align:center\"><input type=\"checkbox\" id=\"".$IDtrans."\" onClick=chekTransC('".$IDtrans."','tab1')></td>
		                   </tr>";
		
	                    }
                       
                        ?>
						</tbody>
					</table>		
            </div>
		</div>
     </div>
 
	
	
     <div class="col-md-6" >
       <div class="panel panel-default">
        <div class="panel-heading"> Transaction Compte STARZ EUR BIAT</div>
          <div class="panel-body" >                
				    <table  class="table table-fixed results table3" id="tab2">
					    <thead style="width:100%">       
			            <tr>
						<th style="width:9.9%;height:60px;text-align:center">Mode</th>
						<th style="width:14.8%;height:60px;text-align:center">REF</th>
						<th style="width:14.8%;height:60px;text-align:center">Date</th>
						<th style="width:34.8%;height:60px;text-align:center" >Catégorie</th>						
						<th style="width:14.8%;height:60px;text-align:center">Montant</th>						
						<th style="width:9.8%;height:60px;text-align:center"></th>
						
						
						
				        </tr>
				        </thead>
			            <tbody id="tbody4"  style="width:100%" >
						 <?php
						
						 $req= "SELECT modeT,ref,catT,description,montant,IDtrans,compte,etat,dateT FROM transaction_compte WHERE  (((catT LIKE 'C.Scope') or (catT LIKE 'CommeScope') or (catT LIKE 'TYCO')) and (verif='N') and (compte='STARZ EUR BIAT'))";
						 $r=mysql_query($req) or die(mysql_error());
						 while($a=mysql_fetch_array($r)){ 
						   $IDtrans=$a['IDtrans'];
						   $compte=$a['compte'];
						   $montant=$a['montant'];
						   $etat=$a['etat'];
						   if($etat=='AN'){
		                    $montant=0;
						   }
						   $req1= mysql_query("SELECT devise FROM compte_banque WHERE  REFcompte ='$compte'");
						   $devise=mysql_result($req1,0);
						   echo ('<tr>
						   <td  style="width:10%;height:70px;text-align:center">'.$a['modeT'].'</td>
						   <td  style="width:15%;height:70px;text-align:center">'.$a['ref'].'</td>
						   <td  style="width:15%;height:70px;text-align:center">'.$a['dateT'].'</td>
						   <td  style="width:35%;height:70px;text-align:center">'.$a['catT'].' : '.$a['description'].'</td>
						   <td  style="width:15%;height:70px;text-align:center">'.$montant.' '.$devise.'</td>
						   ');
						   echo "<td  style=\"width:10%;height:70px;text-align:center\"><input type=\"checkbox\" id=\"".$IDtrans."\" onClick=chekTransC('".$IDtrans."','tab2')></td>
		                   </tr>";
		
	                    }
                        mysql_close(); 
                        ?>
						</tbody>
					</table>		
            </div>
		</div>
     </div>
   <!-- </div>-->
  </form>

</div>
</div>
</div><!--Contenu -->
</div><!--main-->

</body>
</html>