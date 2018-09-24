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
<title>
Calibration list
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
			   
function excelCalibration(){
	document.form1.action="../php/excel_commandeItems.php";
    document.form1.submit(); 
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

elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}else if($role=="QLT"){
include('../menu/menuQualite.php');	
}


else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


   <div id="page-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">Calibration </h1>
                </div>
                <!-- /.col-md-12 -->
            </div>


<form  id="form1" name="form1" method="POST">
<div class="row">
 <div class="col-md-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          Calibration list   
 </div>
 <div class="panel-body" >
 <?php 
include('../connexion/connexionDB.php');

?>
<div class="row">
          <div class="col-md-12" >
		
		  <div class="pull-left col-md-4">	

  
	
          <input type="text" class="search form-control"  placeholder="Search " id="search" name="search" onkeyup="mySearch()">
	
          </div>


 <div class="pull-right col-md-1">
<img src="../image/excel.png" onclick="excelCommande();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p> 
 </div>

 </div>
                
					
						  
  <br><br>	
  <br><br>	
                             
                         
							



<div class="table-responsive col-md-12" id="divRel">
<table class="table table-fixed table-bordered results" id="table3">
<thead style="width:100%">
          
			<tr>
               
				<th style="width:8.7%;height:60px" class="degraD2">N°</th>
				<th style="width:20.7%;height:60px" class="degraD2">Material ID</th>
				<th style="width:24.7%;height:60px" class="degraD2">Description</th>			  
				<th style="width:14.7%;height:60px" class="degraD2">Calibration Date</th>					  
				<th style="width:19.8%;height:60px" class="degraD2">Certification ID </th>			  
				<th style="width:9.9%;height:60px" class="degraD2">Result</th>			  
						  
            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%">
<?php
   
   $x=0;	 
   $req= mysql_query("SELECT * FROM calibrage");
   
   while($data=@mysql_fetch_array($req))
    {
	$x++;
    $IDmat =$data['IDmat']; 	
	$req1= mysql_query("SELECT description FROM materiel where IDmat='$IDmat'");
	$des=mysql_result($req1,0);
	
	echo('<tr id='.$x.'>
	<td style="width:9%;height:60px;text-align:center" class="tdTab">'.$data['IDcal'].'</td>
	<td style="width:21%;height:60px;text-align:center" class="tdTab">'.$IDmat.'</td>
	<td  style="width:25%;height:60px;text-align:center">'.$des.'</td>
	<td  style="width:15%;height:60px;text-align:center">'.$data['dateC'].'</td>
	<td style="width:20%;height:60px;text-align:center">'.$data['certID'].'</td>

	<td style="width:10%;height:60px;text-align:center">'.$data['resultat'].'</td>

	');
	
	
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
                    </div>
                    </div>
</body>

</html>