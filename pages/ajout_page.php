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
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>
<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
<title>
Gestion des ordres d'achat
</title>
<script>
var i=1;

//Ajout Nouvelle zone Item
function addZone(){
var Z2="#Z"+i;
i++;
document.getElementById('nbr').value=i;
var Z="Z"+i;

		var Q="Q"+i;
		var D="D"+i;
$(Z2).after('<div class="col-lg-12" id='+Z+'><div class="form-group col-lg-2"><label>Date prévue</label><input class="form-control" type="date" name='+D+'></div><div class="form-group col-lg-2"> <label>Quantité</label> <input class="form-control" name='+Q+'></div></div>');

}
///DELTE ITEM 
	function deleteZone(){
	   
    if(i>1){
	var DD="#Z"+i;
			$(DD).remove();
   	     i--;
        document.getElementById('nbr').value=i;
     }

}


//
function listeArticle(){
var X=  document.getElementById('IDordre').value;

$.ajax({
        type: 'POST',
        data: 'IDordre='+X,	
        url: '../php/listeArticleP.php',		
        success: function(data) {
		$("#listeART").html(data);
		 }});
		 
		
 }//
 
function qteDemande(){
var X=  document.getElementById('IDordre').value;
 var liste1 = document.getElementById("listeART");
 var val = liste1.options[liste1.selectedIndex].value;
$.ajax({
        type: 'POST',
        data: 'IDordre='+X+'&art='+val,	
        url: '../php/qteDemandeP.php',		
        success: function(data) {
		$("#zone1").append(data);
		 }});
		 
		
 }


</script>
</head>

<body onLoad="affichelisteC();">
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

elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
else{
session_unset();
   session_destroy();
	 header('Location: ../deny.php');
}
?>
</div>
<?php
include('../connexion/connexionDB.php');
?>
<div id='contenu'>
   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Documentation</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
			<form id="form1" name="form1" method="POST" action="../php/ordre_prevision.php">
            <div class="row">
                <div class="col-lg-12">     
        
										<div class="panel panel-default">
										<div class="panel-heading">
                                         ADD new page
                                        </div>
										  <div class="panel-body">	
				
								       <div class="col-lg-4">
								       <div class="form-group">
                                            <label>Page name</label>
                                            <input class="form-control" id="nom" name="nom" onBlur="listeArticle()" placeholder="Page name" >
                                            <p class="help-block">Exemple:new_page.php</p>											
                                       
										</div>
										
										<div class="form-group col-lg-4">
                                            <label>Description</label>
                                             <textarea class="form-control" rows="3" name="desc" id="desc"></textarea>                                     
                                        </div>
                     
                            			
<div  class="well well-sm col-lg-12">
								<div class="col-lg-12 " id="zone1">
								 <h4><b>Ancienne prevision:</b></h4>
</div>								 
</div>								 
                                <div  class="well well-sm col-lg-12" id="zone">
								
								<div class="col-lg-12 " id="Z1">
								
								<div class="form-group col-lg-2">
                                            <label>Date prévue</label>
                                            <input class="form-control" type="date" name="D1">                                         
                                       
										</div>
										
										<div class="form-group col-lg-2">
                                            <label>Quantité</label>
                                             <input class="form-control" name="Q1">                                         
                                        </div>
										<div class="form-group col-lg-2">
										 <br>
                                            <button type="button" class="btn btn-primary" onClick="addZone()">+</button>                                    
                                            <button type="button" class="btn btn-primary" onClick="deleteZone()">-</button>                         
                                            <input type="text" id="nbr" name="nbr" value="1" HIDDEN>                        
                                        
                                </div>
                             </div>								
							</div>
							<div  class="well well-sm col-lg-12" >
                   <div  class=" col-lg-3" >
                         <button type="submit" class="btn btn-primary" >Submit >></button>                                    
                                            <button type="reset" class="btn btn-primary" onClick="deleteZone()">Reset >></button>
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