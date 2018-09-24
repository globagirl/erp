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
<title>Heure d'allaitement</title>
<script>

function ajoutHA(){

 var mat = document.getElementById("matricule").value;
 var nbrH = document.getElementById("nbrH").value;
 var dateD = document.getElementById("dateD").value;
 var dateF = document.getElementById("dateF").value;
 $.ajax({
        type: 'POST',
        data: 'matricule='+mat+'&nbrH='+nbrH +'&dateD='+dateD+'&dateF='+dateF,
        url: '../php/heure_allaitement.php',
        success: function(data) {
		  bootbox.alert(data);
		  window.location.reload();
          /*document.getElementById("matricule").value="";
          document.getElementById("nbrH").value="";
          document.getElementById("dateD").value="";
          document.getElementById("dateF").value="";*/
       }});
	  
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
elseif($role=="GRH"){
include('../menu/menuGRH.php');	
}elseif($role=="DIR"){
include('../menu/menuDirecteur.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
 <?php
$date=date("Y-m-d");
$date= strtotime($date);
$year= strftime("%Y",$date);
 ?>
<div id='contenu'>
<div class="container" >
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
        <h1 class="page-header">Heure d'allaitement</h1>
     </div>              
</div>
<div class="row">
<div class="col-lg-4" >
<div class="panel panel-default">
<div class="panel-heading">  Ajout </div>
<div class="panel-body" >
  <form role="form" method="post" name="form1" id="form1">
	 

	     <div class="col-lg-12"> 
		
		   <div class="form-group">
		      
			    <label>Matricule:</label>	
				<input type="text" size="10" placeholder="Matricule personnel" name="matricule" id="matricule"  class="form-control">
			
		   </div>
           <div class="form-group">
		     <label>Date debut:</label>	
           	
               <input class="form-control" id="dateD" name="dateD" type="date"> 
		     
		      
            
           </div><div class="form-group">
		     <label>Date Fin:</label>	
           	
		       <input class="form-control" id="dateF" name="dateF" type="date">		
		      
            
           </div>	
           <div class="form-group">
		      
			    <label>Nombre d'heure par jour:</label>	
				<input type="text" size="10" placeholder="Nbr" name="nbrH" id="nbrH"  class="form-control">
			
		   </div>		   
           
		</div>
		
        <div class="col-lg-12">
           <input type="button" class="btn btn-primary" value="Ajouter >>"  onclick="ajoutHA()"> 		
          	
		</div>
     

  </form>
</div>
</div>
</div><!-- Fin panel ajout -->
<div class="col-lg-8" >
<div class="panel panel-default">
<div class="panel-heading">Consulter</div>
<div class="panel-body" >
       <table  class="table table-fixed results" id="table3">
					    <thead style="width:100%">       
			            <tr>
						<th style="width:14.9%;height:60px;text-align:center">Matricule</th>
						<th style="width:34.8%;height:60px;text-align:center">Nom & prenom</th>
						<th style="width:19.8%;height:60px;text-align:center">Debut</th>
						<th style="width:19.8%;height:60px;text-align:center" >Fin</th>						
						<th style="width:9.8%;height:60px;text-align:center">nbr heure</th>
						
						
						
						
				        </tr>
				        </thead>
			            <tbody id="tbody3"  style="width:100%" >
						<?php 
						include('../connexion/connexionDB.php');
						$req= "SELECT matricule,dateD,dateF,nbrH FROM personnel_heure_allait";	
						$r=mysql_query($req) or die(mysql_error());
						while($a=@mysql_fetch_array($r)){ 
						$matricule=$a['matricule'];
						$req1= mysql_query("SELECT nom FROM personnel_info WHERE  matricule ='$matricule'");
						$nom=mysql_result($req1,0);
						echo ('<tr>
						<td  style="width:15%;height:70px;text-align:center">'.$matricule.'</td>
						<td  style="width:35%;height:70px;text-align:center">'.$nom.'</td>
						<td  style="width:20%;height:70px;text-align:center">'.$a['dateD'].'</td>
						<td  style="width:20%;height:70px;text-align:center">'.$a['dateF'].'</td>
						<td  style="width:10%;height:70px;text-align:center">'.$a['nbrH'].'</td></tr>');

		
	                    }
                         mysql_close(); 
						?>
						</tbody>
					</table>
</div>
</div>
</div><!-- fin panel consult -->
</div>
</div>
</div>
</div>
</div>
</body>
</html>