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
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootstrapDataTable.min.js"></script>
<link href="../bootstrap/css/bootstrapDataTable.min.css" rel="stylesheet">
<script src="../bootstrap/js/bootbox.min.js"></script>
<title>Compte bancaire</title>
<script> 
    function mySearch(){
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
}else if($role=="FIN"){
    include('../menu/menuFinance.php');	
}else if($role=="GRH"){
    include('../menu/menuGRH.php');
}else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>
<div class="container">


   <div id="page-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Compte bancaire </h1>
                </div>
                <!-- /.col-md-12 -->
            </div>


	 
<div class="row">
 <div class="col-md-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          Liste des comptes     
 </div>
 <div class="panel-body" >

 <form  id="form1" name="form1">
 <div class="row">
        
		  <div class="pull-left col-md-4">		
          <input type="text" class="search form-control"  placeholder="Search " onkeyup="mySearch()">
	
          </div>




					
						  
  <br><br>	
  <br><br>	
                             
                         
							


<div class="col-md-12">

<div class="table-responsive" id="divRel">
<table class="table table-fixed table-bordered results" id="table3">
<thead style="width:100%">
          
			<tr>
               <th style="width:19.7%;height:60px" class="degraD">REF compte</th>
				<th style="width:19.7%;height:60px" class="degraD">NUM compte</th>
				<th style="width:19.7%;height:60px" class="degraD">Banque</th>			  
				<th style="width:19.7%;height:60px" class="degraD">Solde</th>			  
				<th style="width:9.9%;height:60px" class="degraD">Devise</th>			  
				<th style="width:9.9%;height:60px" class="degraD">Etat</th>			  
						  
						  
            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%">
<?php

		    
	$x=0;
    $req= mysql_query("SELECT * FROM compte_banque");
    while($a=@mysql_fetch_array($req)){
	$x++;
    $etat=$a['etat'];
	if($etat=='F'){
	    $etat='Fermé';
	}else{
	    $etat='Ouvert';
	}

	echo('<tr id='.$x.'>
	<td style="width:20%;height:60px;text-align:center">'.$a['REFcompte'].'</td>
	<td  style="width:20%;height:60px;text-align:center">'.$a['NUMcompte'].'</td>
	<td  style="width:20%;height:60px;text-align:center">'.$a['banque'].'</td>
	<td style="width:20%;height:60px;text-align:center">'.$a['soldeR'].'</td>
	<td style="width:10%;height:60px;text-align:center">'.$a['devise'].'</td>
	<td style="width:10%;height:60px;text-align:center">'.$etat.'</td>
	</tr>');

	}
?>

        </tbody>
 </table>   


 </div> 
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
                    </div>
</body>

</html>