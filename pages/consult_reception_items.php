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
Consulter reception
</title>
<SCRIPT> 

function mySearch() {
var searchTerm = $(".search").val();
searchTerm=searchTerm.toUpperCase();
var listItem = $('.results tbody').children('tr'); 
var jobCount = $('.results tbody').children('tr').length;
	 
 for (var iter = 1; iter <= jobCount; iter++) {

 var nIter1="#"+iter;
 var valeur=$(nIter1).html();
 //valeur=valeur.toUpperCase();
 if (valeur.indexOf(searchTerm) >= 0){
 $(nIter1).attr('visible','true');
 }else{
 $(nIter1).attr('visible','false');
  }
 }
}
			   
function excelReception(){
	document.form1.action="../php/excel_reception_items.php";
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

elseif($role=="COM"){
include('../menu/menuCommercial.php');	
}
elseif($role=="EXP"){
include('../menu/menuExpedition.php');	
}elseif($role=="FIN"){
include('../menu/menuFinance.php');	
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
                    <h1 class="page-header">Reception items </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>


<form  id="form1" name="form1" method="POST">
<div class="row">
 <div class="col-lg-12" >
 <div class="panel panel-default">
 <div class="panel-heading">
          Consult reception items     
 </div>
 <div class="panel-body" >

<div class="row">
          <div class="col-lg-12" >
		
		  <div class="pull-left col-lg-4">	

  
	
          <input type="text" class="search form-control"  placeholder="Search " id="search" name="search" onkeyup="mySearch()">
	
          </div>


 <div class="pull-right col-lg-1">
<img src="../image/excel.png" onclick="excelReception();" alt="Excel" style="cursor:pointer;" width="60" height="50"  /></p> 
 </div>

 </div>
                       
					
						  
  <br><br>	
  <br><br>	
                             
                         
							



<div class="table-responsive col-lg-12" id="divRel">
<table class="table table-fixed results" id="table3">
<thead style="width:100%">
          
			<tr>
               
				<th style="width:19.6%;height:60px">ID reception</th>
				<th style="width:17.7%;height:60px">ID ordre</th>			  
				<th style="width:21.6%;height:60px">Item</th>					  
				<th style="width:19.8%;height:60px">Date reception</th>			  
				<th style="width:9.9%;height:60px">Qty</th>			  
				<th style="width:9.9%;height:60px">Nbr box</th>			  
						  
            </tr>
          </thead>
		   <tbody id="tbody2" style="width:100%">
<?php
   $x=0;
		    
	 
   $req= mysql_query("SELECT * FROM reception  order by dateR DESC");
   $nbrL=mysql_num_rows($req);
   while($a=@mysql_fetch_object($req))
    {
	
    $IDreception =$a->IDreception;    
	$dateR=$a->dateR;
	
	
	$req1= mysql_query("SELECT * FROM reception_items where IDreception='$IDreception'");
	while($data=@mysql_fetch_array($req1)){
	$x++;
	echo('<tr id='.$x.'>
	<td style="width:20%;height:40px" class="tdTab">'.$IDreception.'</td>
	<td  style="width:18%;height:40px">'.$data['IDorder'].'</td>
	<td  style="width:22%;height:40px">'.$data['item'].'</td>
	<td style="width:20%;height:40px">'.$dateR.'</td>

	<td style="width:10%;height:40px">'.$data['qty'].'</td>
	<td style="width:10%;height:40px">'.$data['box'].'</td>

	');
	}
	
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