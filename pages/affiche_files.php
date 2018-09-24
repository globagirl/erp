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
<!--<meta name="viewport" content="width=device-width, initial-scale=1">
<!--<link href="../tablecloth/tablecloth.css" rel="stylesheet" type="text/css" media="screen" />
<!--<script type="text/javascript" src="tablecloth/tablecloth.js"></script> -->
<link rel="stylesheet" type="text/css" href="../css/style.css"/> 
<script src="../jquery/jquery-latest.min.js"></script>
<script type='text/javascript' src='../jquery/menu_jquery.js'></script>
<link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="../theme/dist/css/sb-admin2.css" rel="stylesheet">
<script src="../theme/dist/js/sb-admin-2.js"></script>
<script src="../bootstrap/js/bootstrap.min.js"></script>
<script src="../bootstrap/js/bootbox.min.js"></script>
<link href="../theme/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="../theme/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
 <script src="../theme/bower_components/metisMenu/dist/metisMenu.min.js"></script>
<script src="../JScolor/jscolor.js"></script>
<!--<script src="../ContextMenu/jquery.contextmenu.js"></script> 
<link rel="stylesheet" href="../ContextMenu/jquery.contextmenu.css">-->
<title>
RG45 Files
</title>
<SCRIPT> 
function deleteFile(f,t){


 if(confirm("Voulez-vous vraiment supprimer ce fichier?")){

 $.ajax({
          type: 'POST',
          data : 'F=' + f +'&T=' + t,
          url: '../php/delete_file.php',
          success: function(data) {
		     	
	       $("#divRel").load(location.href + " #divRel");
           }});
		   
 }
 }
	

//
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

</SCRIPT> 
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
elseif($role=="LOG"){
include('../menu/menuLogistique.php');	
}elseif($role=="DIR"){
include('../menu/menuDirecteur.php');	
}elseif($role=="QLT"){
include('../menu/menuQualite.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


<div class="container">


   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">RG45 files</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>



<div class="row">
 <div class="col-lg-12" >

 <?php 
include('../connexion/connexionDB.php');

?>
 <div class="row">
 <div class="col-lg-12" id="ALLfiles"> 
 <form  id="form1" name="form1">						  
  <br><br>	
                             
                         
							


<div class="col-lg-12" id="divRel">
  <ul class="nav nav-tabs">
                                <li class="active" onClick="afficheTT();"><a href="#Quality" data-toggle="tab">Quality </a>
                                </li>
                                <li onClick="afficheTT();"><a href="#Production" data-toggle="tab">Production</a></li>
                                <li onClick="afficheTT();"><a href="#Logistic" data-toggle="tab" >Logistic</a></li>
                                <li onClick="afficheTT();"><a href="#Direction" data-toggle="tab" >Direction</a></li>
                                <li onClick="afficheTT();"><a href="#Commercial" data-toggle="tab" >Commercial</a></li>
                                <li onClick="afficheTT();"><a href="#Maintenance" data-toggle="tab" >Maintenance</a></li>
                                <li onClick="afficheTT();"><a href="#GRH" data-toggle="tab" >Humain ressource</a></li>
                                <li onClick="afficheTT();"><a href="#IT" data-toggle="tab" >IT</a></li>
                               
  </ul>
<div class="tab-content">
<!--Quality-->
<div class="tab-pane fade in active" id="Quality" onClick="afficheTT();">


<div class="table-responsive">
<br><br>

 <div class="pull-left col-lg-4">		
          <input type="text" class="search form-control" id="search1" placeholder="Search " onkeyup="mySearch('search1')">
	
 </div>

		 

<br>
<br>
<br>
<br>
 <div class="col-lg-12">	
<table class="table table-fixed  results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:29.5%;height:30px">File name</th>
				<th style="width:29.5%;height:30px">Description</th>
				<th style="width:29.5%;height:30px">Path</th>			  
				<th style="width:5%;height:30px"></th>			  
				<th style="width:5%;height:30px"></th>			  
            </tr>
          </thead>
		   <tbody  style="width:100%">
		   <?php
		    $x=0;

	$req5= mysql_query("SELECT * FROM files_RG45 where dossier='Quality'");
	$T="files_RG45";
   while($a5=@mysql_fetch_object($req5))
    {
    $nameF = $a5->nameF;
    $desc = $a5->description;
	$dossierF= $a5->dossierF;
	$dataF= $a5->dataF;
	$x++;
	$nF=str_replace(' ','|',$nameF);
	echo('<tr class='.$x.'><td style="width:30%;height:60px">'.$nameF.'</td>
	<td  style="width:30%;height:60px">'.$desc.'</td>
	<td style="width:30%;height:60px">'.$dossierF.'</td>
	<td style="width:5%;height:60px"><a href="../files/managementFiles/'.$dossierF.'/'.$nameF.'"><img src="../image/viewFile.png" alt="Log Out" width="30" height="25"></a> </td>
	');
	echo ("<td style=\"text-align:center;width:5%;height:60px\"><a href=\"#\" onClick=deleteFile('".$nF."','".$T."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>");
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div> 
 <!--Production-->
<div class="tab-pane fade" id="Production" >
<div class="table-responsive">
<br><br>

 <div class="pull-left col-lg-4">		
          <input type="text" class="search form-control"  placeholder="Search " id="search2" onkeyup="mySearch('search2')">
	
 </div>

		 

<br>
<br>
<br>
<br>
 <div class="col-lg-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:29.5%;height:30px">File name</th>
				<th style="width:29.5%;height:30px">Description</th>
				<th style="width:29.5%;height:30px">Path</th>			  
				<th style="width:5%;height:30px"></th>			  
				<th style="width:5%;height:30px"></th>			  
            </tr>
          </thead>
		   <tbody style="width:100%">
		   <?php
		  
	

	$req5= mysql_query("SELECT * FROM files_RG45 where dossier='Production'");
	$T="files_RG45";
   while($a5=@mysql_fetch_object($req5))
    {
    $nameF = $a5->nameF;
    $desc = $a5->description;
	$dossierF= $a5->dossierF;
	$dataF= $a5->dataF;
	$x++;
	$nF=str_replace(' ','|',$nameF);
	echo('<tr class='.$x.'><td style="width:30%;height:60px">'.$nameF.'</td>
	<td  style="width:30%;height:60px">'.$desc.'</td>
	<td style="width:30%;height:60px">'.$dossierF.'</td>
	<td style="width:5%;height:60px"><a href="../files/managementFiles/'.$dossierF.'/'.$nameF.'"><img src="../image/viewFile.png" alt="Log Out" width="30" height="25"></a> </td>
	');
	echo ("<td style=\"text-align:center;width:5%;height:60px\"><a href=\"#\" onClick=deleteFile('".$nF."','".$T."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>");
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div>  
 
 <!--Logistic-->
<div class="tab-pane fade" id="Logistic">
<div class="table-responsive">
<br><br>

 <div class="pull-left col-lg-4">		
          <input type="text" class="search form-control" id="search3" placeholder="Search " onkeyup="mySearch('search3')">
	
 </div>

<br>
<br>
<br>
<br>
 <div class="col-lg-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:29.5%;height:30px">File name</th>
				<th style="width:29.5%;height:30px">Description</th>
				<th style="width:29.5%;height:30px">Path</th>			  
				<th style="width:5%;height:30px"></th>			  
				<th style="width:5%;height:30px"></th>			  
            </tr>
          </thead>
		   <tbody  style="width:100%">
		   <?php
		  
	

	$req5= mysql_query("SELECT * FROM files_RG45 where dossier='Logistic'");
	$T="files_RG45";
   while($a5=@mysql_fetch_object($req5))
    {
    $nameF = $a5->nameF;
    $desc = $a5->description;
	$dossierF= $a5->dossierF;
	$dataF= $a5->dataF;
	$x++;
	$nF=str_replace(' ','|',$nameF);
	echo('<tr class='.$x.'><td style="width:30%;height:60px">'.$nameF.'</td>
	<td  style="width:30%;height:60px">'.$desc.'</td>
	<td style="width:30%;height:60px">'.$dossierF.'</td>
	<td style="width:5%;height:60px"><a href="../files/managementFiles/'.$dossierF.'/'.$nameF.'"><img src="../image/viewFile.png" alt="Log Out" width="30" height="25"></a> </td>
	');
	echo ("<td style=\"text-align:center;width:5%;height:60px\"><a href=\"#\" onClick=deleteFile('".$nF."','".$T."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>");
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div> 
 
 <!--Direction-->
<div class="tab-pane fade" id="Direction">
<div class="table-responsive">
<br>
<br>

 <div class="pull-left col-lg-4">		
          <input type="text" class="search form-control" id="search4" placeholder="Search " onkeyup="mySearch('search4')">
	
 </div>

<br>
<br>
<br>
<br>
 <div class="col-lg-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:29.5%;height:30px">File name</th>
				<th style="width:29.5%;height:30px">Description</th>
				<th style="width:29.5%;height:30px">Path</th>			  
				<th style="width:5%;height:30px"></th>			  
				<th style="width:5%;height:30px"></th>			  
            </tr>
          </thead>
		   <tbody  style="width:100%">
		   <?php
		  
	

	$req5= mysql_query("SELECT * FROM files_RG45 where dossier='Direction'");
	$T="files_RG45";
   while($a5=@mysql_fetch_object($req5))
    {
    $nameF = $a5->nameF;
    $desc = $a5->description;
	$dossierF= $a5->dossierF;
	$dataF= $a5->dataF;
	$x++;
	$nF=str_replace(' ','|',$nameF);
	echo('<tr class='.$x.'><td style="width:30%;height:60px">'.$nameF.'</td>
	<td  style="width:30%;height:60px">'.$desc.'</td>
	<td style="width:30%;height:60px">'.$dossierF.'</td>
	<td style="width:5%;height:60px"><a href="../files/managementFiles/'.$dossierF.'/'.$nameF.'"><img src="../image/viewFile.png" alt="Log Out" width="30" height="25"></a> </td>
	');
	echo ("<td style=\"text-align:center;width:5%;height:60px\"><a href=\"#\" onClick=deleteFile('".$nF."','".$T."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>");
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div>  
 
 <!--Commercial-->
<div class="tab-pane fade" id="Commercial">
<div class="table-responsive">
<br>
<br>

 <div class="pull-left col-lg-4">		
          <input type="text" class="search form-control" id="search5" placeholder="Search " onkeyup="mySearch('search5')">
	
 </div>

<br>
<br>
<br>
<br>
 <div class="col-lg-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:29.5%;height:30px">File name</th>
				<th style="width:29.5%;height:30px">Description</th>
				<th style="width:29.5%;height:30px">Path</th>			  
				<th style="width:5%;height:30px"></th>			  
				<th style="width:5%;height:30px"></th>			  
            </tr>
          </thead>
		   <tbody  style="width:100%">
		   <?php
		  
	

	$req5= mysql_query("SELECT * FROM files_RG45 where dossier='Commercial'");
	$T="files_RG45";
   while($a5=@mysql_fetch_object($req5))
    {
    $nameF = $a5->nameF;
    $desc = $a5->description;
	$dossierF= $a5->dossierF;
	$dataF= $a5->dataF;
	$x++;
	$nF=str_replace(' ','|',$nameF);
	echo('<tr class='.$x.'><td style="width:30%;height:60px">'.$nameF.'</td>
	<td  style="width:30%;height:60px">'.$desc.'</td>
	<td style="width:30%;height:60px">'.$dossierF.'</td>
	<td style="width:5%;height:60px"><a href="../files/managementFiles/'.$dossierF.'/'.$nameF.'"><img src="../image/viewFile.png" alt="Log Out" width="30" height="25"></a> </td>
	');
	echo ("<td style=\"text-align:center;width:5%;height:60px\"><a href=\"#\" onClick=deleteFile('".$nF."','".$T."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>");
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div>  
 
 <!--Maintenance-->
<div class="tab-pane fade" id="Maintenance">
<div class="table-responsive">
<br>
<br>

 <div class="pull-left col-lg-4">		
          <input type="text" class="search form-control" id="search6" placeholder="Search " onkeyup="mySearch('search6')">
	
 </div>

<br>
<br>
<br>
<br>
 <div class="col-lg-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:29.5%;height:30px">File name</th>
				<th style="width:29.5%;height:30px">Description</th>
				<th style="width:29.5%;height:30px">Path</th>			  
				<th style="width:5%;height:30px"></th>			  
				<th style="width:5%;height:30px"></th>			  
            </tr>
          </thead>
		   <tbody  style="width:100%">
		   <?php

	

	$req5= mysql_query("SELECT * FROM files_RG45 where dossier='Maintenance'");
	$T="files_RG45";
   while($a5=@mysql_fetch_object($req5))
    {
    $nameF = $a5->nameF;
    $desc = $a5->description;
	$dossierF= $a5->dossierF;
	$dataF= $a5->dataF;
	$x++;
	$nF=str_replace(' ','|',$nameF);
	echo('<tr class='.$x.'><td style="width:30%;height:60px">'.$nameF.'</td>
	<td  style="width:30%;height:60px">'.$desc.'</td>
	<td style="width:30%;height:60px">'.$dossierF.'</td>
	<td style="width:5%;height:60px"><a href="../files/managementFiles/'.$dossierF.'/'.$nameF.'"><img src="../image/viewFile.png" alt="Log Out" width="30" height="25"></a> </td>
	');
	echo ("<td style=\"text-align:center;width:5%;height:60px\"><a href=\"#\" onClick=deleteFile('".$nF."','".$T."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>");
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div>  
 
 <!--GRH-->
<div class="tab-pane fade" id="GRH">
<div class="table-responsive">
<br>
<br>

 <div class="pull-left col-lg-4">		
          <input type="text" class="search form-control" id="search7" placeholder="Search " onkeyup="mySearch('search7')">
	
 </div>

<br>
<br>
<br>
<br>
 <div class="col-lg-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:29.5%;height:30px">File name</th>
				<th style="width:29.5%;height:30px">Description</th>
				<th style="width:29.5%;height:30px">Path</th>			  
				<th style="width:5%;height:30px"></th>			  
				<th style="width:5%;height:30px"></th>			  
            </tr>
          </thead>
		   <tbody  style="width:100%">
		   <?php
		 
	

	$req5= mysql_query("SELECT * FROM files_RG45 where dossier='GRH'");
	$T="files_RG45";
   while($a5=@mysql_fetch_object($req5))
    {
    $nameF = $a5->nameF;
    $desc = $a5->description;
	$dossierF= $a5->dossierF;
	$dataF= $a5->dataF;
	$x++;
	$nF=str_replace(' ','|',$nameF);
	echo('<tr class='.$x.'><td style="width:30%;height:60px">'.$nameF.'</td>
	<td  style="width:30%;height:60px">'.$desc.'</td>
	<td style="width:30%;height:60px">'.$dossierF.'</td>
	<td style="width:5%;height:60px"><a href="../files/managementFiles/'.$dossierF.'/'.$nameF.'"><img src="../image/viewFile.png" alt="Log Out" width="30" height="25"></a> </td>
	');
	echo ("<td style=\"text-align:center;width:5%;height:60px\"><a href=\"#\" onClick=deleteFile('".$nF."','".$T."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>");
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div> 

 <!--IT-->
<div class="tab-pane fade" id="IT">
<div class="table-responsive">
<br>
<br>
<div class="col-lg-4 pull-left" >
		
          <input type="text" class="search form-control" id="search8" placeholder="Search " onkeyup="mySearch('search8')">
	
 
</div>
<br>
<br>
<br>
<br>
 <div class="col-lg-12">	
<table class="table table-fixed results tabScroll">
<thead style="width:100%">
          
			<tr>
               <th style="width:29.5%;height:30px">File name</th>
				<th style="width:29.5%;height:30px">Description</th>
				<th style="width:29.5%;height:30px">Path</th>			  
				<th style="width:5%;height:30px"></th>			  
				<th style="width:5%;height:30px"></th>			  
            </tr>
          </thead>
		   <tbody  style="width:100%">
		   <?php
		 
	

	$req5= mysql_query("SELECT * FROM files_RG45 where dossier='IT'");
	$T="files_RG45";
   while($a5=@mysql_fetch_object($req5))
    {
    $nameF = $a5->nameF;
    $desc = $a5->description;
	$dossierF= $a5->dossierF;
	$dataF= $a5->dataF;
	$x++;
	$nF=str_replace(' ','|',$nameF);
	echo('<tr class='.$x.'><td style="width:30%;height:60px">'.$nameF.'</td>
	<td  style="width:30%;height:60px">'.$desc.'</td>
	<td style="width:30%;height:60px">'.$dossierF.'</td>
	<td style="width:5%;height:60px"><a href="../files/managementFiles/'.$dossierF.'/'.$nameF.'"><img src="../image/viewFile.png" alt="Log Out" width="30" height="25"></a> </td>
	');
	echo ("<td style=\"text-align:center;width:5%;height:60px\"><a href=\"#\" onClick=deleteFile('".$nF."','".$T."'); ><img src=\"../image/deleteFile.png\" alt=\"Log Out\" width=\"30\" height=\"30\"></a></td>
	</tr>");
	}

 

		   
		   ?>

           </tbody>
 </table>   
 </div> 
 </div> 
 </div> 
 </div> 
 </div> 
 </form>
 </div> 
 </div> 
 
</div> 

</div> <!--row-->
    </div>

                    </div>
                    </div>
                    </div>
               
             
     

</body>

</html>