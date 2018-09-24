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
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>
<title>Accounting profits</title>
<SCRIPT> 
function afficheRevenu(){
   
   var d1 = document.getElementById("date1").value;
   var d2 = document.getElementById("date2").value;
   var liste = document.getElementById('recherche');
   var recherche = liste.options[liste.selectedIndex].value;
   var val = document.getElementById("valeur").value;
   var valeurs = [];
   $("input:checked[name=client]").each(function (box) {
	  valeurs.push($(this).val());
   });

   if(d1 != "" && d2 != ""){
    $('#OFD').html('<center><br><br> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center>');
    $.ajax({
        type: 'POST',
        data: 'date1='+d1 +'&date2='+d2 +'&recherche='+recherche +'&valeur='+val +'&client='+valeurs ,
        url: '../php/accounting_profit3.php',
        success: function(data) {
        $('#OFD').html(data);
       }});
  }else{
     bootbox.alert("Enter dates margin PLZ !!");
  }
  
}
//

function afficheRevenuTheo(){
   
   var d1 = document.getElementById("date1").value;
   var d2 = document.getElementById("date2").value;
   var liste = document.getElementById('recherche');
   var recherche = liste.options[liste.selectedIndex].value;
   var val = document.getElementById("valeur").value;
   var cat=$("input[name='cat']:checked"). val();
   
   var valeurs = [];
   $("input:checked[name=client]").each(function (box) {
	  valeurs.push($(this).val());
   });

   if(d1 != "" && d2 != ""){
    $('#OFD').html('<center><br><br> <img src="../image/load.gif"  alt="Print" style="cursor:pointer;" width="300" height="250"/></center>');
    $.ajax({
        type: 'POST',
        data: 'date1='+d1 +'&date2='+d2 +'&recherche='+recherche +'&valeur='+val +'&client='+valeurs+'&cat='+cat ,
        url: '../php/accounting_profit_theo.php',
        success: function(data) {
        $('#OFD').html(data);
       }});
  }else{
     bootbox.alert("Enter dates margin PLZ !!");
  }
  
}
/////
function afficheZone(){

 var liste = document.getElementById('recherche');
  var recherche = liste.options[liste.selectedIndex].value;
  if(recherche !="cat"){
 if(recherche =="a"){
  $('#zone').html('<input type="text" id="valeur" class="form-control" name="valeur" DISABLED> ');
  }else{
  $('#zone').html('<input type="text" id="valeur" name="valeur" class="form-control"> ');
  }
  }else{
		
	    $('#zone').html('<select name="valeur" id="valeur"  style="width:220px" class="form-control" ><option value="s">---Category</option> </select> ');
        $.ajax({
        type: 'POST',
      
        url: '../php/listeCatProduit.php',
        success: function(data) {
        $('#valeur').html(data);
       }});
	   
}
}

//Fichier excel
function excelProfit(){
	//document.form1.action="../php/excel_accounting_profit.php";
    document.form1.action="../php/excel_accounting_profit_theo.php";
    document.form1.submit(); 
}
//Print Invoice
function printProfit(){
	document.form1.action="../tcpdf/print_accounting_profit.php";
    document.form1.submit(); 
}
//
function rapport_sortie(OF,dateE){
    //bootbox.alert(OF);
    
    $.ajax({
        type: 'POST',
        data: 'OF='+OF+'&dateE='+dateE,
        url: '../php/accounting_profit_rapport.php',
        success: function(data) {
        bootbox.alert(data);
       }});
 
}
</SCRIPT> 
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
                <div class="col-lg-12">
                    <h1 class="page-header">Accounting profits </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>

<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
        Consult accounting profits
 </div>
 <div class="panel-body" >
     <form role="form" method="post" name="form1" id="form1">
	   <div class="well">
  <div class="row">

  <p style="float:right"><img src="../image/print.png" onclick="printProfit();" alt="Print" style="cursor:pointer;" width="60" height="50"  />
<img src="../image/excel.png" onclick="excelProfit();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p>
     <div class="col-lg-6">
                                
        <div class="form-group">
		
        <label>Date:</label>
		<div class="form-inline">
        <input class="form-control" id="date1" name="date1" type="date"  >
		<input class="form-control" id="date2" name="date2" type="date"  >
       
		</div>
        </div>
										
		

        <div class="form-group">
		
        <label>Filtre by:</label>
		<div class="form-inline">
        <select name="recherche" id="recherche" onChange="afficheZone();" class="form-control">
             <option value="a">ALL</option>			
	         <option value="PO">Purchase order</option> 
			 <option value="produit">Item</option> 		     
			                              
        </select>
       
         <span id="zone">
		<input class="form-control" name="valeur" id="valeur" DISABLED>	 
		</span>
        </div>		
        </div>	

        <div class="form-group">
            <div class="radio-inline">
                <label><input type="radio" name="cat" id="S1" value="A">ALL </label>
			</div>
			<div class="radio-inline">
                <label><input type="radio" name="cat" id="S2" value="C" checked>Cable </label>
			</div>
            <div class="radio-inline">
                <label><input type="radio" name="cat" id="S2" value="Q">Quick FIT</label>
			</div>
	
	
        </div>

        <input type="button" class="btn btn-primary" value="Search >>"  onclick="afficheRevenu();"> 
        <input type="button" class="btn btn-danger" value="Current margins >>"  onclick="afficheRevenuTheo();">		
        </div>		
        <div class="col-lg-6">	
             <div class="form-group">
  		      <label>Clients</label>
			  <div class="form-group">
			  <?php
			  include('../connexion/connexionDB.php');
			  $sql = "SELECT name_client,nomClient FROM client1";
			  $res = mysql_query($sql) or exit(mysql_error());
			  $i=0;
			  while($data=mysql_fetch_array($res)) {
			      $i++;
                  $nom="C".$i;
                  $id=$data['name_client'];
                  if($id=='1004' || $id=='1003'){				  
                    echo '<input type="checkbox" name="client" id='.$nom.' value='.$data['name_client'].' checked>'.$data["nomClient"].' <br/>'; 
				  }else{
				    echo '<input type="checkbox" name="client" id='.$nom.' value='.$data['name_client'].'>'.$data["nomClient"].'<br/>'; 
				  }
			  }
              mysql_close();
			  ?>
			  </div>
			 </div>		
        </div>		
	</div>
	</div>

	



<div id="OFD"></div>
	</form>



</div>
</div>
</div>
</div>
</div>

</div>

<!--fin -->



</div>


</div>
</body>

</html>