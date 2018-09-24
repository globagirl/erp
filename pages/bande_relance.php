<?php
session_start ();
if( !isset($_SESSION["role"]) ){
    header('Location: ../index.php');
    exit();
}else{
$role=$_SESSION['role'];
$userID=$_SESSION['userID'];
include('../connexion/connexionDB.php');
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


<title>Bande relance</title>
<script>

function affiche_zone(x){	
    var qte="qte"+x;
    var chek="chek"+x;    
    if(document.getElementById(chek).checked==false){
		document.getElementById(qte).readOnly=true;
		//alert(x);
	}else{
		document.getElementById(qte).readOnly=false;
	}
}
//
function affiche_articles(){	
	var recherche = document.getElementById('recherche').value;
	var valeur = document.getElementById('valeur').value;
  var dateD = document.getElementById('dateD').value;
  if(dateD!=""){
	  //document.getElementById('form1').submit();
	  $.ajax({
        type: 'POST',
        data : 'recherche=' +recherche+'&valeur=' +valeur,
        url: '../php/liste_articleBRL.php',
        success: function(data) {
			if(data=="1"){
				bootbox.alert("verifiez votre OF SVP  !! ");				
			}
			else{			
				$('#divART').html(data);
			}
			
       }});
  }else{
    bootbox.alert("Donnez la date de la demande SVP  !! ");		
  }
    
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
}else if($role=="CTRL"){
include('../menu/menuCTRL.php');	
}else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
  <div class="container" >
    <div id="page-wrapper">
      <div class="row">
          <div class="col-lg-6"><h1 class="page-header"> Bande relance </h1></div>          
      </div>
      <form role="form" method="post" name="form1" id="form1" action="../php/bande_relance.php">
        <div class="row">
          <div class="col-lg-12" >
            <div class="panel panel-default">
                <div class="panel-heading"> Ajout bande relance </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
						 
						    <div class="form-group ">
                  <label>Date demande: </label>
                  <div class="form-group form-inline">
                  <input type="date" class="form-control" id="dateD" name="dateD" required="required">
                  </div>
                </div>
                 <div class="form-group form-inline"> 
								<select class="form-control" name="recherche" id="recherche">     
									<option value="PO">PO</option>
									<option value="OF">Ordre fabrication</option>						            
								</select>
                 <input type="text" class="search form-control" id="valeur" name="valeur">
								<input type="button" onclick="affiche_articles();" class="btn btn-danger" Value=">>">
							</div>
						</div>
						
						<div class="col-lg-12" id="divART">
						</div>
					</div>
				</div>
			</div>
		  </div>
	
		</div>
				
			 
		
	<?php mysql_close(); ?>
</form>
</div>
</div>
</body>
</html>
