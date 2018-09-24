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
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../theme/dist/js/sb-admin-2.js"></script>
<link href="../theme/dist/css/timeline.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
<script src="../theme/bower_components/metisMenu/dist/metisMenu.min.js"></script>
<title>Payment information</title>
<script> 
function afficheTT() {

//Affichage de tt 
var listItem = $('.results tbody').children('tr');
var jobCount = $('.results tbody').children('tr').length;
	 
for (var iter = 1; iter <= jobCount; iter++) {

 var nIter1="."+iter;
 $(nIter1).attr('visible','true');
}
 }  	
	 //
function mySearch(S) {


var listItem = $('.results tbody').children('tr');
var jobCount = $('.results tbody').children('tr').length;
 S="#"+S;
var searchTerm = $(S).val();
searchTerm=searchTerm.toUpperCase();

	 
for (var iter = 1; iter <= jobCount; iter++) {

 var nIter1="."+iter;
 var val=$(nIter1).html();
 val=val.toUpperCase();
   if (val.indexOf(searchTerm) >= 0){
   $(nIter1).attr('visible','true');
   }else{
   $(nIter1).attr('visible','false');
   }
}
} 
     //
 
      //
     function pop_up(url){
     window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=500,height=900,directories=no,location=no') 
     } 
	
///
function changePage(){
	document.location.href="../pages/consult_payment_fournisseur.php";
}	
</script> 
</head>

<body >

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


<div class="container">

<?php
include('../connexion/connexionDB.php');
if(isset($_POST['IDpay'])){
$IDpay=$_POST['IDpay'];
$_SESSION['IDpay']=$IDpay;	
}
else{
	$IDpay=$_SESSION['IDpay'];
	$sql1 = mysql_query("SELECT * FROM payment_fournisseur where IDpay='$IDpay'");
	$data1=mysql_fetch_array($sql1);

}
?>

<div id="page-wrapper">
<div class="row">
<div class="col-lg-12">
    <h1 class="page-header">
	<?php echo $data1['IDpay']; ?> 
	<img src="../image/change.png" onclick="changePage();" style="float:right;cursor:pointer;" alt="Print" width="60" height="50"  />
	</h1>
</div>


<div class="col-lg-12" id="ALLfiles"> 
<form  id="form1" name="form1">	  

<div  id="divRel">
  <ul class="nav nav-tabs">
        <li class="active" onClick="afficheTT();"><a href="#inf" data-toggle="tab">Information generale</a></li>
    
        <li onClick="afficheTT();"><a href="#achat" data-toggle="tab" >Achat</a></li>
        <li onClick="afficheTT();"><a href="#cnC" data-toggle="tab" >Credit note Client</a></li>                                    
                                        
  </ul>
<div class="tab-content">
 <!--inf-->
<div class="tab-pane fade in active" id="inf" onClick="afficheTT();">
<br><br>
<div class="row">
<div class="col-lg-12">

<div class="col-lg-6"> 
  <div class="form-group">
  
 
  </div> 
  <div class="form-group">
  <label>Date payment</label>
  <input type="text" class="form-control"   value="<?php echo $data1['dateP'] ;?>" Readonly>                     
  </div>
  <div class="form-group">
  <label>Date entrée payment</label>
  <input type="text" class="form-control" value="<?php echo $data1['dateE'] ;?>" Readonly>                     
  </div>
 
  <div class="form-group">
  <label>Fournisseur</label>
  <input type="text" class="form-control" value="<?php echo $data1['fournisseur']; ?>" Readonly>                     
  </div>
  <div class="form-group">
  <label>Compte</label>
  <input type="text" class="form-control" value="<?php echo $data1['compte'];?>" Readonly>                     
  </div>
 </div>
<div class="col-lg-6">  
  
  <?php
       $IDoperateur=$data1['operateur'];
	   $sql2 = mysql_query("SELECT nom FROM users1 where ID='$IDoperateur'");
	   $operateur=mysql_result($sql2,0);
    ?>
  
    <div class="form-group">
    <label>Operateur</label>
    <input type="text" class="form-control" value="<?php echo $operateur ?>" Readonly>                     
    </div>

    <div class="form-group">
    <label>Montant</label>
    <input type="text" class="form-control" value="<?php echo $data1['solde'];?>" Readonly> 
  </div>
  <div class="form-group">
    <label>Note</label>
    <textarea class="form-control" rows="5" Readonly><?php echo $data1['note'];?></textarea> 
  </div> 


</div> 


	
</div><!--row -->	


 </div> 
 </div> 

 

<div class="tab-pane fade" id="achat">
<div class="table-responsive">
<br><br>


 	
<?php
$x=0;
$req2=mysql_query("SELECT * FROM supplier_invoice where IDpay='$IDpay' and typeI != 'Credit'");
$sommeAchat=0;
echo " <div class=\"pull-left col-lg-4\">		
<input type=\"text\" class=\"search form-control\" id=\"search3\" placeholder=\"Search\" onkeyup=mySearch('search3')>	
</div>";
echo '<br><br><br><br>
<div class="col-lg-12">
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
              <th style="width:19.7%;height:40px">Facture N°</th>
               <th style="width:14.7%;height:40px">Date facturation</th>
               <th style="width:14.8%;height:40px">Date payment</th>
				<th style="width:19.8%;height:40px">Montant</th>
				<th style="width:14.8%;height:40px">Devise</th>	  
				<th style="width:14.8%;height:40px">Type</th>	  
            </tr>
          </thead>
<tbody  style="width:100%">'; 
while($a2=@mysql_fetch_array($req2))
    {
    $x++;	
	echo('<tr class='.$x.'>
	<td style="width:20%;height:40px">'.$a2['IDinvoice'].'</td>
	<td  style="width:15%;height:40px">'.$a2['dateE'].'</td>
	<td  style="width:15%;height:40px">'.$a2['dateP'].'</td>
	<td  style="width:20%;height:40px">'.$a2['total'].'</td>
	<td  style="width:15%;height:40px">'.$a2['currency'].'</td>
	<td  style="width:15%;height:40px">'.$a2['typeI'].'</td>');
	$totAchat=$a2['total'];
	$sommeAchat=$sommeAchat+$totAchat;
	}
	echo '<tr><td><b>Total : '.$sommeAchat.'</b></td></tr></tbody> </table></div>  ';

 ?>

 </div> 
 </div>  
 <!--Credit note client-->
<div class="tab-pane fade" id="cnC">
<div class="table-responsive">
<br><br>


 	
<?php
//$x=0;
$sommeCNC=0;
$req2=mysql_query("SELECT * FROM supplier_invoice where IDpay='$IDpay' and typeI = 'Credit'");
echo " <div class=\"pull-left col-lg-4\">		
<input type=\"text\" class=\"search form-control\" id=\"search5\" placeholder=\"Search\" onkeyup=mySearch('search5')>	
</div>";
echo '<br><br><br><br>
<div class="col-lg-12">
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
              <th style="width:24.7%;height:40px">Facture N°</th>
               <th style="width:19.7%;height:40px">Date facturation</th>
               <th style="width:19.8%;height:40px">Date payment</th>
				<th style="width:19.8%;height:40px">Montant</th>
				<th style="width:14.8%;height:40px">Devise</th>	  
				
            </tr>
          </thead>
<tbody  style="width:100%">'; 
while($a2=@mysql_fetch_array($req2))
    {
    $x++;	
	echo('<tr class='.$x.'>
	<td style="width:25%;height:40px">'.$a2['IDinvoice'].'</td>
	<td  style="width:20%;height:40px">'.$a2['dateE'].'</td>
	<td  style="width:20%;height:40px">'.$a2['dateP'].'</td>
	<td  style="width:20%;height:40px">'.$a2['total'].'</td>
	<td  style="width:15%;height:40px">'.$a2['currency'].'</td>');
	$totCNC=$a2['total'];
	$sommeCNC=$sommeCNC+$totCNC;
	}
	echo '<tr><td><b>Total : '.$sommeCNC.'</b></td></tr></tbody> </table></div>  ';

 ?>

 </div> 
 </div> 
 
 
 </div>  

</div> 
</div> 
</form>
</div> 
 


</div> <!--row-->
    </div>

                    </div>
                    </div>
                    </div>
               
             
     

</body>

</html>