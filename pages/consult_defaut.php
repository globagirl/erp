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
<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="../tablecloth/tablecloth.js"></script>
<link rel="stylesheet" type="text/css" href="../css/style.css"/>
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link rel="stylesheet" href="../CSS/mbcsmbmcp.css" type="text/css" />
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>


<title>
Liste des défauts
</title>
<script>

function afficheD(){
	
var d1 = document.getElementById("date1").value;



$.ajax({
        type: 'POST',
        data: 'date1='+d1,
        url: '../php/consult_defaut.php',
        success: function(data) {
        $('#div1').html(data);
		
       }});
	   
}	   

////

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

elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}elseif($role=="QLT"){
include('../menu/menuQualite.php');	
}
else{

	 header('Location: ../deny.php');
}
?>
</div>
<?php
include('../connexion/connexionDB.php');
?>
<div id='contenu'>

<div class="container" >
<div id="page-wrapper">
<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Total des défauts   </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>



<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          Nombre des défauts journalier  
 </div>
 <div class="panel-body" >

<form method="post"  id="form1">
<div class="row">  
         
                    
                   
                    <div class="col-md-12"> 
					 
					<div class="form-group col-md-6 form-inline"> 
                    <label class="control-label col-md-2" for="date1">Date : </label> 
                    
					
                    <input id="date1" name="date1" type="date" class="col-md-4 form-control input-md"> 
					 <input  type="button"  onClick="afficheD();" class="btn btn-default col-md-1" id="b1" value=">>">
                  </div>
					
                   
					
					 
                    </div>
      
	
	

<div class="col-md-12" id="div1">
  <?php
   

   echo'
   <br>
   <br>
   <div class="panel panel-default" >
  <div class="panel-heading">
   Totale Quantité produite:  ';
   

	echo '0</div>
	<div class="panel-body">';
	echo
	'
	<div class="row">
	<div class="col-md-12 well well-sm">
	<div class="col-md-2">
    Decoupage :
   </div>
  

	
	';
	
	echo'

 <div class="col-md-1">
	0</div></div>

	';
	
echo
	'
	<div class="col-md-12 well well-sm">
	<div class="col-md-2">
	Assemblage :

	</div>
	';

	
	
	echo'
	<div class="col-md-1">0</div></div>
	
	';
	
	
	
	echo
	'
	
<div class="col-md-12 well well-sm">
<div class="col-md-2">
	
   Sertissage:
   
  </div>
  
	
	';
		 

	
	
	echo '<div class="col-md-1">0</div></div>';

	
	
	echo '
	<div class="col-md-12 well well-sm">
	<div class="row">
	<div class="col-md-12">
	<div class="col-md-2">  Test Polarité </div>
	
	';
		 

	
	
	echo'<div class="col-md-1">0</div></div>
	<div class="col-md-12">
	<br>
	<div class="col-md-2">
	Qualité 
	</div>
	<div class="col-md-1">0</div>
	<div class="col-md-2"> Paire court circuit </div>
	<div class="col-md-1">0</div>
	<div class="col-md-2"> Continuité</div>	
	<div class="col-md-1">0</div>
	<div class="col-md-2"> Paire inversé </div>
	<div class="col-md-1">0</div>
	</div></div></div>';
	
	
	
	echo
	'
	
   <div class="col-md-12 well well-sm">
   <div class="col-md-2">
   Emballage :</div>
  
	
	';

	echo'
		  <div class="col-md-1">
    0</div>
	
	</div>';
	echo'
	</div>
	</div>

	<div class="panel-footer">
                          
		  <b>Nombre de defauts Total :</b>0
	
	</div>
	';
	
	
	echo '</div>';

 
	
  
  ?>


</div>
</div>
</form>
 </div>
 </div>
 </div>
</div>
</div>
</div>
</div>
</body>
</html>
