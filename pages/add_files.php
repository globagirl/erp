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


<!-- DOC --> 
<title>
ADD FILES
</title>



<script>
function addFile(){
	 var nameF=document.getElementById("nameF").value;
     var desc=document.getElementById("desc").value;
	 var liste1 = document.getElementById("type1");
     var type1 = liste1.options[liste1.selectedIndex].value;
     var liste1 = document.getElementById("type2");
     var type2 = liste1.options[liste1.selectedIndex].value;
         if(nameF==""){
			  alert("Selectionnez un fichier SVP!!");
			  
          } else if(desc==""){
			  alert("Donnez une description SVP!!");
			 
          } else if(type1=="s"){
			  alert("Selectionnez un type  SVP !!");
			  
          } else if(type2=="s"){
			  alert("Selectionnez un type  SVP !!");
			  
          }else{
			  document.forms['form1'].submit(); 
		  }
}


</script>
</head>

<body onload="afficheliste()">



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
elseif($role=="QLY"){
include('../menu/menuQualite.php');	
}elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
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
                    <h1 class="page-header">Management  </h1>
                </div>
                <!-- /.col-lg-12 -->
</div>



<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          ADD new file
 </div>
 <div class="panel-body" >
           <div class="col-lg-6">
                                    <form role="form" method="post" name="form1" id="form1" action="../php/add_files.php" enctype="multipart/form-data">
                                       <div class="form-group">
                                          <label>File</label>
                                            <input type="file" name="nameF" id="nameF">
                                        </div>
										
                                         <div class="form-group">
                                             
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="dossier" id="dossier1" value="RG45" checked>RG45
                                                </label>
                                            </div>
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="dossier" id="dossier2" value="UPM3">UPM3
                                                </label>
                                            </div>
                                           
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" rows="3" name="desc" id="desc"></textarea>
                                        </div>
                                     
                                        
                                       
                                        <div class="form-group">
                                                <label>File location</label>
                                                <select id="type1" name="type1" class="form-control">
                                                 <option value="s">---Selectionnez</option>
												 <option value="Quality">Quality</option>
												 <option value="Direction">Direction</option>
												 <option value="Commercial">Commercial</option>
												 <option value="Logistic">Logistic</option>
												 <option value="Production">Production</option>
												 <option value="IT">IT</option>
												 <option value="GRH">Humain ressource</option>
												 <option value="Maintenance">Maintenance</option>
                                                </select>
                                            </div>
											<div class="form-group" id="tdL">
                                                <label>Location</label>
                                                <select  name="type2" id="type2" class="form-control">
                                                 <option value="s">---Selectionnez</option>
												 <option value="Procedure">Procedure</option>
												 <option value="Process">Process</option> 
												 <option value="Registry">Registry</option>
												 <option value="Model">Model</option> 
												 <option value="Instruction">Instruction</option>
												 <option value="Form">Form</option>
												 <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        <button type="submit" class="btn btn-default" onClick="addFile();">Submit </button>
                                        <button type="reset" class="btn btn-default">Reset </button>
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