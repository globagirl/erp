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
Liste des articles
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
			   
function excelArticle(){
	document.form1.action="../php/excel_consult_article.php";
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
}
elseif($role=="EXP"){
include('../menu/menuExpedition.php');	
}elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
else{
	 header('Location: ../deny.php');
}
?>
</div>
<div id='contenu'>


   <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Liste des articles </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>


<form  id="form1" name="form1" method="POST">
<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
         Liste des articles    
 </div>
 <div class="panel-body" >
 <?php 
include('../connexion/connexionDB.php');

?>
<div class="row">
          <div class="col-lg-12" >
		
		  <div class="pull-left col-lg-4">	

  
	
          <input type="text" class="search form-control"  placeholder="Search " id="search" name="search" onkeyup="mySearch()">
	
          </div>


 <div class="pull-right col-lg-1">
<img src="../image/excel.png" onclick="excelArticle();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p> 
 </div>

 </div>
                
					
						  
  <br><br>	
  <br><br>	
                             
                         
							



<div class="table-responsive col-lg-12" id="divRel">
<table class="table table-fixed table-bordered results" id="table3">
<thead style="width:100%">
          
			<tr>
               
				<th style="width:17.7%;height:60px" class="degraD2">Code article</th>
				<th style="width:19.5%;height:60px" class="degraD2">Description</th>			  
				<th style="width:21.5%;height:60px" class="degraD2">Fournisseur</th>					  
				<th style="width:9.7%;height:60px" class="degraD2">Prix unitaire</th>			  
				<th style="width:14.9%;height:60px" class="degraD2">Stock</th>			  
				<th style="width:14.9%;height:60px" class="degraD2">Valeur</th>			  
						  
            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%">
<?php
   $x=0;
		    
	 
   $req= mysql_query("SELECT * FROM article1");
   $nbrL=mysql_num_rows($req);
   while($data=@mysql_fetch_array($req))
    {
	$x++;
   
	$prixU=$data['prix'];
	$stock=$data['stock'];
	$val=$prixU*$stock;
	
	echo('<tr id='.$x.'>
	<td style="width:18%;height:60px;text-align:center ;background-color:#EFFBF2" class="tdTab">'.$data['code_article'].'</td>
	<td  style="width:20%;height:60px;text-align:center">'.$data['description'].'</td>
	<td  style="width:22%;height:60px;text-align:center">'.$data['supplier'].'</td>
	<td style="width:10%;height:60px;text-align:center;background-color:#F5ECCE">'.$data['prix'].' '.$data['devise'].'</td>
	<td style="width:15%;height:60px;text-align:center;background-color:#F8E6E0">'.$data['stock'].' '.$data['unit'].'</td>
	<td style="width:15%;height:60px;text-align:center;background-color:#F8E6E0">'.$val.' '.$data['devise'].'</td>

	');
	
	
	}
	mysql_close();
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